<?php
require_once "../data.php";
$adress = "/home/momotari/www/sem/users/mails";
$status = true;    //stores the value of the checks

/**
 * Email field check.
 *
 * @param string $mail
 *
 * @return bool
 */
function checkmail($mail)
{
    if (!preg_match("/^[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}$/", $mail)) {
        echo 'Error(Please enter the data as required.)';
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

/**
 * Add user to file.
 *
 * The function writes the data entered by the user to a file.
 *
 * @param string $filename id user
 *
 * @return void
 */
function adduser($filename)
{
    global $adress;
    global $mail;
    $user = fopen("/home/momotari/www/sem/users/" . $filename, "w") or notfound();
    fwrite($user, 'firstname=' . htmlspecialchars($_POST['firstname'], ENT_QUOTES) . "\n");
    fwrite($user, 'lastname=' . htmlspecialchars($_POST['lastname'], ENT_QUOTES) . "\n");
    fwrite($user, 'email=' . $mail . "\n");
    $password = htmlspecialchars($_POST['password']);
    fwrite($user, 'password=' . password_hash($password, PASSWORD_DEFAULT) . "\n");
    fwrite($user, 'country=' . htmlspecialchars($_POST['country'], ENT_QUOTES) . "\n");
    fwrite($user, 'bd=' . htmlspecialchars($_POST['birthday'], ENT_QUOTES) . "\n");
    fclose($user);
    $mails = fopen($adress, 'a') or notfound(); //Adding information to the end of the file
    fwrite($mails, $mail . "\n");
    fclose($mails);
}

$error = null;

if (isset($_POST['firstname'])) {
    $mail = $_POST['email'];
    $status = checkmail($mail);
    $mail = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $pass = $_POST['password'];
    $pass2 = $_POST['password2'];
    $status = $status && checkpass($pass);
    $status = $status && checkpass($pass2);
    $firstname = $_POST['firstname'];
    $status = $status && checkfname($firstname);
    $lastname = $_POST['lastname'];
    $status = $status && checklname($lastname);
    $country = $_POST['country'];
    $status = $status && checkcountry($country);
    $mails = fopen($adress, "r") or notfound();
    $tmp = fread($mails, filesize($adress));
    fclose($mails);
    $tmp = explode("\n", $tmp); //getting rid of line breaks
    if (!$status) {
    } elseif (!in_array($mail, $tmp)) {  //Check if there is already mail in the file
        $filename = md5($mail);         //encrypt a file name containing user data
        if ($pass != $pass2) {
            $error = 'password';
        } else {
            adduser($filename);
            header('Location: login.php');
        }
    } else {
        echo "Email is taken. Please try another email.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/background.css">
</head>
<body>
<header class="light-theme">
    <div class="">
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

<div class="box light-theme">
    <h2>Registration</h2>
    <br>
    <p>Please fill in this form to create an account.</p>
    <br>
    <hr>
    <form method="post" onsubmit="return submitForm()">
        <div class="field">
            <label for="form_firstname">First Name*:</label>
            <input id="form_firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" type="text"
                   name="firstname" pattern="[A-Za-z!@#$%^*+_-]{2,40}" required>
            <label for="form_lastname">Last Name*:</label>
            <input id="form_lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" type="text"
                   name="lastname" pattern="[A-Za-z!@#$%^*+_-]{2,40}" required>
        </div>
        <div class="field">
            <label for="form_email">E-mail*:</label>
            <input id="form_email" value="<?php echo isset($mail) ? $mail : '' ?>" type="email" name="email"
                   pattern="/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2-4}/" required>
        </div>
        <p>(Please enter your valid mail)</p>
        <div class="field">
            <label for="form_password">Password*:</label>
            <input id="form_password" <?php echo ($error == 'password') ? 'style = "background: red"' : "" ?>
                   type="password" name="password" pattern="[A-Za-z0-9!@#$%^*_+]{8,30}" required>
            <i class="material-icons" id="eye">remove_red_eye</i>
            <label for="form_password2">Repeat Password*:</label>
            <input id="form_password2" type="password" name="password2" pattern="[A-Za-z0-9!@#$%^*_+]{8,30}" required>
        </div>
        <p>(Your password must contain 8 or more characters)</p>
        <div class="field">
            <label for="form_country">Country*:</label>
            <input id="form_country" value="<?php echo isset($country) ? $country : '' ?>" type="text" name="country"
                   pattern="[A-Za-z]{2,40}" required>
            <label for="form_birthday">Date of Birth*:</label>
            <input id="form_birthday" value="<?php echo isset($_POST['birthday']) ? $_POST['birthday'] : '' ?>"
                   type="date" name="birthday" required>
        </div>
        <br>
        <hr>
        <p>By creating an account you agree to our <a class="terms" href="#">Terms & Privacy</a>.</p>
        <p>* - These fields are required.</p>
        <p>English only.</p>
        <div class="field">
            <button type="button" id="clear">Clear</button>
            <button type="submit">Sign Up</button>
        </div>
    </form>
</div>
<script src='../js/signup.js'></script>
<script src="../js/script.js"></script>
</body>
</html>
