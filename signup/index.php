<?php
$title = "sign up for the tilde.club!";
include __DIR__."/../header.php";
?>

<h1>devmode!! please do not use yet!!</h1>
<h1>sign up to join tilde.club</h1>

<p>we're excited you're here! let's get you signed up!</p>
<p>fill out this form and we'll get back to you with account info</p>

<table>
	<tr>
		<td>
			<form method="post">
			    <?php include 'signup-handler.php'; ?>

			    <div>
				    <p>your desired username (numbers and lowercase letters only, no spaces)</p>
				    <input class="form-control" name="username" value="<?=$_REQUEST["username"] ?? ""?>" type="text" required>
			    </div>

			    <div>
				<p>email to contact you with account info</p>
				<input class="form-control" name="email" value="<?=$_REQUEST["email"] ?? ""?>" type="text" required>
			    </div>

			    <div>
				<p>what interests you about tilde.club? we want to make sure you're a real human being :)</p>
				<textarea required class="form-control" name="interest" id="" cols="40" rows="7"><?=$_REQUEST["interest"] ?? ""?></textarea>
			    </div>

			    <div>
				<p>SSH public key</p>
				<textarea required class="form-control" name="sshkey" id="" cols="40" rows="10"><?=$_REQUEST["sshkey"] ?? ""?></textarea>
				<p>if you don't have a key, don't worry! <a href="https://tilde.club/wiki/ssh.html">check out our guide to ssh keys</a> and make sure that you only put your pubkey here</p>
			    </div>

			    <p>
				<em>signing up implies that you agree to abide by the rule of NO DRAMA</em>
				<br>
				no drama. be respectful. have fun. we're all trying, and we're all in this together :)
			    </p>

			    <button class="btn btn-primary" type="submit">submit</button>

			</form>

		</td>
	</tr>
</table>

<?php include __DIR__."/../footer.php";
