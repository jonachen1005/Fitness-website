<?php
    session_start();
    include "connection.php";

if (isset($_GET['uid'])){
    $limiter = 6;
    $id =  mysqli_real_escape_string($con, $_GET['uid']);
    $posts = "SELECT * FROM posts as p,users as t WHERE p.uid_fk = t.uid AND uid=".$id. " ORDER BY upload_date DESC";
    $results = mysqli_query($con, $posts);
    $all_posts = "SELECT pid FROM posts WHERE uid_fk= {$id}";
                $num_posts = mysqli_query($con, $all_posts);
                $nums = mysqli_num_rows($num_posts);
                $pages = ceil($nums/$limiter);
    $post_rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
   }
 if (isset($_GET['pid'])){
    $id =  mysqli_real_escape_string($con, $_GET['pid']);
    $posts2 = "SELECT * FROM posts, users where uid = uid_fk AND pid=".$id;
    $post = mysqli_query($con, $posts2);
    $info = mysqli_fetch_assoc($post);
    }

if(isset($_GET['search'])){
    $limiter = 6;
   
    $keyWord =  mysqli_real_escape_string($con, $_GET['search']);
    if ($keyWord == "trainers"){
        $trainers = "SELECT * FROM users WHERE role = 'trainer' LIMIT $limiter";
        $my_users = mysqli_query($con, $trainers);
        //            Detect how many pages available for trainers
                $all_users = "SELECT uid FROM users WHERE role = 'trainer'";
                $num_users = mysqli_query($con, $all_users);
                $nums = mysqli_num_rows($num_users);
                $pages = ceil($nums/$limiter);
        
        if (isset($_GET['page'])){
                $start= $limiter*($_GET['page']-1);
                $users = "SELECT * FROM users WHERE role = 'trainer' LIMIT $start,$limiter"; 
                $my_users = mysqli_query($con, $users);
            }
    }
    elseif ($keyWord == "students"){
        $students = "SELECT * FROM users WHERE role = 'student' LIMIT $limiter";
        $my_users = mysqli_query($con, $students);
        //            Detect how many pages available for trainers
                $all_users = "SELECT uid FROM users WHERE role = 'student'";
                $num_users = mysqli_query($con, $all_users);
                $nums = mysqli_num_rows($num_users);
                $pages = ceil($nums/$limiter);
        
        if (isset($_GET['page'])){
                $start= $limiter*($_GET['page']-1);
                $users = "SELECT * FROM users WHERE role = 'student' LIMIT $start,$limiter"; 
                $my_users = mysqli_query($con, $users);
            }
    }
    elseif($keyWord == "posts"){
    $limiter = 9;
        $posts = "SELECT * FROM posts ORDER BY upload_date DESC LIMIT $limiter";
        $my_posts = mysqli_query($con, $posts);
        //            Detect how many pages available for trainers
                $all_posts = "SELECT pid FROM posts";
                $num_posts = mysqli_query($con, $all_posts);
                $nums = mysqli_num_rows($num_posts);
                $pages = ceil($nums/$limiter);
        
        if (isset($_GET['page'])){
                $start= $limiter*($_GET['page']-1);
                $posts = "SELECT * FROM posts ORDER BY upload_date DESC LIMIT $start,$limiter"; 
                $my_posts = mysqli_query($con, $posts);
            }
    }
    elseif($keyWord == "trainersposts"){
        $limiter = 9;
            $posts = "SELECT * FROM users as u, posts as p where p.uid_fk = u.uid AND u.role = 'trainer' ORDER BY upload_date DESC LIMIT $limiter";
            $my_posts = mysqli_query($con, $posts);
            //            Detect how many pages available for trainers
                    $all_posts = "SELECT pid FROM users as u, posts as p where p.uid_fk = u.uid AND u.role = 'trainer'";
                    $num_posts = mysqli_query($con, $all_posts);
                    $nums = mysqli_num_rows($num_posts);
                    $pages = ceil($nums/$limiter);

            if (isset($_GET['page'])){
                    $start= $limiter*($_GET['page']-1);
                    $posts = "SELECT * FROM users as u, posts as p where p.uid_fk = u.uid AND u.role = 'trainer' ORDER BY upload_date DESC LIMIT $start,$limiter"; 
                    $my_posts = mysqli_query($con, $posts);
                }
        }
    elseif($keyWord == "studentsposts"){
        $limiter = 9;
            $posts = "SELECT * FROM users as u, posts as p where p.uid_fk = u.uid AND u.role = 'student' ORDER BY upload_date DESC LIMIT $limiter";
            $my_posts = mysqli_query($con, $posts);
            //            Detect how many pages available for trainers
                    $all_posts = "SELECT pid FROM users as u, posts as p where p.uid_fk = u.uid AND u.role = 'student'";
                    $num_posts = mysqli_query($con, $all_posts);
                    $nums = mysqli_num_rows($num_posts);
                    $pages = ceil($nums/$limiter);

            if (isset($_GET['page'])){
                    $start= $limiter*($_GET['page']-1);
                    $posts = "SELECT * FROM users as u, posts as p where p.uid_fk = u.uid AND u.role = 'student' ORDER BY upload_date DESC LIMIT $start,$limiter"; 
                    $my_posts = mysqli_query($con, $posts);
                }
        }
    if(isset($my_users)){
    $user_details = mysqli_fetch_all($my_users, MYSQLI_ASSOC);}
    
    if(isset($my_posts)){
    $posts_details = mysqli_fetch_all($my_posts, MYSQLI_ASSOC);}
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
<body>
<!--HEADER-->
<?php include "header.php" ?>
<!--HEADER -->   
<!--    Content     -->
<main>
<?php if(isset($_GET['search'])): ?>
<div class="userHeader">
    <?php if($_GET['search']=="trainers"): ?>
        <h2 class="ptitle">Trainers</h2>
        <a href="readmore.php?search=students">Looking for students?</a>
    <?php elseif($_GET['search']=="students"): ?>
        <h2 class="ptitle">Students</h2>
        <a href="readmore.php?search=trainers">Looking for trainers?</a>
    <?php elseif($_GET['search']=="posts"): ?>
        <h2 class="ptitle">All Posts</h2>
    <div>
       <a href="readmore.php?search=trainersposts">trainers</a>
       <a href="readmore.php?search=studentsposts">students</a>
    </div>
    <?php elseif($_GET['search']=="trainersposts"): ?>
        <h2 class="ptitle">Trainers' Posts</h2>
    <div>
        <a href="readmore.php?search=posts">all posts</a>
       <a href="readmore.php?search=studentsposts">students</a>
    </div>
    <?php elseif($_GET['search']=="studentsposts"): ?>
        <h2 class="ptitle">Students' Posts</h2>
    <div>
        <a href="readmore.php?search=posts">all posts</a>
       <a href="readmore.php?search=trainersposts">trainers</a>
    </div>
    <?php endif ?>
</div>
<?php endif ?>
<!--User info-->
<?php if(isset($user_details)): ?>
    <div class="myposts">
    <?php foreach($user_details as $row): ?>
        <div class="eapost">
            <br>
        <p class="title"><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></p>
        <img class="avatarImg" src=<?php echo $row['avatar']; ?> />
        <p class="descrp"><?php echo $row['role']; ?></p>
        <?php if (isset($_SESSION['name'])): ?>
        <a class="readmore" href="profile.php?uid=<?php echo $row['uid']; ?>">Read More</a>
        <?php endif ?>
    </div>
    <?php endforeach; ?>
        </div>
<?php endif ?>

<!--Posts for registered users-->
<?php if(isset($posts_details)): ?>
    <div class="myposts">
    <?php foreach($posts_details as $row): ?>
        <div class="eapost">
        <p class="title titleSection"><?php echo $row['title']; ?></p>
        <img class="postImg" src=<?php echo $row['img_link']; ?> />
        <p class="descrp"><?php echo $row['description']; ?></p>
        <p class="date"><?php echo $row['upload_date']; ?></p>
        <?php if (isset($_SESSION['name'])): ?>
        <a class="readmore" href="readmore.php?search=posts&pid=<?php echo $row['pid']; ?>" name="readm">Read More</a>
        <a class="repor" href="reports.php?pid=<?php echo $row['pid']; ?>"><i class="fas fa-flag"></i></a>
        <?php endif ?>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif ?>

<!--Posts for User in profile page-->
 <?php if(isset($post_rows) AND isset($_SESSION['name']) AND isset($_SESSION['uid'])): ?> 
<div class="postSection">
<div class="sptitle">
    <span class="ptitle">Posts</span>
    <a class="viewmore" href="profile.php?uid=<?php echo $id; ?>">Back to Profile</a>
    </div></div>
<div class="myposts">
    <?php foreach($post_rows as $row): ?>
        <div class="eapost">
        <p class="title titleSection"><?php echo $row['title']; ?></p>
        <img class="postImg" src=<?php echo $row['img_link']; ?> />
        <p class="descrp"><?php echo $row['description']; ?></p>
        <p class="date"><?php echo $row['upload_date']; ?></p>
        <?php if (isset($_SESSION['name'])): ?>
        <a class="readmore" href="readmore.php?uid=<?php echo $row['uid']; ?>&pid=<?php echo $row['pid']; ?>" name="readm">Read More</a>
        <?php endif ?>
        <?php if ($_SESSION['uid'] == $id OR $_SESSION['uid'] == 1): ?>
                <a class="readmore" onClick="javascript: return confirm('Please confirm deletion');" href="delete.php?pid=<?php echo $row['pid']; ?>" name="readm"><i class="fas fa-trash"></i></a>
            <?php endif ?>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif ?>

<!--Pagination-->
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
        <?php if(isset($user_details) OR isset($posts_details) OR isset($post_rows)): ?>
        <?php for($i=1;$i<$pages+1;$i++): ?>
        <a class="pagination" style='<?php echo focusbutton($i); ?>' href="?search=<?php echo $keyWord; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor ?>
        <?php endif ?>
    </div>
    <?php if(isset($_GET['pid'])): ?>
    <div class="bgk">
        <div class="content">
            <div class="myinfo">
                <br>
                <br>
            <p class="title">Title: <?php echo $info['title']; ?></p>
            <img src=<?php echo $info['img_link']; ?> height=300px;/>
            <p class="descrp">Description: <?php echo $info['description']; ?></p>
            <p class="descrp">Contact:<?php echo $info['contact']; ?></p>
            <p class="descrp">Poster: <a href="profile.php?uid=<?php echo $info['uid']; ?>"><?php echo $info['username']; ?></a></p>
                <p class="descrp">Email:<?php echo $info['email']; ?></p>
            <p class="date"><?php echo $info['upload_date']; ?></p>
            <?php if(isset($_GET['uid']) AND isset($_GET['pid'])): ?>
            <a id="closePost" href="readmore.php?uid=<?php echo $info['uid']; ?>">+</a>
            <?php else: ?>
             <a id="closePost" href="readmore.php?search=posts">+</a>   
            <?php endif ?>
        </div>
        </div>
    </div>
<?php endif ?>
</main>

<script>
    
    document.getElementById('closePost').addEventListener('click', function(){
        document.querySelector('.bgk').style.display="none";
    });

</script>
</body>

</html>
