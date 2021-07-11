<?php
require_once "data.php";
$conn = new mysqli("localhost", "momotari", "webove aplikace", "momotari") or die("false"); ////Сonnection to a database
if (!$conn){
  notfound();
}
if(isset($_POST['page']) && isset($_POST['comment']) && isset($_COOKIE['user'])) {
  $id = $_POST["page"];
  $com = htmlspecialchars($_POST['comment'], ENT_QUOTES);
  $user = $_COOKIE['user'];
  $date = time();
  if ($com == null){
    header("Location: entery.php?id=$id");
  }else {
  $sql = "insert into comments(id, comment, user, date) values($id , '$com', '$user', $date);"; //Entering data into the database.
  $result = $conn->query($sql);
  if($result == true) {
    header("Location: entery.php?id=$id");
  } else {
    echo "False. Please do not use single quotes.";
  }
}} else {
  echo "false";
}
?>
