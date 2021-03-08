<?php
    session_start();
    include "connection.php";
if(isset($_GET['search'])){
    $limiter = 6;
    
    
    $keyWord =  mysqli_real_escape_string($con, $_GET['search']);
    if ($keyWord == "all"){
        $videos = "SELECT * FROM videos ORDER BY date DESC LIMIT $limiter";
        $myvideos = mysqli_query($con, $videos);
        //            Detect how many pages available for all
                $all_videos = "SELECT vid FROM videos";
                $num_videos = mysqli_query($con, $all_videos);
                $nums = mysqli_num_rows($num_videos);
                $pages = ceil($nums/$limiter);
        
        if (isset($_GET['page'])){
                $start= $limiter*($_GET['page']-1);
                $videos = "SELECT * FROM videos ORDER BY date DESC LIMIT $start,$limiter"; 
                $myvideos = mysqli_query($con, $videos);
            }
    }
    else{
        $videos = "SELECT * FROM videos WHERE type = '$keyWord' ORDER BY date DESC LIMIT $limiter";
        $myvideos = mysqli_query($con, $videos);
         //            Detect how many pages available for keywords
                $all_videos = "SELECT vid FROM videos WHERE type = '$keyWord'";
                $num_videos = mysqli_query($con, $all_videos);
                $nums = mysqli_num_rows($num_videos);
                $pages = ceil($nums/$limiter);
        
        if (isset($_GET['page'])){
                $start= $limiter*($_GET['page']-1);
                $videos = "SELECT * FROM videos WHERE type = '$keyWord' ORDER BY date DESC LIMIT $start,$limiter"; 
                $myvideos = mysqli_query($con, $videos);
            }
    }
    if(isset($myvideos)){
        $vid_details = mysqli_fetch_all($myvideos, MYSQLI_ASSOC);}
}
    mysqli_close($con);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- custom styles -->
    
    <script src="https://kit.fontawesome.com/a3873631ca.js" crossorigin="anonymous"></script>
</head>
<body style="background:#f1f1f1">
<!--HEADER-->
<?php include "header.php" ?>
<!--HEADER -->    
    
    <?php if(isset($vid_details)): ?>
    <div class="wholeVideos">
        <div class="vbar">
<!--            <div class="postSection">-->
                <h2 class="ptitle">Video Courses</h2>
                <?php if(isset($_SESSION['uid'])): ?>
                <a class="upPost3" href="vupload.php">Upload My Video</a>
                <?php endif ?>
<!--            </div>-->
        </div>
        <?php if ($vid_details == NULL): ?>
            <center><h2>Videos related with <?php echo "'" . $_GET['search'] . "'"; ?> Not Found</h2></center>
        <?php endif ?>
    
    <div class="vCourse">
        <a href="videoCourse.php?search=Abs&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/abs.PNG"/><div class="Vcenter">Abs</div></div></a>
        <a href="videoCourse.php?search=Back&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/back.PNG"/><div class="Vcenter">Back</div></div></a>
        <a href="videoCourse.php?search=Chest&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/chest.PNG"/><div class="Vcenter">Chest</div></div></a>
        <a href="videoCourse.php?search=Biceps&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/biceps.PNG"/><div class="Vcenter">Biceps</div></div></a>
        <a href="videoCourse.php?search=Legs&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/legs.PNG"/><div class="Vcenter">Legs</div></div></a>
        <a href="videoCourse.php?search=Shoulders&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/shoulder.PNG"/><div class="Vcenter">Shoulders</div></div></a>
        <a href="videoCourse.php?search=Triceps&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/triceps.PNG"/><div class="Vcenter">Triceps</div></div></a>
        <a href="videoCourse.php?search=Others&page=1"><div class="Vcontainer"><img class="Vimg" src="uploads/others.PNG"/><div class="Vcenter">Others</div></div></a>
    </div>
    
    <?php if(isset($_GET['search'])): ?>
        <div class="vbar"><?php echo $_GET['search'] . " Videos"; ?>
        <?php if($_GET['search'] != 'all'): ?>
            <a class="valink" href="videoCourse.php?search=all">View All</a>
        <?php endif ?>
        </div>
    <?php endif ?>
    <div class="vContainer">
    <?php foreach($vid_details as $row): ?>
    <div class="videos">
    <div class='embed-container'><iframe src='https://www.youtube.com/embed/<?php echo $row['yt_id']; ?>' frameborder='0' allowfullscreen></iframe>
        </div>
        <h4>Title: <?php echo $row['title']; ?></h4>
        <div class="toge">
        <?php if(isset($_SESSION['uid'])): ?>
        <?php if ($_SESSION['uid'] == $row['fk_uid'] OR $_SESSION['uid'] == 1): ?>
                <a onClick="javascript: return confirm('Please confirm video deletion');" href="devideo.php?vid=<?php echo $row['vid']; ?>" name="readm"><i class="fas fa-trash"></i></a> 
        <?php endif ?>
        <a class="repor" href="reports.php?vid=<?php echo $row['vid']; ?>"><i class="fas fa-flag"></i></a>
        <?php endif ?>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
    </div>
    <?php endif; ?>
    <div style='width:100%; margin:auto;text-align:center;'>
    <?php
    if(isset($nums) AND $nums > 0){
        function focusbutton($i){
            if(isset($_GET['page'])){
            $page = $_GET['page'];
            }else{
                $page=1;
                }
            if ($page == $i){
                return "background:#333333;color:white;";
                }
            }
        }
    ?>
        <?php if(isset($vid_details)): ?>
        <?php for($i=1;$i<$pages+1;$i++): ?>
       <a class="pagination" style='<?php echo focusbutton($i); ?>' href="?search=<?php echo $keyWord; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor ?>
        <?php endif ?>
    </div>
    
</body>
</html>