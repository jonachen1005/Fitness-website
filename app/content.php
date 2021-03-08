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

<?php include "header.php" ?>
 
<main>
<div class="postSection">
    <div class="sptitle">
        <span class="ptitle">Trainers</span>
         <a class="viewmore" href="readmore.php?search=trainers">View More</a>
        </div>
</div>
<div class="myposts">
    <?php if(isset($trainer_rows)): ?>
    <?php foreach($trainer_rows as $row): ?>
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
    <?php endif ?>
</div>
</main>

<main>
    <div class="postSection">
        <div class="sptitle">
        <span class="ptitle">Advertisement Posts</span>
         <a class="viewmore" href="readmore.php?search=posts">View More</a>
        </div>
        <?php if (isset($_SESSION['name'])): ?>
        <a class="upPost" href="newpost.php">Upload A Post</a>
        <a class="upPost2" href="newpost.php">Upload</a>
        <?php endif ?>
    </div>

<div class="myposts">
    <?php if(isset($post_rows)): ?>
    <?php foreach($post_rows as $row): ?>
        <div class="eapost">
        <p class="title titleSection"><?php echo $row['title']; ?></p>
        <img class="postImg" src=<?php echo $row['img_link']; ?> />
        <p class="descrp"><?php echo $row['description']; ?></p>
        <p class="date"><?php echo $row['upload_date']; ?></p>
        <?php if (isset($_SESSION['name'])): ?>
        <a class="readmore" href="index.php?pid=<?php echo $row['pid']; ?>" name="readm">Read More</a>
        <a class="repor" href="reports.php?pid=<?php echo $row['pid']; ?>"><i class="fas fa-flag"></i></a>
        <?php endif ?>
        </div>
    <?php endforeach; ?>
    <?php endif ?>
</div>
</main>