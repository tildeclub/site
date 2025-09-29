<?php
declare(strict_types=1);

/**
 * CSF deny list JSON API
 * - Outputs only JSON
 * - Locked down by IP allowlist (and optional token)
 * - Parses:
 *    - Single IP or CIDR (v4/v6), with optional trailing comment
 *    - Advanced rules: proto(s)|in/out|s/d=port(s)|s/d=ip
 */

////////////////////////////
// Bootstrap & headers
////////////////////////////
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store');

$env = loadEnv(__DIR__.'/.env');
$env += [
    'APP_ENV'        => 'prod',
    'DENY_FILE'      => '/etc/csf/csf.deny', // or full path to ".csfdeny"
    'ALLOW_IPS'      => '',                  // comma-separated allowlist
    'TRUST_PROXY'    => '0',                 // "1" to respect X-Forwarded-For from trusted proxies
    'TRUSTED_PROXIES'=> '',                  // comma-separated IPs/CIDRs of proxies
    'API_TOKEN'      => '',                  // optional shared token
];

if (($env['APP_ENV'] ?? 'prod') !== 'dev') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}
////////////////////////////
// Access control
////////////////////////////
$clientIp = resolveClientIp((bool)intval($env['TRUST_PROXY']), $env['TRUSTED_PROXIES']);
if (!ipAllowed($clientIp, $env['ALLOW_IPS'])) {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden', 'reason' => 'ip_not_allowed', 'client_ip' => $clientIp], JSON_UNESCAPED_SLASHES);
    exit;
}
if (($env['API_TOKEN'] ?? '') !== '' && !hash_equals($env['API_TOKEN'], $_SERVER['HTTP_X_API_TOKEN'] ?? '')) {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden', 'reason' => 'bad_token'], JSON_UNESCAPED_SLASHES);
    exit;
}

////////////////////////////
// Read & parse deny file
////////////////////////////
$file = $env['DENY_FILE'];
if (!is_readable($file)) {
    http_response_code(500);
    echo json_encode(['error' => 'unreadable_file', 'path' => $file], JSON_UNESCAPED_SLASHES);
    exit;
}

$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
$entries = [];
foreach ($lines as $rawLine) {
    $line = trim($rawLine);
    if ($line === '' || str_starts_with($line, '#')) {
        continue;
    }
    // Split off trailing comment after a space + '#'
    $comment = null;
    $hashPos = strpos($line, ' #');
    if ($hashPos !== false) {
        $comment = trim(substr($line, $hashPos + 2));
        $line    = trim(substr($line, 0, $hashPos));
    }

    $parsed = parseCsfLine($line);
    if ($parsed !== null) {
        $parsed['raw'] = $rawLine;
        if ($comment !== null) {
            $parsed['comment'] = $comment;
        }
        $entries[] = $parsed;
    }
}

////////////////////////////
// Output
////////////////////////////
echo json_encode([
    'generated_at' => gmdate('c'),
    'source'       => realpath($file) ?: $file,
    'count'        => count($entries),
    'entries'      => $entries,
], JSON_UNESCAPED_SLASHES);

/* -------------------- helpers -------------------- */

function loadEnv(string $path): array
{
    $out = [];
    if (!is_file($path) || !is_readable($path)) {
        return $out;
    }
    foreach (file($path, FILE_IGNORE_NEW_LINES) ?: [] as $l) {
        $l = trim($l);
        if ($l === '' || str_starts_with($l, '#')) { continue; }
        if (!str_contains($l, '=')) { continue; }
        [$k, $v] = array_map('trim', explode('=', $l, 2));
        $v = trim($v, " \t\n\r\0\x0B\"'");
        $out[$k] = $v;
    }
    return $out;
}

function resolveClientIp(bool $trustProxy, string $trustedProxiesCsv): string
{
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!$trustProxy) {
        return $remote;
    }
    $proxyList = array_filter(array_map('trim', explode(',', $trustedProxiesCsv ?: '')));
    // If the REMOTE_ADDR is not a trusted proxy, ignore forwarded headers
    if (!ipAllowed($remote, implode(',', $proxyList))) {
        return $remote;
    }
    $xff = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    if ($xff === '') {
        return $remote;
    }
    // pick the first IP in XFF chain
    $first = trim(explode(',', $xff)[0]);
    return filter_var($first, FILTER_VALIDATE_IP) ? $first : $remote;
}

