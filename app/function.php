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