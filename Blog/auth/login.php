<?php
$adress = "/home/momotari/www/sem/users/mails";
$status = true; //stores the value of the checks

/**
 * Email field check.
 *
 * @param string $mail
 *
 * @return bool
 */
function checkmail($mail)
{
    if (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $mail)) {
        return false;
    }
    return true;
}

/**
 * Password field check.
 *
 * @param string $pass
 *
 * @return bool
 */
function checkpass($pass)
{
    if (!preg_match("/^[A-Za-z0-9!@#$%^*_+]{8,20}$/", $pass)) {
        return false;
    }
    return true;
}

/**
 * Displays error.
 *
 * @param string $error
 *
 * @return void
 */
function printerror($error)
{
    echo $error;
}

if (isset($_POST['email'])) {
    $mail = $_POST['email'];
    $status = checkmail($mail);
    $mail = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $password = $_POST['password'];
    $status = $status && checkpass($password);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
    if ($status) {
    } else {
        printerror(" / Error(Your password or email contains invalid characters or is too short.)");
    }
}

error_reporting(E_ERROR | E_PARSE);
if (isset($_POST['email'], $_POST['password'])) {
    $hash = md5($mail);                      //Email encryption
    $file = fopen("/home/momotari/www/sem/users/" . $hash, 'r') or printerror("User doesnt exist");
    $firstname = fgets($file);
    $lastname = fgets($file);
    $email = fgets($file);
    $pass = fgets($file);
    $pass = explode("=", $pass)[1];
    $pass = explode("\n", $pass)[0];
    if (password_verify($password, $pass)) {   //encrypted password comparison
        setcookie("user", $hash, time() + 3600 * 6, '/');  //the creation of Cookie
        header('Location: /~momotari/sem/');  //redirect to home page
    } else {
        echo "Your email or password is incorrect.";
    }
}



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Log in</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/background.css">
</head>
<body>
<header class="light-theme">
    <div>
        <i class="material-icons" id="menu">menu</i>
        <a class="active" href="../index.php">Home</a>

    </div>
    <a class="mobile" href="../About_me.php">About me</a>
    <a class="mobile" href="../articles.php">Articles</a>
    <?php if (isset($_COOKIE['user']) && ($_COOKIE['user'] != $admin)): ?>
        <a class="mobile" href="../ask.php">Ask a question</a>
    <?php endif; ?>
    <a class="out mobile" href="signup.php">Sign Up</a>
    <a class="out mobile" href="login.php">Log In</a>
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

<div class="login light-theme">
    <h2>Log in</h2>
    <div class="please">
        <p>Please fill in this form to log in to your account.</p>
    </div>
    <hr>
    <form method="post" onsubmit="return submitForm()">
        <div class="field">
            <label for="form_email2">E-mail:</label>
            <input id="form_email2" type="email" name="email"
                   pattern="/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2-4}/" required>
            <i class="material-icons" id="eye">remove_red_eye</i>
            <label for="form_password">Password:</label>
            <input id="form_password" type="password" name="password" pattern="[A-Za-z0-9!@#$%^*_+]{8,30}" required>
        </div>
        <br>
        <hr>
        <div class="field">
            <button type="button" id="clear">Clear</button>
            <button type="submit">Log in</button>
        </div>
    </form>
</div>
<script src='../js/login.js'></script>
<script src="../js/script.js"></script>
</body>
</html>
