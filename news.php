<?php include "header.php"; ?>

<h1 id="fancyboi">welcome to tilde.club</h1>

<p><a href="/wiki/faq.html">Questions? See the official FAQ.</a></p>

<!-- <p class="advisory">GMAIL USERS: We no longer accept gmail.com addresses for signups since you would not receive your account> -->
<!-- Active Users Scrolling List -->
<div class="active-users-container">
    <h2 style="display: inline;">Currently Active Users:</h2>
    <div class="active-users-list">
        <ul>
	<?php
	$activeUsers = json_decode(file_get_contents('online-users.json'), true);

        if (!empty($activeUsers)) {
            foreach ($activeUsers as $user) {
                $username = htmlspecialchars($user);
                echo "<li><a href='/~$username'>$username</a></li>";
            }
            // Repeat the list for seamless scrolling
            foreach ($activeUsers as $user) {
                $username = htmlspecialchars($user);
                echo "<li><a href='/~$username'>$username</a></li>";
            }
	} else {
            echo "<li>No active users at the moment.</li>";
        }
	?>
	</ul>
    </div>
</div>
<?php
// Load the HTML from inn_status.html
$html = file_get_contents('./news/inn_status.html');

// Use DOMDocument to parse the HTML
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Suppress warnings for malformed HTML
$dom->loadHTML($html);
libxml_clear_errors();

// Extract the content inside the <pre> tag
$preTags = $dom->getElementsByTagName('pre');
$innStatus = '';
if ($preTags->length > 0) {
    $innStatus = $preTags->item(0)->nodeValue;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="600">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INN Status</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="content">
    <h1>INN Status</h1>
    <pre><?php echo htmlspecialchars($innStatus); ?></pre>
</div>

</body>
</html>
