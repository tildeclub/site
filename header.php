<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=isset($title) ? $title : "Welcome to ~tilde.club~"?></title>
    
    <!-- Preload CSS and image resources -->
    <link rel="preload" href="/style.css" as="style">
    <link rel="preload" href="/images/rss.png" as="image">
    
    <!-- Load the CSS file -->
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php include "nav.html"; ?>
    <div class="content">
        <!-- RSS Icon -->
        <div class="rss-icon">
            <a href="/changes.rss" title="RSS Feed">
                <img src="/images/rss.png" alt="RSS Feed">
            </a>
        </div>
