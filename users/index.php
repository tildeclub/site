<?php
$title = 'tilde.club users';
include __DIR__.'/../header.php';
?>
<h1 id="fancyboi">Tilde.club user list</h1>
<div class="grid">
	<div class="row">
		<div class="col">
			<p>Here is a full list of users (including those who haven't updated their page from the default)</p>
			<p>Also see users who have updated their page in the <a href="http://tilde.club/tilde.24h.php">last 24 hours</a></p>
			<br>
			<div class="user-list">
			<?php 
			foreach (glob("/home/*") as $user) 
			{
				$user = basename($user); 
				echo '<a href="/~'.$user.'/">'.$user.'</a>';
			} 
			?>
			</div>
		</div>
	</div>
</div>
<?php include __DIR__.'/../footer.php';
