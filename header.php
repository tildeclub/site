<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=isset($title) ? $title : "Welcome to ~tilde.club~"?></title>
	<link rel="icon" type="image/png" href="https://tilde.club/favicon.png">
    
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
        <a href="/changes.rss" class="rss-icon" title="RSS Feed">
            <img src="/images/rss.png" width="24" alt="RSS icon">
        </a>
