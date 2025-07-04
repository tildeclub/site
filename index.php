<?php 
include "header.php"; 

// Display notice message based on query parameters
if (isset($_GET['notice'])) {
    $notice = htmlspecialchars($_GET['notice']);
    if ($notice == 'cancel') {
        echo '<div class="notice-message">Your transaction was canceled.</div>';
    } elseif ($notice == 'thanks') {
        echo '<div class="notice-message">Thank you for helping this great service continue to exist!</div>';
    }
}
?>
<h1 id="fancyboi">welcome to Tilde.club</h1>

<p><a href="/wiki/faq.html">Questions? See the official FAQ.</a></p>

<!-- <p class="advisory">GMAIL USERS: We no longer accept gmail.com addresses for signups since you would not receive your account information email.</p> -->
<!-- Active Users Scrolling List -->
<div id="active-users">
    <h2>Currently Active Users:</h2>
	<?php
	$activeUsers = json_decode(file_get_contents('/usr/share/nginx/html/online-users.json'), true);

	if (!empty($activeUsers)) 
	{
		echo '<marquee scrollamount="2">';

		foreach ($activeUsers as $user) 
		{
			$username = htmlspecialchars($user);
			echo "<a href='/~$username'>$username</a> &nbsp;";
		}

		echo '</marquee>';
	} 
	else 
	{
		echo "<li>No active users at the moment.</li>";
	}
	?>
