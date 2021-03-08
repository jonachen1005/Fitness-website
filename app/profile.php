<?php
    session_start();
    include "connection.php";
    
    date_default_timezone_set('America/Indiana/Indianapolis');
    
    
    if (isset($_GET['pid'])){
    $pid =  mysqli_real_escape_string($con, $_GET['pid']);
    $posts2 = "SELECT * FROM posts WHERE pid=".$pid;
    $post = mysqli_query($con, $posts2);
    $info = mysqli_fetch_assoc($post);
    }
    if (isset($_GET['uid'])){
    $id =  mysqli_real_escape_string($con, $_GET['uid']);
    $posts = "SELECT * FROM posts as p,users as t WHERE p.uid_fk = t.uid AND uid=".$id. " ORDER BY upload_date DESC LIMIT 2";
        
    $all_posts = "SELECT pid FROM posts as p,users as t WHERE p.uid_fk = t.uid AND uid ={$id}";
                $nums = mysqli_num_rows(mysqli_query($con, $all_posts));
        
    $results = mysqli_query($con, $posts);
    $post_rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
    $userInfos = "SELECT * FROM users WHERE uid=".$id;
    $uinfo = mysqli_query($con, $userInfos);
    $userInfo = mysqli_fetch_assoc($uinfo);
//    var_dump($userInfo);
    //mysqli_close($con);
    $selfie = "SELECT avatar FROM users WHERE uid=".$_SESSION['uid'];
    $pics = mysqli_query($con, $selfie);
    $pic = mysqli_fetch_assoc($pics); 
    
        
      if(isset($_POST['commentdelete'])){
                $cid = $_POST['cid'];	
                $comment = "DELETE FROM comments WHERE cid={$cid}";
                mysqli_query($con, $comment);
                header("Location: profile.php?uid=".$id);
                   }
        
        $select_rating="select * FROM rating WHERE fk_uid=".$id;
        $result = mysqli_query($con, $select_rating);
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>
<!DOCTYPE html>
<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- custom styles -->
    <script src="https://kit.fontawesome.com/a3873631ca.js" crossorigin="anonymous"></script>
</head>

<body>
<body>
<!--HEADER-->
<?php include "header.php" ?>
<!--HEADER-->
<div class="overall">
<?php if(isset($_GET['uid'])): ?>
    <div class="profilePosts" id="mobilesecond">
        <h1>My Posts</h1>
        <?php foreach($post_rows as $row): ?>

            <div class="eapost2">
            <p class="title titleSection"><?php echo $row['title']; ?></p>
            <img class="postImg" src=<?php echo $row['img_link']; ?> />
            <p class="descrp"><?php echo $row['description']; ?></p>
            <p class="date"><?php echo $row['upload_date']; ?></p>
            <?php if (isset($_SESSION['name'])): ?>
            <a class="readmore" href="profile.php?uid=<?php echo $_GET['uid']; ?>&pid=<?php echo $row['pid']; ?>" name="readm">Read More</a>
            <?php endif ?>
    <!--            Only user can delete his own posts-->
            <?php if ($_SESSION['uid'] == $id OR $_SESSION['uid'] == 1): ?>
                <a class="readmore" onClick="javascript: return confirm('Please confirm deletion');" href="delete.php?pid=<?php echo $row['pid']; ?>" name="readm"><i class="fas fa-trash"></i></a>
            <?php endif ?>
            </div>   
        <?php endforeach; ?>
        <?php if($nums > 2): ?>
        <a class="pViewmore" href="readmore.php?uid=<?php echo $id; ?>">More Posts ...</a>
        <?php endif ?>
    </div>
    <div class="generalInfo" id="mobilefirst">
        <div class="userHeader">
        <h1>My Information</h1>
        <?php if($_SESSION['uid'] == $id): ?>
        <a href="edit.php">Edit</a>
        <?php endif ?>
        </div>
        <div class="userInfo">
            <img class="Pavatar" src="<?php echo $userInfo['avatar']?>">
            <h2><?php echo $userInfo['fname']?> <?php echo $userInfo['lname']?></h2>
            <h3><em><?php echo $userInfo['role']?></em></h3>
            <h3>Contact: <?php echo $userInfo['contact']?></h3>
            <h3>Email: <?php echo $userInfo['email']?></h3>
            <h3>About Me: <?php echo $userInfo['user_description']?></h3>
            
        
        </div>
        
        <div class='rate'>
        
                <?php
    if(isset($_POST['submit_rating']))
    {
        $rating = $_POST["rating"];
        $uid = $_SESSION['uid'];
        $fk_uid = $id;
        $usname = $_SESSION['name'];
        $star1 = 'uploads/1star.png';
        $star2 = 'uploads/2star.png';
        $star3 = 'uploads/3star.png';
        $star4 = 'uploads/4star.png';
        $star5 = "uploads/5star.png";
        $check = "SELECT star FROM rating WHERE uid=".$_SESSION['uid']." AND fk_uid =".$id;
        $c_check = mysqli_query($con, $check);
        $c_checks = mysqli_fetch_assoc($c_check);
        $c_result = mysqli_query($con, $select_rating);
        $c_total = mysqli_num_rows($c_result);
        if ($c_total == 0 or $c_checks == NULL){
            if($rating <= 1){
            $sql = "INSERT INTO rating (rid, rating, uid, fk_uid, username, star) VALUES('','1', '$uid', '$fk_uid', '$usname', '$star1')";
            $insert=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);  
            }
            if($rating == 2){
            $sql = "INSERT INTO rating (rid, rating, uid, fk_uid, username, star) VALUES('','$rating', '$uid', '$fk_uid', '$usname', '$star2')";
            $insert=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);  
            }
            if($rating == 3){
            $sql = "INSERT INTO rating (rid, rating, uid, fk_uid, username, star) VALUES('','$rating', '$uid', '$fk_uid', '$usname', '$star3')";
            $insert=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);  
            }
            if($rating == 4){
            $sql = "INSERT INTO rating (rid, rating, uid, fk_uid, username, star) VALUES('','$rating', '$uid', '$fk_uid', '$usname', '$star4')";
            $insert=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);  
            }
            if($rating == 5){
            $sql = "INSERT INTO rating (rid, rating, uid, fk_uid, username, star) VALUES('','$rating', '$uid', '$fk_uid', '$usname', '$star5')";
            $insert=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);  
            }
        }
        else{
            if($rating == 5){
            $sql = "UPDATE rating SET rating =".$rating.", star = 'uploads/5star.png' WHERE uid=".$uid." AND fk_uid=".$fk_uid;   
            $inserts=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);
            }
            if($rating == 4){
            $sql = "UPDATE rating SET rating =".$rating.", star = 'uploads/4star.png' WHERE uid=".$uid." AND fk_uid=".$fk_uid;  
            $inserts=mysqli_query($con, $sql);
            var_dump($sql);   
            header("Location: profile.php?uid=".$id);
            }
            if($rating == 3){
            $sql = "UPDATE rating SET rating =".$rating.", star = 'uploads/3star.png' WHERE uid=".$uid." AND fk_uid=".$fk_uid;   
            $inserts=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);
            }
            if($rating == 2){
            $sql = "UPDATE rating SET rating =".$rating.", star = 'uploads/2star.png' WHERE uid=".$uid." AND fk_uid=".$fk_uid;  
            $inserts=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);
            }
            if($rating <= 1){
            $sql = "UPDATE rating SET rating = 1, star = 'uploads/1star.png' WHERE uid=".$uid." AND fk_uid=".$fk_uid;   
            $inserts=mysqli_query($con, $sql);
            header("Location: profile.php?uid=".$id);
            }
            
        }
        
    }
                $crate = "SELECT star FROM rating WHERE uid=".$_SESSION['uid']." AND fk_uid =".$id;
                $stars = mysqli_query($con, $crate);
                $star = mysqli_fetch_assoc($stars);
                
                $select_ratings="select * FROM rating WHERE fk_uid=".$id;

                $result = mysqli_query($con, $select_rating);

                $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $total = mysqli_num_rows($result);
                $raa = array();
                foreach($results as $row)
                {
                    $raa[]=$row['rating'];

                }
                if(array_sum($raa) != NULL){
                    $total_rating=(array_sum($raa)/$total);
                }
                else{
                    $total_rating = 0;
                }
                ?>
    
                <form class="rateform" method="post">
                    <p id="total_votes">Total rates:<?php echo $total;?></p>
                    <div class="rate_img">
                        <p>Average (<?php echo $total_rating;?>)</p>
                        <input type="hidden" id="rate1_hidden" value="1">
                        <img src="uploads/star1.png" onmouseover="change(this.id);" id="rate1" class="rate">
                        <input type="hidden" id="rate2_hidden" value="2">
                        <img src="uploads/star1.png" onmouseover="change(this.id);" id="rate2" class="rate">
                        <input type="hidden" id="rate3_hidden" value="3">
                        <img src="uploads/star1.png" onmouseover="change(this.id);" id="rate3" class="rate">
                        <input type="hidden" id="rate4_hidden" value="4">
                        <img src="uploads/star1.png" onmouseover="change(this.id);" id="rate4" class="rate">
                        <input type="hidden" id="rate5_hidden" value="5">
                        <img src="uploads/star1.png" onmouseover="change(this.id);" id="rate5" class="rate">
                    </div>

                    <input type="hidden" name="rating" id="raterating" value="0">
                    <input type="submit" value="Rate" name="submit_rating">

                </form> 
        
            </div>  
        
        <div class="commt"> 

                <?php	
            $usid = $id;
            $fk_uid = $id;
            echo "<form method='GET'>
                <input type='hidden' name='uid' value= '$usid'>
                <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                <input type='hidden' name='fk_uid' value='$fk_uid'>
                <textarea name='message'></textarea><br>
                <button name='commentsubmit' type='submit'>Comment</button><br>
                </form>";

            if(isset($_GET['commentsubmit'])){
                $usid = $_SESSION['uid'];
                $date = $_GET['date'];
                $message = $_GET['message'];
                $fk_uid = $id;
                $usname = $_SESSION['name'];
                $avatar = $pic['avatar'];
                $comment = "INSERT INTO comments (usid, date, message, fk_uid, username,avatar) VALUES('$usid','$date','$message','$fk_uid', '$usname','$avatar')";
                $result = mysqli_query($con, $comment);
                header("Location: profile.php?uid=".$id);
            }      



            $comment = "SELECT * FROM comments WHERE fk_uid=".$id;
            $showc = mysqli_query($con, $comment);
            $showcs = mysqli_fetch_all($showc, MYSQLI_ASSOC);


           // var_dump($vid_details);
            mysqli_close($con);
        ?>

            <?php foreach($showcs as $row): ?>
                <div class='comments'>
                    <div class=pic>
                        <img class="Pavatar" src="<?php echo $row['avatar']?>">
                        <p><?php echo $row['username']; ?></p>
                    </div>
                        <br><br>
                    <div class="messa">
                    <?php if($row['re_mess'] != NULL): ?>
                    <p>Reply to: <?php echo $row['re_name'] . ', Message: '. nl2br($row['re_mess']);?></p>
                    <?php endif ?> 
                    <p><?php echo nl2br($row['message']); ?></p>
    
                        </div>
                     <div class="commentdate">   
                    <p><?php echo $row['date']; ?></p>
       
              
                         
                  <?php
                 if($_SESSION['name'] == $row['username'] OR $_SESSION['uid']== $_GET['uid']){        

                echo "<form method='POST'>
                <input type='hidden' name='cid' value= '".$row['cid']."'>
                <button type ='submit' name='commentdelete'>Delete</button>
                </form>";
                 }
                ?>        
                <?php	
                $usid = $id;
                $fk_uid = $id;
                echo "<form method='GET' action='reply.php'>
                <input type='hidden' name='cid' value= '".$row['cid']."'>
                <input type='hidden' name='uid' value= '$usid'>
                <input type='hidden' name='date' value='".$row['date']."'>
                <input type='hidden' name='username' value='".$row['username']."'>
                <input type='hidden' name='fk_uid' value='$fk_uid'>
                <input type='hidden' name='message' value='".$row['message']."'>
                <button name='commentreply' type='submit'>Reply</button><br>
                </form>";       
                         
                         
                ?> 
                <a class="repor" href="reports.php?cid=<?php echo $row['cid']; ?>"><i class="fas fa-flag"></i></a>
                </div>
            </div>
            <?php endforeach ?> 



            </div>
            <?php else: ?>
        <h1>Where is your uid? :)</h1>
    </div>
