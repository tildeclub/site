<?php
$title = "sign up for the tilde.club!";
include __DIR__."/../header.php";

function esc($v) {
    return isset($_REQUEST[$v]) ? htmlspecialchars($_REQUEST[$v]) : "";
}
?>

<h1 id="fancyboi">sign up to join tilde.club</h1>


	<div class="grid">
		<div class="row">

			<div class="col">

<p>we're excited you're here! let's get you signed up!</p>
<p>fill out this form and we'll get back to you with account info</p>
<p><strong>(GMail currently not accepting our emails. Add root@tilde.club to whitelist)</strong></p>


<table>
	<tr>
		<td>
			<form method="post">
			    <?php include 'signup-handler.php'; ?>

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

			    <button class="btn btn-primary" type="submit">submit</button>

			</form>

		</td>
	</tr>
</table>

	</div>
</div>

<?php include __DIR__."/../footer.php";
