<?php 
session_start();
include "connection.php";
$uid = $_SESSION['uid'];
if (isset($_GET['vid'])){
    $vid =  mysqli_real_escape_string($con, $_GET['vid']);
    $Delvideos = "DELETE FROM videos WHERE vid=".$vid;
    mysqli_query($con, $Delvideos);
    $link = "Location:videoCourse.php?search=all";
    header($link);
    mysqli_close($con);
}
?>