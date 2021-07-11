<?php
if (!isset($_COOKIE['user']) || (!isset($_GET['id']))) {
    echo "Error";
} else {
    $user = $_COOKIE['user'];
    $id = $_GET['id'];
    $conn = new mysqli("localhost", "momotari", "webove aplikace", "momotari") or die("false"); //Сonnection to a database
    if ($conn == null){
        echo "Error. No connection to the database.";
    }
    $like= "insert into likes (user, id) values ('$user' ,$id)";
    $result= $conn->query($like);
    if ($result== true) {
        echo "true";
    } else {
        echo "false";
    }
}
?>

