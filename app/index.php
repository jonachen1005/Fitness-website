<?php
    session_start();
    include "connection.php";
    if (isset($_GET['pid'])){
    $id =  mysqli_real_escape_string($con, $_GET['pid']);
    $posts2 = "SELECT * FROM posts, users where uid = uid_fk AND pid=".$id;
    $post = mysqli_query($con, $posts2);
    $info = mysqli_fetch_assoc($post);
    }
    $posts = "SELECT * FROM posts ORDER BY upload_date DESC LIMIT 6";
    $results = mysqli_query($con, $posts);
    $post_rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
    $trainers = "SELECT * FROM users WHERE role = 'trainer' ORDER BY RAND() LIMIT 3";
    $trainer_results = mysqli_query($con, $trainers);
    $trainer_rows = mysqli_fetch_all($trainer_results, MYSQLI_ASSOC);
    if(isset($_SESSION['uid'])){
    $user_status = "select status from users where uid = {$_SESSION['uid']}";
    $status_result = mysqli_fetch_assoc(mysqli_query($con, $user_status));
    }
//    var_dump($rows);
    mysqli_close($con);
?>
<?php if(isset($status_result) AND $status_result['status'] == 0): ?>
<?php session_destroy(); ?>
<center><h1>Your Account is Suspended</h1></center>
<center><h1><a href="contact.php">Contact Us</a></h1></center>

<?php else: ?>
<?php include 'content.php';?>
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
        <a id="closePost" href="index.php">+</a>
    </div>
    </div>
</div>
<?php endif ?>
<?php endif ?>
<script>
    
    document.getElementById('closePost').addEventListener('click', function(){
        document.querySelector('.bgk').style.display="none";
    });

</script>

</body>

</html>
