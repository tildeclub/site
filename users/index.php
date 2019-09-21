<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'tilde.club users';
include __DIR__.'/../header.php';
?>

<h1>full user list</h1>

<p>here's a full list of users (including those who haven't updated their page from the default)</p>

<p>see <a href="/~delfuego/tilde.24h.html">users who have updated their page in the last 24 hours</a></p>

<ol>
<?php foreach (glob("/home/*") as $user) {
	$user = basename($user); ?>
	<li><a href="/~<?=$user?>/">~<?=$user?></a></li>
<?php } ?>
</ol>

<?php
include __DIR__.'/../footer.php';

