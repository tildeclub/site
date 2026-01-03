<?php include "header.php"; ?>

<h1 id="fancyboi">welcome to tilde.club</h1>

<p><a href="/wiki/faq.html">Questions? See the official FAQ.</a></p>

<!-- <p class="advisory">GMAIL USERS: We no longer accept gmail.com addresses for signups since you would not receive your account> -->
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
<?php include "footer.php"; ?>
