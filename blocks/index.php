<?php
declare(strict_types=1);

/**
 * CSF deny list JSON API
 * - Outputs only JSON
 * - Locked down by IP allowlist and optional token
 * - Supports IPv4, IPv6, IPv4-mapped IPv6, and CIDR ranges
 * - Parses:
 *    - Single IP or CIDR, with optional trailing comment
 *    - Advanced rules: proto(s)|in/out|s/d=port(s)|s/d=ip
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store');

$env = loadEnv(__DIR__ . '/.env');
$env += [
    'APP_ENV'         => 'prod',
    'DENY_FILE'       => '/etc/csf/csf.deny',
    'ALLOW_IPS'       => '',
    'TRUST_PROXY'     => '0',
    'TRUSTED_PROXIES' => '',
    'API_TOKEN'       => '',
];

if (($env['APP_ENV'] ?? 'prod') !== 'dev') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

$clientIp = resolveClientIp((bool) intval($env['TRUST_PROXY']), $env['TRUSTED_PROXIES']);

if (!ipAllowed($clientIp, $env['ALLOW_IPS'])) {
    http_response_code(403);
    echo json_encode([
        'error' => 'forbidden',
        'reason' => 'ip_not_allowed',
        'client_ip' => canonicalIp($clientIp) ?? $clientIp,
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

if (($env['API_TOKEN'] ?? '') !== '' && !hash_equals($env['API_TOKEN'], $_SERVER['HTTP_X_API_TOKEN'] ?? '')) {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden', 'reason' => 'bad_token'], JSON_UNESCAPED_SLASHES);
    exit;
}

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

    $comment = null;
    $hashPos = strpos($line, ' #');

    if ($hashPos !== false) {
        $comment = trim(substr($line, $hashPos + 2));
        $line = trim(substr($line, 0, $hashPos));
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

echo json_encode([
    'generated_at' => gmdate('c'),
    'source' => realpath($file) ?: $file,
    'count' => count($entries),
    'entries' => $entries,
], JSON_UNESCAPED_SLASHES);

/* -------------------- helpers -------------------- */

function loadEnv(string $path): array
{
    $out = [];

    if (!is_file($path) || !is_readable($path)) {
        return $out;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $out[$key] = trim($value, " \t\n\r\0\x0B\"'");
    }

    return $out;
}

function resolveClientIp(bool $trustProxy, string $trustedProxiesCsv): string
{
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';

    if (!$trustProxy) {
        return canonicalIp($remote) ?? $remote;
    }

    if (!ipAllowed($remote, $trustedProxiesCsv)) {
        return canonicalIp($remote) ?? $remote;
    }

    $xff = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';

    if ($xff === '') {
        return canonicalIp($remote) ?? $remote;
    }

    $first = trim(explode(',', $xff)[0]);

    return canonicalIp($first) ?? canonicalIp($remote) ?? $remote;
}

function ipAllowed(string $ip, string $allowCsv): bool
{
    if (trim($allowCsv) === '') {
        return false;
    }

    $client = parseIpOrCidr($ip);

    if ($client === null || $client['cidr'] !== null) {
        return false;
    }

    foreach (array_filter(array_map('trim', explode(',', $allowCsv))) as $allowed) {
        $entry = parseIpOrCidr($allowed);

        if ($entry === null) {
            continue;
        }

        if ($entry['cidr'] !== null) {
            if (ipInCidr($client['ip'], $entry['ip'] . '/' . $entry['cidr'])) {
                return true;
            }

            continue;
        }

        if ($client['family'] === $entry['family'] && hash_equals($entry['ip'], $client['ip'])) {
            return true;
        }
    }

    return false;
}

function parseCsfLine(string $line): ?array
{
    if (str_contains($line, '|')) {
        $parts = array_map('trim', explode('|', $line));

        if (count($parts) < 2) {
            return null;
        }

        $protocols = array_values(array_filter(array_map(
            static fn (string $proto): string => strtolower(trim($proto)),
            explode('/', $parts[0])
        )));

        $direction = strtolower($parts[1] ?? '');
        $srcIp = null;
        $dstIp = null;
        $srcPorts = [];
        $dstPorts = [];

        for ($i = 2; $i < count($parts); $i++) {
            $kv = explode('=', $parts[$i], 2);

            if (count($kv) !== 2) {
                continue;
            }

            [$key, $value] = [strtolower(trim($kv[0])), trim($kv[1])];
            $ipOrCidr = parseIpOrCidr($value);

            if ($key === 's' || $key === 'src') {
                if ($ipOrCidr !== null) {
                    $srcIp = formatIpOrCidr($ipOrCidr);
                } else {
                    $srcPorts = parsePortList($value);
                }
            } elseif ($key === 'd' || $key === 'dst') {
                if ($ipOrCidr !== null) {
                    $dstIp = formatIpOrCidr($ipOrCidr);
                } else {
                    $dstPorts = parsePortList($value);
                }
            }
        }

        return [
            'type' => 'rule',
            'protocols' => $protocols ?: ['tcp'],
            'direction' => in_array($direction, ['in', 'out'], true) ? $direction : 'in',
            'ports' => ['source' => $srcPorts, 'dest' => $dstPorts],
            'source_ip' => $srcIp,
            'dest_ip' => $dstIp,
        ];
    }

    $parsed = parseIpOrCidr($line);

    if ($parsed === null) {
        return null;
    }

    return [
        'type' => $parsed['cidr'] !== null ? 'cidr' : 'ip',
        'family' => $parsed['family'],
        'ip' => $parsed['ip'],
        'cidr' => $parsed['cidr'],
    ];
}

