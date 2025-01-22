<?php 
$title = "tilde.club wiki";
include __DIR__."/../header.php";
?>
<h1 id="fancyboi">the tilde.club wiki</h1>
	<div class="grid">
		<div class="row">
			<div class="col">
			<p>Here's the articles on our wiki:</p>
			<ul>
			<?php 
			// category order
			$order = ['tilde.club', 'tutorials', 'software', 'links'];

            $category_to_articles = [];

			// get articles
			foreach (glob("source/*.md") as $file) 
			{
                $article = basename($file, ".md");
				$title = preg_match("/title: (.*)/i", file_get_contents($file), $matches) ? $matches[1] : $article;
				$category = preg_match("/category: (.*)/i", file_get_contents($file), $matches) ? $matches[1] : 'default';

				if (array_key_exists($category, $category_to_articles)) 
					array_push($category_to_articles[$category], [$article, $title]);
				else 
					$category_to_articles[$category] = [[$article, $title]];
				
                ksort($category_to_articles);
			}

			foreach ($order as $category) 
			{
				echo '<li>'.ucwords($category).'</li>';
				echo '<ul>';
        
				$article_titles = [];
				$article_names = [];
				
				foreach ($category_to_articles[$category] as $article) 
				{
					array_push($article_names, $article[0]);
					array_push($article_titles, $article[1]);
				}

				$name_to_title = array_combine($article_names, $article_titles);
                asort($name_to_title);
				
				foreach ($name_to_title as $name => $title) 
					echo '<li><a href="/wiki/'.$name.'.html">'.$title.'</a></li>';
		
				echo '</ul><br>';

			} 
			?>
		</ul>
	</div>
</div>
<?php include "../footer.php"; 
