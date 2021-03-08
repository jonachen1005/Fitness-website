<?php
session_start();
include "connection.php";
$limiter = 20;
        $general = "select * from reports LIMIT $limiter";
        $result = mysqli_query($con, $general);
        //            Detect how many pages available for all
                $all_repos = "SELECT rid FROM reports";
                $num_repos = mysqli_query($con, $all_repos);
                $nums = mysqli_num_rows($num_repos);
                $pages = ceil($nums/$limiter);   
        if (isset($_GET['page'])){
                $start= $limiter*($_GET['page']-1);
                $general = "select * from reports LIMIT $start,$limiter"; 
                $result = mysqli_query($con, $general);
            }
    if(isset($result)){
        $info = mysqli_fetch_all($result,MYSQLI_ASSOC);
    }

    if(isset($_GET['cid'])){
        $cid = $_GET['cid'];
        $posts = "select * from comments where cid = {$cid}";
        $c_result = mysqli_query($con, $posts);
        $c_info = mysqli_fetch_all($c_result,MYSQLI_ASSOC);
    }
    if(isset($_GET['vid'])){
        $vid = $_GET['vid'];
        $videos = "select * from videos where vid = {$vid}";
        $v_result = mysqli_query($con, $videos);
        $v_info = mysqli_fetch_all($v_result,MYSQLI_ASSOC);
    }

    if(isset($_GET['dcid'])){
        $cid = $_GET['dcid'];	
        $delcomment = "DELETE FROM comments WHERE cid={$cid}";
        mysqli_query($con, $delcomment);
        header("Location: control.php");
           }
    if(isset($_GET['dvid'])){
        $dvid = $_GET['dvid'];	
        $delvideo = "DELETE FROM videos WHERE vid={$dvid}";
        mysqli_query($con, $delvideo);
        header("Location: control.php");
           }
    if(isset($_GET['drid'])){
        $drid = $_GET['drid'];	
        $delrepo = "DELETE FROM reports WHERE rid={$drid}";
        mysqli_query($con, $delrepo);
        header("Location: control.php");
           }

if(isset($_POST['banusers'])){
    $susp = "UPDATE users SET status = 0 where uid = {$_POST['banusers']}";
    mysqli_query($con, $susp);
    header("Location: control.php");
}
if(isset($_POST['activateusers'])){
    $acti = "UPDATE users SET status = 1 where uid = {$_POST['activateusers']}";
    mysqli_query($con, $acti);
    header("Location: control.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- custom styles -->
    <script src="https://kit.fontawesome.com/a3873631ca.js" crossorigin="anonymous"></script>
    <style>
        html, body{
/*            height: 80%;*/
            
        }
        h1 {
            margin-top: 0;
        }
        .controlpage {
            height: 100%;
            width:100%;
            margin: auto;
            background: #F3F3F3;
            text-align: center;
        }
        table th, td{
            padding:5px;
        }
        table {
            width:80%;
            margin:auto;
        }
        .cpage{
            position: absolute;
            bottom: 0;
            width:100%; 
            margin:auto;
            text-align:center;
        }
        .fa-trash {
            float:none;
        }
    </style>
</head>
<body>
<?php if(isset($_SESSION['uid']) AND $_SESSION['uid'] == 1): ?>
<!--HEADER-->
<?php include "header.php" ?>
<!--HEADER --> 
    <?php if(isset($info)): ?>
    <div class="controlpage">
        <h1>Control Page</h1>
        <form method="POST">
        <input type="textarea" name="banusers" size="25" placeholder=" type uid to suspend a user">
        <button type="submit">Suspend</button>
        </form>
        <form method="POST">
        <input type="textarea" name="activateusers" size="25" placeholder="type uid to activate a user">
        <button type="submit">Activate</button>
        </form>
        <br/>
        <br/>
        <table border="1">
        <th>UID</th>
        <th>PID</th>
        <th>CID</th>
        <th>VID</th>
        <th>Reason</th>
        <th>Reporter_ID</th>
            <?php foreach($info as $row): ?>
            <tr>
                
                <td><a href="profile.php?uid=<?php echo $row['uid_fk']?>"><?php echo $row['uid_fk']?></a></td>
            <td><a href="index.php?pid=<?php echo $row['pid_fk']?>"><?php echo $row['pid_fk']?></a></td>
            <td><a href="control.php?cid=<?php echo $row['cid_fk']?>"><?php echo $row['cid_fk']?></a></td>
            <td><a href="control.php?vid=<?php echo $row['vid_fk']?>"><?php echo $row['vid_fk']?></a></td>
            <td><?php echo $row['reason']?></td>
            <td><a href="profile.php?uid=<?php echo $row['rep_id']?>"><?php echo $row['rep_id']?></a></td>
            <td><a href="control.php?drid=<?php echo $row['rid']?>"><i class="fas fa-trash"></i></td> 
            </tr>  
            <?php endforeach; ?>
        </table>
    
        
<?php endif ?>
<?php if(isset($c_info)): ?>
    <?php foreach($c_info as $row): ?>
 <div class='comments'>
                    <div class=pic>
                        <img class="Pavatar" src="<?php echo $row['avatar']?>">
                        <p><?php echo $row['username']; ?></p>
                    </div>
                        <br><br>
                    <div class="messa">
                    <p><?php echo nl2br($row['message']); ?></p>
                        </div>
                     <div class="commentdate">   
                    <p><?php echo $row['date']; ?></p>
                        </div>
                    <a href="control.php?dcid=<?php echo $row['cid']; ?>"><i class="fas fa-trash"></i></a>
                <a href="control.php">X</a>
            </div>
            <?php endforeach ?> 
<?php endif ?>

<?php if(isset($v_info)): ?>
    <div class="vContainer">
    <?php foreach($v_info as $row): ?>
    <div class="videos">
    <div class='embed-container'><iframe src='https://www.youtube.com/embed/<?php echo $row['yt_id']; ?>' frameborder='0' allowfullscreen></iframe>
        </div>
        <h4>Title: <?php echo $row['title']; ?></h4>
        <?php if(isset($_SESSION['uid'])): ?>
        <?php if ($_SESSION['uid'] == 1): ?>
                <a href="control.php?dvid=<?php echo $row['vid']; ?>"><i class="fas fa-trash"></i></a>
            <?php endif ?>
            <?php endif ?>
    </div>
    <?php endforeach; ?>
    </div>
<?php endif ?>
    
   <div class="cpage">
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
        <?php if(isset($result)): ?>
        <?php for($i=1;$i<$pages+1;$i++): ?>
       <a class="pagination" style='<?php echo focusbutton($i); ?>' href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor ?>
        <?php endif ?>
    </div>
    </div>
<?php else: ?>
    <center><h1>ADMINISTRATORS ONLY</h1></center>
<?php endif ?>
</body>
</html>