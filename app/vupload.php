<?php
session_start();
include "connection.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
 
<body>
<!--HEADER-->
<?php include "header.php" ?>
<!--HEADER -->
<?php if(isset($_SESSION['uid'])): ?>
<form class="videoform" method="POST">
    <input type="text" name="links" placeholder="YouTube Link"required/>
    <button type="submit">Upload</button>
</form>
<?php else: ?>
    <center><h1>You are not logged in!</h1></center>
<?php endif ?>
<?php
   if(isset($_POST['links'])){
    $url =$_POST['links'];
    parse_str( parse_url( $url, PHP_URL_QUERY ), $after_v);
    if(isset($after_v['v'])){
    $vid = $after_v['v'];
    $_SESSION['vid'] = $vid;
    }else{
        echo "<center><h1>Sorry, This is not a valid link from YouTube</h1></center>";
    }
    }
?>
<?php if(isset($vid)):?>
<div id="myform" class="videoWindow">
    <h1>Do you want to Upload this video?</h1>
    <form class= "vuploadform" method="POST">
        <button type="submit" name="upload">Yes</button>
        <button onclick="myFunction()">No</button>
        <label>What Type:</label>
        <select name="types" required>
            <option value="" selected disabled hidden>Choose here</option>
            <option value="Abs">Abs</option>
            <option value="Back">Back</option>
            <option value="Biceps">Biceps</option>
            <option value="Chest">Chest</option>
            <option value="Legs">Legs</option>
            <option value="LowerBack">Lower Back</option>
            <option value="Shoulders">Shoulders</option>
            <option value="Triceps">Triceps</option>
            <option value="Others">Others</option>
        </select>
    </form>
     <div class='embed-container'>
         <iframe src='https://www.youtube.com/embed/<?php echo $vid; ?>' frameborder='0' allowfullscreen>
         </iframe>
    </div>
</div>
<?php endif ?>


<?php
//Two ways of getting YouTube ID (By Google API or By json)
 
    if(isset($_POST['upload']) AND isset($_POST['types'])){
        $apikey = 'AIzaSyBdeLhURZJGBuG5Jv0pQ5bjCDjW5gKSWrU';
        $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$_SESSION['vid'].'&key='.$apikey.'&part=snippet');
        $ytdata = json_decode($json);
        $title = $ytdata->items[0]->snippet->title;
        $mytitle = mysqli_real_escape_string($con, $title);
        $uid = $_SESSION['uid'];
        $myvid = $_SESSION['vid'];
        $types = mysqli_real_escape_string($con, $_POST['types']);
        date_default_timezone_set('America/New_York');
        $date = date('Y/m/d H:i:s', time());
        $sql="INSERT INTO videos (yt_id, title, date, fk_uid, type)
        VALUES('$myvid', '$mytitle','$date', '$uid', '$types')";
        mysqli_query($con, $sql);
        mysqli_close($con);
        echo "<center><h1>Uploaded Successfully</h1></center>";
//        header("Location:videoCourse.php");
        }
     if(isset($_POST['upload']) AND !isset($_POST['types'])){
         echo "<center><h1>Please Choose Your Video Type</h1></center>";
     }
//function get_titles($ref){
//         $json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $ref . '&format=json');
//         $details = json_decode($json,true);
//         return $details['title'];
//     }
 
?>    
    
<script>
function myFunction() {
  document.getElementById("myform").style.display="none";
}    
</script>
    
    
</body>
</html>