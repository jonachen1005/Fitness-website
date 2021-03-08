<?php 
session_start();
include "connection.php";
$uid = $_SESSION['uid'];
if (isset($_GET['pid'])){
    $id =  mysqli_real_escape_string($con, $_GET['pid']);
    $Delposts = "DELETE FROM posts WHERE pid=".$id;
    $post = mysqli_query($con, $Delposts);
    $link = "Location:profile.php?uid=". $uid;
    header($link);
    mysqli_close($con);
}
?>