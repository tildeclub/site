<?php 
$title = "tilde.club wiki";
include __DIR__."/../header.php";
?>

<h1>the tilde.club wiki</h1>

<p>here's the articles on our wiki:</p>
<ul>
<?php foreach (glob("source/*.md") as $article) {
	$article = basename($article, ".md"); ?>
	<li><a href="/wiki/<?=$article?>.html"><?=$article?></a></li>
<?php } ?>
</ul>

<?php include __DIR__."/../footer.php";

