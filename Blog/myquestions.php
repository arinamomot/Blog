<?php
require_once "data.php";
if (!isset($_COOKIE['user'])) {
    header("Location: index.php");
}

if (isset($_COOKIE['user'])) {
    if ($_COOKIE['user'] != $admin) {
        header("Location: index.php");
    }
}

$conn = new mysqli("localhost", "momotari", "webove aplikace", "momotari") or die("false"); //Сonnection to a database
if (!$conn) {
    notfound();
}
$mail = NULL;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/myquestions.css">
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
    <div class="gmailblock light-theme">
        <p>Quick access to mail: <a class="gmail" href="https://www.google.ru/gmail/about/">My gmail</a></p>
    </div>

    <div class="comment_area">
        <?php
        $question = "select * from ask ORDER BY date DESC"; //Output data from the latest date
        $data = $conn->query($question);
        if ($data->num_rows > 0) {  //Displays questions from the database
            while ($row = $data->fetch_assoc()) {
                echo '<article id="question" class="light-theme"> 
              <section class="author">
              <strong>From:</strong>
                <span class="author-name">' . $row['user'] . '</span>
              </section>
              <section class="date">
              <strong>Date:</strong>
               <span class="date_time">' . gmdate('d-m-Y', $row['date']) . '</span>
               </section>
              <div class="text">
                <p><strong>Question: </strong>' . $row["text"] . '</p>
              </div>
            </article>';
            }
        }
        ?>
    </div>
</main>
<script src="./js/script.js"></script>
</body>
</html>