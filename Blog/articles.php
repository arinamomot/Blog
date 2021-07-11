<?php
require_once "data.php";
$page = 1;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/articles.css">
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

<?php
if (isset($_GET['page'])) {
    $active = $_GET['page'];
    echo "<p class='activepage light-theme'>Active page=$active</p>";  //Display the page number on which the user is currently located
}
?>

<div class="filters light-theme">
    Filters:
    <form action="">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input class="filter" name="date" type="submit" value="For the last 24 hours">
    <input class="filter" type="submit" name="date" value="For the last week">
    <input class="filter" type="submit" name="date" value="For the last month">
    </form>
</div>
<main>
    <?php
    /**
     * Displays a shortened article.
     *
     * The function opens a file with information about the article, takes data from there and displays a short block with information about it. It is also responsible for what will be displayed, depends on the user's actions.
     *
     * @param string $filename
     *
     * @return void
     */
    function write($filename)
    {
        if (file_exists("/home/momotari/www/sem/posts/" . $filename)){
        $file = fopen("/home/momotari/www/sem/posts/" . $filename, "r");
        $title = fgets($file);
        $title = explode(":", $title)[1];
        $date = fgets($file);
        $date = explode(":", $date)[1];
        $img = fgets($file);
        $img = substr($img, 28);
        $text = fread($file, 500);
        $text = substr($text, 5);
        fclose($file);}
        $print = false; // Variable responsible for what to output
        if (isset($_GET['date']) ){
            if (($_GET['date'] == "For the last 24 hours") && ((int)$date+86400) < time()){
                $print = true;
            }elseif ((($_GET['date'] == "For the last week") && ((int)$date+604800) < time())){
                $print = true;
            }elseif ((($_GET['date'] == "For the last month") && ((int)$date+2628000) < time())){
                $print= true;
            }
        } else {
            $print=false;
        }
        if ($print==true) return;
        echo '<div class="box box-ar light-theme">
        <h2>' . $title . '</h2>
        <p>' . $text . '...</p>
        <div class="more">
            <a href="entery.php?id=' . substr($filename, 0, count($filename) - 5) . '" class="material-icons arrow light-theme">double_arrow</a>
        </div>
    </div>';
    }

    $files = scandir("/home/momotari/www/sem/posts"); //Display 10 articles on each page from last to first
    array_shift($files);
    array_shift($files);
    $c = count($files);
    $page = ($c - ($c % 10)) / 10 + (($c % 10) > 0 ? 1 : 0);
    if (isset($_GET['page'])) {
        $k = (int)$_GET['page'];
        for ($i = ($c - 1) - 10 * ($k - 1); $i > (($c - 1) - 10 * ($k - 1)) - 10; $i = $i - 1) {
            if (isset($files[$i]) && $i >= 0) {
                write($files[$i]);
            }
        }
    } else {
        for ($i = count($files) - 1; $i > count($files) - 11; $i = $i - 1) {
            if (isset($files[$i]) && $i >= 0) {
                write($files[$i]);
            }
        }
    }
    echo "<form class='pages'>"; // Display the number of pages - pagination
    if (isset($_GET["date"])) {
        echo "<input type='hidden' name='date' value='" . $_GET["date"] . "'>";
    }
    for ($i = 1; $i < $page + 1; $i++) {
        echo "<input class='pageactive' type='submit' name='page' value='$i'>";
    }
    echo "</form>";
    ?>

</main>
<script src="./js/script.js"></script>
</body>
</html>