function parseIpOrCidr(string $value): ?array
{
    $value = trim($value);

    if ($value === '') {
        return null;
    }

    $cidr = null;
    $ip = $value;

    if (str_contains($value, '/')) {
        [$ip, $mask] = explode('/', $value, 2);
        $ip = trim($ip);
        $mask = trim($mask);

        if ($mask === '' || !ctype_digit($mask)) {
            return null;
        }

        $cidr = (int) $mask;
    }

    $ip = trim($ip);

    if (str_starts_with($ip, '[') && str_ends_with($ip, ']')) {
        $ip = substr($ip, 1, -1);
    }

    $packed = @inet_pton($ip);

    if ($packed === false) {
        return null;
    }

    $isMappedIpv4 = isIpv4MappedIpv6($packed);

    if ($isMappedIpv4) {
        $ip = inet_ntop(substr($packed, 12));
        $family = 'ipv4';
        $maxMask = 32;

        if ($cidr !== null) {
            if ($cidr < 96 || $cidr > 128) {
                return null;
            }

            $cidr -= 96;
        }
    } else {
        $ip = inet_ntop($packed);
        $family = strlen($packed) === 4 ? 'ipv4' : 'ipv6';
        $maxMask = $family === 'ipv4' ? 32 : 128;
    }

    if ($ip === false) {
        return null;
    }

    if ($cidr !== null && ($cidr < 0 || $cidr > $maxMask)) {
        return null;
    }

    return [
        'ip' => $ip,
        'cidr' => $cidr !== null ? (string) $cidr : null,
        'family' => $family,
    ];
}

function canonicalIp(string $ip): ?string
{
    $parsed = parseIpOrCidr($ip);

    if ($parsed === null || $parsed['cidr'] !== null) {
        return null;
    }

    return $parsed['ip'];
}

function formatIpOrCidr(array $parsed): string
{
    return $parsed['cidr'] === null
        ? $parsed['ip']
        : $parsed['ip'] . '/' . $parsed['cidr'];
}

function isIpv4MappedIpv6(string $packed): bool
{
    return strlen($packed) === 16
        && substr($packed, 0, 10) === str_repeat("\x00", 10)
        && substr($packed, 10, 2) === "\xff\xff";
}

function looksLikeIpOrCidr(string $value): bool
{
    return parseIpOrCidr($value) !== null;
}

function parsePortList(string $value): array
{
    $out = [];

    foreach (explode(',', $value) as $port) {
        $port = trim($port);

        if ($port === '') {
            continue;
        }

        if (preg_match('/^\d+(:\d+)?$/', $port) === 1) {
            $out[] = $port;
        }
    }

    return $out;
}

function ipInCidr(string $ip, string $cidr): bool
{
    $client = parseIpOrCidr($ip);
    $range = parseIpOrCidr($cidr);

    if ($client === null || $range === null || $range['cidr'] === null) {
        return false;
    }

    if ($client['family'] !== $range['family']) {
        return false;
    }

    $ipBin = @inet_pton($client['ip']);
    $subnetBin = @inet_pton($range['ip']);

    if ($ipBin === false || $subnetBin === false) {
        return false;
    }

    if (strlen($ipBin) !== strlen($subnetBin)) {
        return false;
    }

    $maskBits = (int) $range['cidr'];
    $bytes = intdiv($maskBits, 8);
    $remainder = $maskBits % 8;

    if ($bytes > 0 && substr($ipBin, 0, $bytes) !== substr($subnetBin, 0, $bytes)) {
        return false;
    }

    if ($remainder === 0) {
        return true;
    }

    if (!isset($ipBin[$bytes], $subnetBin[$bytes])) {
        return false;
    }

    $mask = 0xff << (8 - $remainder) & 0xff;

    return (ord($ipBin[$bytes]) & $mask) === (ord($subnetBin[$bytes]) & $mask);
}
