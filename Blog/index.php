<?php
require_once "data.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/main.css">
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

<main>
    <div class="main-box">
        <div class="box light-theme">
            <div class="aboutme">
                <h2>About me</h2>
                <img class="myphoto" src="images/myphoto.jpg" alt="Myself">
                <p>Here you can find information about me.<br>
                    As well as links to all my social networks.</p>
            </div>
            <div class="more">
                <a class="myself light-theme" href="About_me.php"><i class="material-icons arrow">double_arrow</i></a>
            </div>
        </div>
        <div class="box light-theme ask">
            <h2 class="light-theme">Click on the question mark to ask me a question</h2>
            <p><a class="askme light-theme" href="ask.php">?</a></p>
            <?php if (!isset($_COOKIE['user'])): ?>
                <p class="note">(Only registered users can do this)</p>
            <?php endif; ?>
        </div>
    </div>

    <?php

    /**
     * Displays a shortened article.
     *
     * The function opens the file, takes information about the article from there and displays a brief block of information about it.
     *
     * @param string $filename name of file
     *
     * @return void
     */
    function write($filename)
    {
        if (file_exists("/home/momotari/www/sem/posts/" . $filename)) {
            $file = fopen("/home/momotari/www/sem/posts/" . $filename, "r");
            $title = fgets($file);
            $title = explode(":", $title)[1];
            $date = fgets($file);
            $img = fgets($file);
            $text = fread($file, 500);
            $text = substr($text, 5);
            fclose($file);
            echo '<div class="box light-theme">
        <h2>' . $title . '</h2>
        <p>' . $text . '...</p>
        <div class="more">
            <a href="entery.php?id=' . substr($filename, 0, count($filename) - 5) . '" class="material-icons arrow light-theme">double_arrow</a>
        </div>
    </div>';
        }}
    //Display 3 latest articles on the main page
    $files = scandir("/home/momotari/www/sem/posts");
    for ($i = count($files) - 1; $i > (count($files) - 4); $i = $i - 1) {
        write($files[$i]);
    }
    ?>
</main>

<script src="./js/script.js"></script>
</body>
</html>