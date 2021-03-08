<?php
    session_start();
    include "connection.php";
    if(isset($_POST['upload']) AND isset($_POST['types'])){
        $reporter = $_SESSION['uid'];
        $reasons = mysqli_real_escape_string($con, $_POST['types']);
         if(isset($_GET['pid'])){
             $id = $_GET['pid'];
             $uid = "select uid_fk from posts where pid = {$id}";
                $uid_result = mysqli_fetch_assoc(mysqli_query($con, $uid));
                $uid_fk = $uid_result['uid_fk'];
                 $up_report = "INSERT INTO reports (uid_fk,pid_fk,reason,rep_id) VALUES ('$uid_fk','$id','$reasons','$reporter')";
            mysqli_query($con,$up_report);
            }elseif(isset($_GET['cid'])){
             $id = $_GET['cid'];
             $uid = "select usid, fk_uid from comments where cid = {$id}";
                $uid_result = mysqli_fetch_assoc(mysqli_query($con, $uid));
                $uid_fk = $uid_result['usid'];
                $profile_id = $uid_result['fk_uid'];
                $up_report = "INSERT INTO reports (uid_fk,cid_fk,reason,rep_id) VALUES ('$uid_fk','$id','$reasons','$reporter')";
            mysqli_query($con,$up_report);
            header("Location: profile.php?uid={$profile_id}");
                }elseif(isset($_GET['vid'])){
                $id = $_GET['vid'];
                $uid = "select fk_uid from videos where vid = {$id}";
                $uid_result = mysqli_fetch_assoc(mysqli_query($con, $uid));
                $uid_fk = $uid_result['fk_uid'];
                $up_report = "INSERT INTO reports (uid_fk,vid_fk,reason,rep_id) VALUES ('$uid_fk','$id','$reasons','$reporter')";
            mysqli_query($con,$up_report);
            header("Location: videoCourse.php?search=all");
                    }
        
        mysqli_close($con);
        
     }
?>
<!DOCTYPE html>
<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Report Page</title>
	<link rel="stylesheet" type="text/css" href="css/newpos.css">
    <style>
        select{
            width:100%;
            margin:10px 0;
            padding:5px;
            font-size: 20px;
        }
        .form-group{
                margin-top:10%;
            }
    </style>
</head>

<body>
<div class="form-group">
     <a id="closePost" href="index.php">+</a>
    <h2>Report Content</h2>
	<form method="post">
        
		<select name="types" required>
             <option value="" selected disabled hidden>Choose here</option>
            <option>Inappropriate Videos</option>
			<option>Verbal Abuse</option>
			<option>Negative Posts</option>
            <option>Disturbing Content</option>
            <option>Hate Speech</option>
            <option>Spam or Misleading</option>
			<option>Offensive or Inappropriate Names</option>
			
        </select>
		
		<button type="submit" name="upload">Report</button>
	</form>
	  
</div>

</body>

</html>