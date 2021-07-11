<?php
require_once "data.php";
$status = true;

if (isset($_GET['q'])) {
    $change = $_GET['q'];
    echo "data updated";
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
    if (!preg_match("/^[A-Za-z0-9!@#$%^*_+]{8,30}$/", $pass)) {
        echo 'Error(Please enter the data as required.)';
        return false;
    }
    return true;
}

/**
 * First name field check.
 *
 * @param string $firstname
 *
 * @return bool
 */
function checkfname($firstname)
{
    if (!preg_match("/^[A-Za-z!@#$%^*+_-]{2,40}$/", $firstname)) {
        echo 'Error(Please enter the data as required.)';
        return false;
    }
    return true;
}

/**
 * last name field check.
 *
 * @param string $lastname
 *
 * @return bool
 */
function checklname($lastname)
{
    if (!preg_match("/^[A-Za-z!@#$%^*+_-]{2,40}$/", $lastname)) {
        echo 'Error(Please enter the data as required.)';
        return false;
    }
    return true;
}

/**
 * Country field check.
 *
 * @param string $country
 *
 * @return bool
 */
function checkcountry($country)
{
    if (!preg_match("/^[A-Za-z]{2,40}$/", $country)) {
        echo 'Error(Please enter the data as required.)';
        return false;
    }
    return true;
}

if (!isset($_COOKIE['user'])) {
    header('');
}
$file = fopen('/home/momotari/www/sem/users/' . $_COOKIE['user'], 'r') or notfound(); // Getting data about user from a file.
$firstname = fgets($file);
$firstname = str_replace("\n", '', explode("=", $firstname)[1]);
$lastname = fgets($file);
$lastname = str_replace("\n", '', explode("=", $lastname)[1]);
$email = fgets($file);
$pass = fgets($file);
$country = fgets($file);
$country = str_replace("\n", '', explode("=", $country)[1]);
$bd = fgets($file);
fclose($file);

$error = null;

if (isset($_POST['firstname']) && isset($_POST['password'])) {
        $firstname = $_POST['firstname'];
        $status = $status && checkfname($firstname);
        $lastname = $_POST['lastname'];
        $status = $status && checklname($lastname);
        $country = $_POST['country'];
        $status = $status && checkcountry($country);
        if ($status){
            $file = fopen('/home/momotari/www/sem/users/' . $_COOKIE['user'], 'w') or notfound(); //Changing data in a file.
            fwrite($file, 'firstname=' . htmlspecialchars($firstname, ENT_QUOTES) . "\n");
            fwrite($file, 'lastname=' . htmlspecialchars($lastname, ENT_QUOTES) . "\n");
            fwrite($file, $email);
            fwrite($file, $pass);
            fwrite($file, 'country=' . htmlspecialchars($country, ENT_QUOTES) . "\n");
            fwrite($file, $bd);
            fclose($file);
            header('Location: settings.php?q');
        }
        $pass = $_POST['password'];
        $pass2 = $_POST['password2'];
        if ($pass != $pass2) {   // Verify Password Similarity
            $error = 'password';
        }else {
        $status = $status && checkpass($pass);
        $status = $status && checkpass($pass2);}
        if ($status) {
            $file = fopen('/home/momotari/www/sem/users/' . $_COOKIE['user'], 'w') or notfound(); //Changing data in a file.
            fwrite($file, 'firstname=' . htmlspecialchars($firstname, ENT_QUOTES) . "\n");
            fwrite($file, 'lastname=' . htmlspecialchars($lastname, ENT_QUOTES) . "\n");
            fwrite($file, $email);
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
            fwrite($file, 'password=' . password_hash($password, PASSWORD_DEFAULT) . "\n");
            fwrite($file, 'country=' . htmlspecialchars($country, ENT_QUOTES) . "\n");
            fwrite($file, $bd);
            fclose($file);
        }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="./images/icon.png">
    <link rel="stylesheet" href="css/settings.css">
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

<main>
    <div class="box light-theme">
        <h2>My profile</h2>
        <br>
        <p>Here you can see and change your details.</p>
        <br>
        <hr>
        <form method="post" onsubmit="return submitForm()">
            <div class="field">
                <label for="form_firstname">First Name:</label>
                <input id="form_firstname" value="<?php echo $firstname; ?>" type="text" name="firstname">
                <label for="form_lastname">Last Name:</label>
                <input id="form_lastname" value="<?php echo $lastname; ?>" type="text" name="lastname">
            </div>
            <div class="field">
                <label for="form_password">Password:</label>
                <input id="form_password" <?php echo ($error== 'password')?'style = "background: red"': "" ?> type="password" name="password">
                <i class="material-icons" id="eye">remove_red_eye</i>
                <label for="form_password2">Repeat Password:</label>
                <input id="form_password2" type="password" name="password2">
            </div>
            <div class="field">
                <label for="form_country">Country:</label>
                <input id="form_country" value="<?php echo $country; ?>" type="text" name="country">
            </div>
            <br>
            <hr>
            <div class="buttons">
                <button type="button" id="clear">Clear</button>
                <button type="submit">Change</button>
            </div>
        </form>
    </div>
</main>
<script src="js/eye.js"></script>
<script src="js/script.js"></script>
</body>
</html>