<?php endif ?> 
</div>
    
<?php if(isset($_GET['pid'])AND isset($_GET['uid'])): ?>
<div class="bgk">
    <div class="content">
        <div class="myinfo">
            <br>
            <br>
        <p class="title">Title: <?php echo $info['title']; ?></p>
        <img src=<?php echo $info['img_link']; ?> height=300px max-width=100%/>
        <p class="descrp">Description: <?php echo $info['description']; ?></p>
        <p class="descrp">Contact:<?php echo $info['contact']; ?></p>
            <p class="descrp">Email:<?php echo $info['email']; ?></p>
        <p class="date"><?php echo $info['upload_date']; ?></p>
        <a id="closePost" href="profile.php?uid=<?php echo $_GET['uid']; ?>">+</a>
    </div>
    </div>
</div>
<?php endif ?>
    
<script>
    
    document.getElementById('closePost').addEventListener('click', function(){
        document.querySelector('.bgk').style.display="none";
    });

</script>
    <script type="text/javascript">

       function change(id)
       {
          var star=document.getElementById(id).className;
          var rate=document.getElementById(id+"_hidden").value;
          document.getElementById(star+"rating").value=rate;

          for(var i=rate;i>=1;i--)
          {
             document.getElementById(star+i).src="uploads/star2.png";
          }
          var id=parseInt(rate)+1;
          for(var j=id;j<=5;j++)
          {
             document.getElementById(star+j).src="uploads/star1.png";
          }
       }

    </script>
</body>
</html>