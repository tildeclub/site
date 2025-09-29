<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

$title = "sign up for the tilde.club!";
include __DIR__."/../header.php";

function esc($v) {
    return isset($_REQUEST[$v]) ? htmlspecialchars($_REQUEST[$v]) : "";
}

function isGmail($email) {
    return substr(strrchr($email, "@"), 1) === 'gmail.com';
}

$gmailError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isGmail($_REQUEST['email'])) {
        $gmailError = true;
    } else {
        // Process the form here only if the email is not a Gmail address
        include 'signup-handler.php';
    }
}
?>
            <?php if ($gmailError): ?>
                <div class="alert alert-warning">
                    <strong>We don't accept Gmail addresses due to Google not allowing emails to go through due to a recent spam issue.</>                </div>
            <?php endif; ?>

<h1 id="fancyboi">sign up to join tilde.club</h1>

<div class="grid">
    <div class="row">
        <div class="col">
            <p>We're excited you're here! Let's get you signed up!</p>
            <p>Fill out this form and we'll get back to you with account info</p>
            <form method="post">
			    <div>
				    <p>your desired username (numbers and lowercase letters only, no spaces)</p>
				    <input class="form-control" name="username" value="<?=esc("username")?>" type="text" required>
			    </div>

			    <div>
				<p>email to contact you with account info</p>
				<input class="form-control" name="email" value="<?=esc("email")?>" type="text" required>
			    </div>

			    <div>
				<p>what interests you about tilde.club? we want to make sure you're a real human being :)</p>
				<textarea required class="form-control" name="interest" id="" cols="40" rows="7"><?=esc("interest")?></textarea>
			    </div>

			    <div>
				<p>SSH public key</p>
				<textarea required class="form-control" name="sshkey" id="" cols="40" rows="10"><?=esc("sshkey")?></textarea>
				<p>if you don't have a key, don't worry! <a href="https://tilde.club/wiki/ssh.html">check out our guide to ssh keys</a> and make sure that you only put your pubkey here</p>
			    </div>

			    <p>
				<em>signing up implies that you agree to abide by <a href="/wiki/code-of-conduct.html">our code of conduct</a></em>
				<br>
				no drama. be respectful. have fun. we're all trying, and we're all in this together :)
			    </p>
                            <p>you must be at least 13 years or older to sign up and use tilde.club.</p>

                            <button class="btn btn-primary" type="submit">Submit</button>

			</form>

		</td>
	</tr>
</table>

	</div>
</div>

<?php include __DIR__."/../footer.php";
