<?php
require_once "data.php";
if (!isset($_COOKIE['user'])) {
        header("Location: index.php"); //redirect to home page
}

if (isset($_COOKIE['user'])) {
    if ($_COOKIE['user'] != $admin) {
        header("Location: index.php"); //redirect to home page
    }
}

$images = "/home/momotari/www/sem/images/";

/**
 * Writing a post to a file.
 *
 * @param string $tmp
 *
 * @return void
 */
function writeposttofile($tmp)
{
    global $images;
    fwrite($tmp, "title: " . htmlspecialchars($_POST['title']) . "\n");
    fwrite($tmp, "date: " . time() . "\n");
    fwrite($tmp, "img: " . $images . $_FILES['image']["name"] . "\n");
    fwrite($tmp, "text: " . $_POST['text'] . "\n");
    fclose($tmp);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Prague blog</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="images/icon.png">
    <link rel='stylesheet' href='css/add.css'>
    <link rel="stylesheet" href="css/background.css">
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

<div class="box light-theme">
    <form method="post" enctype="multipart/form-data">
        <p>Title: <label for="title"><input type="text" name="title"></label></p>
        <p>Image: <label for="image"><input type="file" name="image"></label</p>
        <p>Text: </p>
        <textarea name="text" rows="22"></textarea>
        <button class="save" type="submit">Save</button>
    </form>
    <div class="result">
        Result:
        <?php if (isset($_POST['title'])) {
            $arrayimg = explode(".", $_FILES['image']['name']);
            $type = $arrayimg[count($arrayimg) - 1];
            $_FILES['image']["name"];
            if ($type == 'jpg' || $type == "png" || $type == "jpeg") {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $images . $_FILES['image']["name"])) {
                    echo "<a href='entery.php?id=" . time() . "'>link </a>";
                }
                $tmp = fopen('/home/momotari/www/sem/posts/' . time() . ".txt", "w") or notfound();
                writeposttofile($tmp);
                $likes = fopen('/home/momotari/www/sem/likes/' . time() . 'txt', 'w') or notfound();
                fwrite($likes, "\n");
                fclose($likes);
            }
        }
        ?>
    </div>
</div>

<script src="./js/script.js"></script>
</body>
</html>