function ipAllowed(string $ip, string $allowCsv): bool
{
    if ($allowCsv === '') {
        return false;
    }
    $allow = array_filter(array_map('trim', explode(',', $allowCsv)));
    foreach ($allow as $cidrOrIp) {
        if ($cidrOrIp === '') { continue; }
        if (str_contains($cidrOrIp, '/')) {
            if (ipInCidr($ip, $cidrOrIp)) { return true; }
        } else {
            if (hash_equals($cidrOrIp, $ip)) { return true; }
        }
    }
    return false;
}

function parseCsfLine(string $line): ?array
{
    // If it contains pipes, treat as advanced rule
    if (str_contains($line, '|')) {
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) < 2) {
            return null;
        }
        // proto(s)
        $protoRaw = strtolower($parts[0]);
        $protocols = array_filter(array_map('trim', explode('/', $protoRaw)));
        // direction
        $direction = strtolower($parts[1] ?? '');
        $srcIp = $dstIp = null;
        $srcPorts = $dstPorts = [];

        for ($i = 2; $i < count($parts); $i++) {
            $kv = explode('=', $parts[$i], 2);
            if (count($kv) !== 2) { continue; }
            [$key, $val] = [strtolower(trim($kv[0])), trim($kv[1])];
            if ($key === 's' || $key === 'src') {
                // src may be IP/CIDR or port list
                if (looksLikeIpOrCidr($val)) {
                    $srcIp = $val;
                } else {
                    $srcPorts = parsePortList($val);
                }
            } elseif ($key === 'd' || $key === 'dst') {
                if (looksLikeIpOrCidr($val)) {
                    $dstIp = $val;
                } else {
                    $dstPorts = parsePortList($val);
                }
            }
        }
        return [
            'type'      => 'rule',
            'protocols' => $protocols ?: ['tcp'],
            'direction' => in_array($direction, ['in','out'], true) ? $direction : 'in',
            'ports'     => ['source' => $srcPorts, 'dest' => $dstPorts],
            'source_ip' => $srcIp,
            'dest_ip'   => $dstIp,
        ];
    }

    // Plain IP or CIDR
    if (looksLikeIpOrCidr($line)) {
        // split ip/cidr
        $ip = $line;
        $cidr = null;
        if (str_contains($line, '/')) {
            [$ip, $mask] = explode('/', $line, 2);
            $ip = trim($ip);
            $cidr = (string)intval($mask);
        }
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return null;
        }
        return [
            'type' => ($cidr !== null ? 'cidr' : 'ip'),
            'ip'   => $ip,
            'cidr' => $cidr,
        ];
    }

    return null;
}

function looksLikeIpOrCidr(string $val): bool
{
    if (str_contains($val, '/')) {
        [$ip, $mask] = explode('/', $val, 2);
        return (bool)filter_var($ip, FILTER_VALIDATE_IP) && ctype_digit($mask);
    }
    return (bool)filter_var($val, FILTER_VALIDATE_IP);
}

function parsePortList(string $val): array
{
    $out = [];
    foreach (explode(',', $val) as $p) {
        $p = trim($p);
        if ($p === '') { continue; }
        // keep ranges as raw strings (e.g., "1000:2000"), normalize digits
        if (preg_match('/^\d+(:\d+)?$/', $p)) {
            $out[] = $p;
        }
    }
    return $out;
}

function ipInCidr(string $ip, string $cidr): bool
{
    [$subnet, $maskBits] = explode('/', $cidr, 2);
    $maskBits = (int)$maskBits;
    $ipBin = @inet_pton($ip);
    $subnetBin = @inet_pton($subnet);
    if ($ipBin === false || $subnetBin === false) {
        return false;
    }
    $len = strlen($ipBin);
    if ($len !== strlen($subnetBin)) {
        return false; // v4 vs v6 mismatch
    }
    $bytes = intdiv($maskBits, 8);
    $remainder = $maskBits % 8;

    if ($bytes > 0 && substr($ipBin, 0, $bytes) !== substr($subnetBin, 0, $bytes)) {
        return false;
    }
    if ($remainder === 0) {
        return true;
    }
    $mask = chr(0xFF << (8 - $remainder) & 0xFF);
    return (ord($ipBin[$bytes]) & ord($mask)) === (ord($subnetBin[$bytes]) & ord($mask));
}
