<?php
$filepath = __FILE__;
# require __DIR__.'/../vendor/autoload.php';
require_once "email/smtp.php";

function getUserIpAddr() {
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function add_ban_info($name, $email): void
{
    $user_ip = getUserIpAddr();
    $user_info = "$name - $email - $user_ip";
    file_put_contents("/var/signups_banned", $user_info.PHP_EOL, FILE_APPEND);
}

function is_ssh_pubkey($string): bool
{
    // list from sshd(8)
    $valid_pubkeys = [
        'sk-ecdsa-sha2-nistp256@openssh.com',
        'ecdsa-sha2-nistp256',
        'ecdsa-sha2-nistp384',
        'ecdsa-sha2-nistp521',
        'sk-ssh-ed25519@openssh.com',
        'ssh-ed25519',
        'ssh-dss',
        'ssh-rsa',
    ];

    foreach ($valid_pubkeys as $pub)
        if (str_starts_with($string, $pub)) return true;

    return false;
}

function forbidden_name($name): bool
{
    $badnames = [
        '0x0',
        'abuse',
        'admin',
        'administrator',
        'auth',
        'autoconfig',
        'bbj',
        'broadcasthost',
        'cloud',
        'forum',
        'ftp',
        'git',
        'gopher',
        'hostmaster',
        'imap',
        'info',
        'irc',
        'is',
        'isatap',
        'it',
        'localdomain',
        'localhost',
        'lounge',
        'mail',
        'mailer-daemon',
        'marketing',
        'marketting',
        'mis',
        'news',
        'nobody',
        'noc',
        'noreply',
        'pop',
        'pop3',
        'postmaster',
        'retro',
        'root',
        'sales',
        'security',
        'smtp',
        'ssladmin',
        'ssladministrator',
        'sslwebmaster',
        'support',
        'sysadmin',
        'team',
        'usenet',
        'uucp',
        'webmaster',
        'wpad',
        'www',
        'znc',
    ];

    return in_array(
        $name,
        array_merge(
            $badnames,
            file("/var/signups_current", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES),
            file("/var/banned_names.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
        )
    );
}

function forbidden_email($email): bool
{
    $femail = file("/var/banned_emails.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return in_array($email, $femail);
}

function forbidden_sshkey($sshkey): bool
{
    $fsshkey = file("/var/banned_sshkeys.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $fsk = [];
    foreach ($fsshkey as $line) {
        $fsk_line = explode(' ',trim($line));
        $fsk[] = $fsk_line[1];
    }

    $sk = explode(' ',trim($sshkey));

    return in_array($sk[1], $fsk);
}


$message = "";
if (isset($_REQUEST["username"]) && isset($_REQUEST["email"])) {
    // Check the name.
    $name = trim($_REQUEST["username"]);
    if ($name == "")
        $message .= "<li>fill in your desired username</li>\n";
    else {
        if (strlen($name) < 2)
            $message .= "<li>username is too short (2 character min)</li>\n";

        if (strlen($name) > 32)
            $message .= "<li>username too long (32 character max)</li>\n";

        if (strlen($name) > 1 && !preg_match('/^[a-z][a-z0-9]{1,31}$/', $name))
            $message .= "<li>username contains invalid characters (lowercase only, must start with a letter).</li>\n";

        if (posix_getpwnam($name) || forbidden_name($name))
            $message .= "<li>sorry, the username $name is unavailable</li>\n";
    }

    // Check the e-mail address.
    $email = trim($_REQUEST["email"]);
    if ($email == "")
        $message .= "<li>please fill in your email address</li>";
    else {
        $result = SMTP::MakeValidEmailAddress($_REQUEST["email"]);
        if (!$result["success"])
            $message .= "<li>invalid email address: " . htmlspecialchars($result["error"]) . "</li>";
        elseif ($result["email"] != $email)
            $message .= "<li>invalid email address. did you mean:  " . htmlspecialchars($result["email"]) . "</li>";

        elseif ($name != "" && forbidden_email($email)) {
            $message .= "<li>your email is banned!</li><br />";
            add_ban_info($name, $email);
        }
    }

    if ($_REQUEST["interest"] == "")
        $message .= "<li>please explain why you're interested so we can make sure you're a real human being</li>";

    $sshkey = trim($_REQUEST["sshkey"]);
    if ($sshkey == "" || !is_ssh_pubkey($sshkey))
        $message .= '<li>ssh key required: please create one and submit the public key. '
        . 'see our <a href="https://tilde.club/wiki/ssh">ssh wiki</a> or '
        . 'hop on <a href="https://web.newnet.net/?join=club">irc</a> and ask for help</li>';
    else {
        if ($name != "" && $email != "") {
            if (forbidden_sshkey($sshkey)) {
                $message .= "<li>your sshkey is banned!</li>\n";
                add_ban_info($name, $email);
            }
        }
    }


    // no validation errors
    if ($message == "") {
        $makeuser = "makeuser {$_REQUEST["username"]} {$_REQUEST["email"]} \"$sshkey\"";

        $msgbody = "
username: {$_REQUEST["username"]}
email: {$_REQUEST["email"]}
reason: {$_REQUEST["interest"]}

$makeuser
";

        if (mail('root', 'new tilde.club signup', $msgbody)) {
            echo '<div class="alert alert-success" role="alert">
                email sent! we\'ll get back to you soon with login instructions! (timeframe for processing signups varies greatly) <a href="/">back to tilde.club home</a>
                </div>';
            // temp. add to forbidden to prevent double signups (cleanup after user creation)
            file_put_contents("/var/signups_current", $name.PHP_EOL, FILE_APPEND);
            file_put_contents("/var/signups", $makeuser.PHP_EOL, FILE_APPEND);
            // clear form fields
            $_REQUEST["email"] = $_REQUEST["username"] = $_REQUEST["sshkey"] = $_REQUEST["interest"] = "";
        } else {
            echo '<div class="alert alert-danger" role="alert">
                something went wrong... please send an email to <a href="mailto:root@tilde.club">root@tilde.club</a> with details of what happened
                </div>';
        }

    } else {
?>
        <div class="alert alert-warning" role="alert">
            <strong>notice: </strong>
            <?=$message?>
        </div>
<?php
    }
}
?>
