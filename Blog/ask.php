<?php
require_once "data.php";
if (!isset($_COOKIE['user'])) {
    header("Location: auth/login.php");
}
if (isset($_GET['q'])) {
    $sent = $_GET['q'];
    echo "question sent";
}

if (isset($_POST['question'])) {
    $text = htmlspecialchars($_POST['question'], ENT_QUOTES);
    if (file_exists("/home/momotari/www/sem/users/" . $_COOKIE['user'])){
    $file = fopen("/home/momotari/www/sem/users/" . $_COOKIE['user'], 'r'); //Getting data about user from the file
    fgets($file);
    fgets($file);
    $mail = explode("=", fgets($file))[1];
    fclose($file);}
    $date = time();
    $conn = new mysqli("localhost", "momotari", "webove aplikace", "momotari") or die("There is no connection to the database"); //Connecting to database
    if (!$conn) {
        notfound();
    }
    if ($text != null){
    $question = "insert into ask (date, user, text) values ($date ,'$mail', '$text')"; //Entering question into the database.
    $result = $conn->query($question);
    if ($result == true) {
        header('Location: ask.php?q=questionsent');
    } else {
        echo "Error";
    }
    } else {
        echo "The field cannot be empty";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Ask a quastion</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="css/ask.css">
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
    <h2>Ask me a question</h2>
    <div class="here">
        <p>Here you can ask me any question that interests you.</p>
    </div>
    <hr>
    <form method="post" action="">
        <label for="question">
            <textarea placeholder="Remember, be nice!" name="question" rows="18"></textarea>
        </label>
        <button class="send-question" type="submit">Ask</button>
    </form>
</div>
<script src="js/script.js"></script>
</body>

</html>