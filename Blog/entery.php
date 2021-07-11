<?php
require_once "data.php";

$conn = new mysqli("localhost", "momotari", "webove aplikace", "momotari") or die("There is no connection to the database"); //Сonnection to a database
if ($conn == null) {
    notfound();
}
$title = "";
$id = NULL;


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $filename = "/home/momotari/www/sem/posts/" . $id . ".txt";
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        $title = fgets($file);                      //Getting data about article from file
        $title = explode(":", $title)[1];
        $date = fgets($file);
        $date = explode(":", $date)[1];
        $img = fgets($file);
        $img = substr($img, 28);
        $text = fread($file, filesize($filename));
        $text = substr($text, 5);
        fclose($file);
    }
} else {
    notfound();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/entery.css">
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

<div class="foundation light-theme">
    <div class="foundation2">
        <div class="heading">
            <img src="<?php echo (isset($img)) ? $img : "" ?>" alt="">
            <h3 class="light-theme"><?php echo (isset($title)) ? $title : "" ?></h3>
        </div>

        <div class="top_badges">
            <div class="minilogo">
                <img src="images/logo.jpg" alt="">
            </div>

            <div class="title">
                <strong>Arina Momot</strong>
                <span><?php echo (isset($date)) ? gmdate('d-m-Y', (int)$date) : "" ?></span>
            </div>
            <div class="favorites">
                <i id="like" class="material-icons <?php //Displays likes from database
                $user = $_COOKIE['user'];
                $check = "select * from likes where user='$user' and id=$id";
                $result = $conn->query($check);
                if ($result->num_rows > 0) {
                    echo " liked";
                }
                ?>" role="presentation">favorite</i> <span id="likes" class=""><?php
                    $likes = "select * from likes where id=$id"; //Getting data about likes from database
                    $like = $conn->query($likes);
                    echo $like->num_rows;
                    ?></span>
            </div>
        </div>
        <div class="text">
            <p>
                <?php echo (isset($text)) ? $text : "" ?>
            </p>
        </div>
        <hr>
        <?php if (isset($_COOKIE['user'])): ?>
            <div class="comments">
                <form method="post" class="comment-form" action="comment.php">
                    <div class="write_comment">
                        <label for="comment">
                        <textarea name="comment" rows=4 class="write" id="comment"
                                  placeholder="Write your comment.."></textarea>
                        </label>
                    </div>
                    <input id="inputpage" name="page" value="<?php echo $id ?>"/>
                    <button class="button">
                        <i class="material-icons" id="send" role="presentation">check</i>
                    </button>
                </form>
                <div class="comment_area">
                    <?php
                    $query = "select * from comments where id = $id"; //Getting data about comments from database
                    $data = $conn->query($query);
                    if ($data->num_rows > 0) {
                        while ($row = $data->fetch_assoc()) {
                            if (file_exists("/home/momotari/www/sem/users/" . $row['user'])) {
                                $openuser = fopen("/home/momotari/www/sem/users/" . $row['user'], 'r'); //Getting data about user from file
                                $name = fgets($openuser);
                                $name = explode('=', $name)[1];
                                fclose($openuser);
                                // Displays users comment
                                echo '<article class="comment"> 
              <section class="author">
                <span class="author-name">' . $name . '</span>
                <span>' . gmdate("d-m-Y", $row['date']) . '</span>
              </section>
              <div class="comment-text">
                <p>' . $row['comment'] . '</p>
              </div>
            </article>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="js/script.js"></script>
<script src="js/like.js"></script>
</body>
</html>
