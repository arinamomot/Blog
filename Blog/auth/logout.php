<?php
setcookie('user', "", time()-1, "/");  //Cookie Removal
header("Location: login.php");
?>
