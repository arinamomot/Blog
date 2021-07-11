<?php
require_once "data.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/About_me.css">
    <link rel="stylesheet" href="css/background.css">
    <link rel="icon" href="images/icon.png">
    <title>Prague blog</title>
</head>
<body>
<header class="light-theme">
    <div class="">
        <i class="material-icons" id="menu">menu</i>
        <a class="active" href="index.php">Home</a>

    </div>
    <a class="mobile" href="About_me.php">About me</a>
    <a class="mobile" href="articles.php">Articles</a>
    <?php if (isset($_COOKIE['user']) && ($_COOKIE['user'] != $admin)): ?>
        <a class="mobile" href="ask.php">Ask a question</a>
    <?php endif; ?>
    <?php if (isset($_COOKIE['user']) && ($_COOKIE['user'] == $admin)): ?>
        <a class="mobile" href="add.php">Add article</a>
        <a class="mobile" href="myquestions.php">My questions</a>
    <?php endif; ?>
    <?php if (isset($_COOKIE['user'])): ?>
        <a class="out mobile" href="auth/logout.php">Log Out</a>
        <a class="out mobile" href="settings.php">Settings</a>
    <?php else: ?>
        <a class="out mobile" href="auth/signup.php">Sign Up</a>
        <a class="out mobile" href="auth/login.php">Log In</a>
    <?php endif; ?>
</header>

<div id="theme" class="theme light-theme material-icons">
    swap_horiz
</div>

<ul class="body_slides">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>

<main class="light-theme">
    <img class="myphoto" src="images/myphoto.jpg" alt="Myself">
    <h3> Arina Momot </h3>
    <div class="area">
        I am a girl, who lives in Prague, Czech Republic, and are absolutely in love with this city. And I like to share
        tips about our city, that’s why I started making blog. I also like to find and visit various interesting and
        unique places.
    </div>
    <h4>Some infornation about me:</h4>
    <ul class="spisok">
        <li>I am 19 years old.</li>
        <li>My hometown is Chelyabinsk, Russia.</li>
        <li>Now I am studing at CVUT and living in dormitory Strahov.</li>
    </ul>
    <div class="area">
        I hope my blog will be useful and interesting.
        So hello and welcome here!
    </div>
    <h4>You can find me on these sites:</h4>
    <div class="social">
        <div class="media">
            <a href="https://www.instagram.com/arinamomot/" class="link-media">
                <img src="https://pngicon.ru/file/uploads/instagram-128x128.png" alt="instagram" class="icon">
            </a>
            <a href="https://vk.com/arinamomot" class="link-media">
                <img src="https://pngicon.ru/file/uploads/vk-128x128.png" class="icon" alt="VK">
            </a>
            <a href="https://www.facebook.com/ArinaMomot1" class="link-media">
                <img src="https://pngicon.ru/file/uploads/FaceBook_512x512-128x128.png" class="icon" alt="facebook">
            </a>
        </div>
    </div>
</main>

<script src="js/script.js"></script>
</body>
</html>
