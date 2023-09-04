<?php
declare(strict_types=1);

// Get the username and theme from the URL
$username = $_GET['user'] ?? 'default';
$theme = $_GET['theme'] ?? 'default';

// Check if the referrer matches the expected pattern for the user
$referrer = $_SERVER['HTTP_REFERER'] ?? '';
$expectedPattern = "/https?:\/\/tilde\.club\/~" . preg_quote($username, '/') . "\//";

if (!preg_match($expectedPattern, $referrer)) {
    die("Access denied: Invalid referrer.");
}

try {
    $db = new PDO('sqlite:./guestbook.db');

    // Set error mode to exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the guestbook table exists
    $tableCheck = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='guestbook'")->fetch();

    // If the table doesn't exist, create it
    if (!$tableCheck) {
        $query = "CREATE TABLE guestbook (id INTEGER PRIMARY KEY, username TEXT, name TEXT, email TEXT, message TEXT)";
        $db->exec($query);
    }

    $username = filter_var($username, FILTER_SANITIZE_STRING);

    if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        $stmt = $db->prepare("INSERT INTO guestbook (username, name, email, message) VALUES (:username, :name, :email, :message)");
        $stmt->execute([':username' => $username, ':name' => $name, ':email' => $email, ':message' => $message]);
    }

    $stmt = $db->prepare("SELECT * FROM guestbook WHERE username = :username ORDER BY id DESC");
    $stmt->execute([':username' => $username]);
    $entries = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?= htmlspecialchars($username) ?>'s Guestbook!</title>
    <?php
    if ($theme !== 'default') {
        echo '<link rel="stylesheet" href="' . ($_SERVER['HTTPS'] ? 'https' : 'http') . '://tilde.club/~' . htmlspecialchars($username) . '/' . htmlspecialchars($theme) . '.css">';
    } else {
        // Default theme
      echo '<link rel="stylesheet" href="https://tilde.club/guestbook/default.css">';
    }
    ?>
</head>
<body>
    <h1 align="center">Welcome to <?= htmlspecialchars($username) ?>'s Guestbook!</h1>
    <p>Please leave a message below to let us know what you think of our page.</p>
    <form action="index.php?user=<?= htmlspecialchars($username) ?>&theme=<?= htmlspecialchars($theme) ?>" method="post">
        <p>Name: <input type="text" name="name" size="30"></p>
        <p>Email: <input type="text" name="email" size="30"></p>
        <p>Message:</p>
        <p><textarea name="message" rows="6" cols="50"></textarea></p>
        <p><input type="submit" value="Submit"></p>
    </form>
    <h2>Guestbook Entries</h2>
    <div class="entries">
        <?php
        if ($entries) {
            foreach ($entries as $entry) {
                echo '<div class="entry">';
                echo '<h3>' . htmlspecialchars($entry['name']) . ' <span>(' . htmlspecialchars($entry['email']) . ')</span></h3>';
                echo '<p>' . htmlspecialchars($entry['message']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No guestbook entries were found for ' . htmlspecialchars($username) . '.</p>';
        }
        ?>
    </div>
</body>
</html>
