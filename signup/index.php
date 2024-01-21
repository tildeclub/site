<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = "Sign up for the tilde.club!";
include __DIR__."/../header.php";

function esc($v) {
    return isset($_REQUEST[$v]) ? htmlspecialchars($_REQUEST[$v]) : "";
}

function isGmail($email) {
    return strpos($email, '@gmail.com') !== false;
}

$gmailError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = esc('email');
    if (isGmail($email)) {
        $gmailError = true;
    } else {
        // Process the form here
        include 'signup-handler.php';
    }
}
?>

<h1 id="fancyboi">Sign up to join tilde.club</h1>

<div class="grid">
    <div class="row">
        <div class="col">
            <p>We're excited you're here! Let's get you signed up!</p>
            <p>Fill out this form and we'll get back to you with account info.</p>
            <?php if ($gmailError): ?>
                <p><strong>We don't accept Gmail addresses due to Google not allowing emails to go through due to a recent spam issue.</strong></p>
            <?php else: ?>

            <form method="post">
                <div>
                    <p>Your desired username (numbers and lowercase letters only, no spaces)</p>
                    <input class="form-control" name="username" value="<?= esc("username") ?>" type="text" required>
                </div>

                <div>
                    <p>Email to contact you with account info</p>
                    <input class="form-control" name="email" value="<?= esc("email") ?>" type="text" required>
                </div>

                <!-- Rest of your form fields -->

                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__."/../footer.php";
