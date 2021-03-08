<?php
    include "function.php";
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reply Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- custom styles -->
    <script src="https://kit.fontawesome.com/a3873631ca.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="reply">
<?php	
            $usid = $id;
            $fk_uid = $id;
            $message = $_GET['message'];
            $cid_fk = $_GET['cid'];
            $name = $_GET['username'];
            $re = $message;
            $reply ="Reply to " .$name.', Message: '.$message;
            
            echo "<form method='GET'>
                <input type='hidden' name='cid' value= '$cid_fk'>
                <input type='hidden' name='uid' value= '$usid'>
                <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                <input type='hidden' name='fk_uid' value='$fk_uid'>
                <input type='hidden' name='rem' value='$re'>
                <input type='hidden' name='uname' value='$name'>
                <textarea name='message' placeholder='".$reply."'></textarea><br>
                <button name='commentsubmit' type='submit'>Reply</button><br>
                </form>";

        if(isset($_GET['commentsubmit'])){
                $rem = $_GET['rem'];
                $usid = $_SESSION['uid'];
                $date = $_GET['date'];
                $message = $_GET['message'];
                $fk_uid = $id;
                $usname = $_SESSION['name'];
                $avatar = $pic['avatar'];
                $cid_fk = $_GET['cid'];
                $re_name = $_GET['uname'];
                $comment = "INSERT INTO comments (usid, date, message, fk_uid, username,avatar,re_mess,re_name) VALUES('$usid','$date','$message','$fk_uid', '$usname','$avatar','$rem','$re_name')";
                $result = mysqli_query($con, $comment);
                header("Location: profile.php?uid=".$id);
            }      
?>
    </div>
</body>
</html>
        