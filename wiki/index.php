<?php 
$title = "tilde.club wiki";
include __DIR__."/../header.php";
?>

<h1>the tilde.club wiki</h1>

<p>here's the articles on our wiki:</p>
<ul>
	<?php foreach (glob("source/*.md") as $file) {
		$article = basename($file, ".md"); 
		$title = preg_match("/title: (.*)/i", file_get_contents($file), $matches) 
			? $matches[1] : $article;
	?>
		<li><a href="/wiki/<?=$article?>.html"><?=$title?></a></li>
	<?php } ?>
</ul>

<?php include __DIR__."/../footer.php";