</div>
<div class="grid">
    <div class="row">

        <div id="news" class="col">
            <?php
            $news = json_decode(file_get_contents('news.json'), true);

            // Sort news items by date, most recent first
            usort($news, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            // Determine the year filter if present
            $selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
            $filteredNews = [];
            $currentDate = new DateTime();

            foreach ($news as $newsItem) {
                $newsDate = new DateTime($newsItem['date']);

                // Only add to filteredNews if the current date is on or after the news date
                if ($newsDate <= $currentDate) {
                    if ($selectedYear) {
                        // If filtering by year, add items from the selected year only
                        if (date('Y', strtotime($newsItem['date'])) == $selectedYear) {
                            $filteredNews[] = $newsItem;
                        }
                    } else {
                        // Otherwise, show the most recent 2 items
                        $filteredNews[] = $newsItem;
                    }
                }

                if (!$selectedYear && count($filteredNews) >= 2) {
                    break;
                }
            }

            // Display news items
            foreach ($filteredNews as $newsItem) {
                echo '<div class="news-item">';

                echo '<div class="news-item-title">';
                echo '<h2>' . htmlspecialchars($newsItem['title']) . ':</h2>';
                echo '<h3>' . htmlspecialchars($newsItem['heading']) . '</h3>';
                echo '</div>';

                echo '<div class="news-item-body">';
                echo '<p>' . htmlspecialchars($newsItem['content']) . '</p>';

                if (isset($newsItem['details']) && is_array($newsItem['details'])) {
                    echo '<ul>';
                    foreach ($newsItem['details'] as $detail) {
                        echo '<li>' . htmlspecialchars($detail) . '</li>';
                    }
                    echo '</ul>';
                }

                if (isset($newsItem['note'])) {
                    echo '<p><strong>' . htmlspecialchars($newsItem['note']) . '</strong></p>';
                }

                if (isset($newsItem['additional_content'])) {
                    echo '<p>' . htmlspecialchars($newsItem['additional_content']) . '</p>';
                }
                echo '</div>';

                echo '</div>';
                echo '<hr>';
            }

            // Display year links for filtering
            $years = array_unique(array_map(function ($newsItem) {
                return date('Y', strtotime($newsItem['date']));
            }, $news));
            sort($years);

            echo '<div><strong>View news by year:</strong> ';
            foreach ($years as $year) {
                echo '<a href="?year=' . $year . '">' . $year . '</a> ';
            }
            echo '</div>';
            ?>
        </div>
        
        <div class="col">
            <p>
            Tilde.club gives you access to a shared Unix computer 
            where you can make web pages, learn, and share knowledge.
	    It's a place where working together happens naturally, 
	    all within a friendly and supportive setting.
            </p>

            <p>
            If you would like a list of <a href="http://tilde.club/tilde.24h.php">
                RECENTLY CHANGED PAGES</a> you can see that too
            </p>
            <p>
                Or Check out the <a href="https://tilde.club/~tweska/gallery" target="blank">Tilde.club gallery</a> created by <a href="/~tweska" target="_blank">~tweska</a>
            </p>

            <hr>
            <h2>Tilde.club gold star supporters</h2>
            <p>Tilde.club is supported by a global community of
            good people. We don't rank people by the amount
            they give, only by the fact that they gave.
            Here's who has donated! When you're on the
            server, THANK THEM.</p>
            <?php
            $supporters = json_decode(file_get_contents('supporters.json'), true);
            usort($supporters, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            $showAll = isset($_GET['show_all']) && $_GET['show_all'] == 'true';
            $supportersToShow = $showAll ? $supporters : array_slice($supporters, 0, 10);
            ?>

            <ul>
                <?php foreach ($supportersToShow as $supporter): ?>
                    <li><?= htmlspecialchars($supporter['date']) ?> | <a href="<?= htmlspecialchars($supporter['url']) ?>"><?= htmlspecialchars($supporter['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>

            <?php if (!$showAll): ?>
                <p><a href="?show_all=true">Show all supporters</a></p>
            <?php else: ?>
                <p><a href="?show_all=false">Show only the 10 most recent supporters</a></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>Here are the home pages of our users</h3>
            <p>This list does not include people who haven't changed their page yet.</p>
            <p>If you're not seeing yourself listed here, change your page from the default.</p>
            <p>Users with recently updated pages are highlighted in a lighter color.</p>
            <p><a href="/users/">List all users</a></p>
			<?php
			// these are the hashes of previous and current default pages
			$page_shas = [
				"0eb53dab435e2e6e401921146bed85a80e9ad3a1",
				"61eff8202777bae134ac4b11f1e16ec23dfc97d3",
				"e9d41eab6edb7cd375c63ecb4a23bca928992547",
				"cb2ce535ab34edebc225e88a321f972ba55763c3",
				"13af6898f536265af7dbbe2935b591f5e2ee0d7d",
				"b0eb2bf442e52b98714456b2f8a6662ba4c1f443",
				"0b4f272852e3391e97f0ebb7b5d734a765958eeb",
				"59e857ec585d6d34ed21e027164b3c3c36a95f0f",
				"9da422e8759799cce29327024fc77b6aa2ace484",
				"e5da596bd5f72aa583839bcefd28e988c9d4fcbe",
				"adc83b19e793491b1c6ea0fd8b46cd9f32e592fc",
				"3f51b25206c137593124a16d8b881079352cd1c4",
				"051b45fb2da9b15c523dfafd2a1dd33cc8b54e87",
				"5a1cf2f88acb15da43f5d18a13fe638d175a44cc",
				"0066d512c24f4ada7ad925fd0856b6b68334a93c",
				"da39a3ee5e6b4b0d3255bfef95601890afd80709",
				"f032fa07b3f4d9c1264a5a9369bff19f231bff45",
				"259969faeba97eb16a675bb66427efd168406c92",
				"75b7ce715379312bcc0b24696b9406e10b97cedc",
				"e28aa091c26528a4084b8fad2a2ddb72bee3db75",
				"12608ff7f6d222d97d2e02c1a13496e1d79713bb",
				"22d29b83dc93b925bee08d090b0ea0fffdeb57f2",
				"4706d8acdd74efd5c6d8f9e69ec215928d9ff165",
				"385212d5ea557a21b77af992ea1b3c1ea71d22c9",
				"b51a889545b5f065fd1ac2b8760cab0088a9dc22"
			];

			// Retrieve from cache file if available
			$cache_file = 'cache/homepages_list.html';

			if (file_exists($cache_file) and time() - filemtime($cache_file) < 86400)
			{
				$homepagesOutput = file_get_contents($cache_file);
			}

			// Cache not available or expired - create list
			else
			{
				$homepagesOutput = '<div class="user-list">';
				$now = time();

				foreach (glob("/home/*") as $user) 
				{
					// Look for index files with common extensions
					$indexFiles = glob("$user/public_html/index.{html,htm,php}", GLOB_BRACE);
					$index = count($indexFiles) > 0 ? $indexFiles[0] : null;

					if (!$index || in_array(sha1_file($index), $page_shas)) continue;

					// determine the most recently updated file
					$age = 0;

					foreach ($indexFiles as $file) 
					{
						$access = filemtime($file);

						if ($access > $age) 
							$age = $access;
					}

					$user = basename($user);

					// For simplicity, we use a maximum of 50 months old 
					$monthsOld = floor(($now - $age) / 2592000);
					if ($monthsOld > 50) $monthsOld = 50;
					
					// Set opacity in steps of 5
					$opacity = 100 - 2 * $monthsOld;
					$opacity = ceil($opacity / 5) * 5;
					
					// Minimum is 15% opacity
					if ($opacity < 15) $opacity = 15;

					$homepagesOutput .= '<a data-op="'.$opacity.'" href="/~'.$user.'/">'.$user.'</a>';
				} 

				$homepagesOutput .= '</div>';	

				// Save cache file
				$save_cache = file_put_contents($cache_file, $homepagesOutput);
			}

			echo $homepagesOutput;
			?>
        </div>
    </div>
</div>
<?php include "footer.php";
