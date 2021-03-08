<?php
    session_start();
    include "connection.php";
    $uid = $_SESSION['uid'];
    $userinfo = "SELECT * FROM users WHERE uid = {$uid}";
    $result = mysqli_query($con, $userinfo);
    $info = mysqli_fetch_assoc($result);
    
    if (isset($_POST['update'])){
        $var_email = mysqli_real_escape_string($con, $_POST['newEmail']);
	   if(!empty($var_email) && filter_var($var_email, FILTER_VALIDATE_EMAIL)==true){
           
           $updateEmail = "UPDATE users SET 
           email = '$var_email'
           WHERE uid = {$uid}";
           mysqli_query($con, $updateEmail);
       }
        if(isset($_POST['role'])){
            $role = mysqli_real_escape_string($con, $_POST['role']);
            $newRole = "UPDATE users SET 
           role = '$role'
           WHERE uid = {$uid}";
           mysqli_query($con, $newRole);
        }
        if(isset($_POST['newContact'])){
            $contact = mysqli_real_escape_string($con, $_POST['newContact']);
            $newCont = "UPDATE users SET 
           contact = '$contact'
           WHERE uid = {$uid}";
           mysqli_query($con, $newCont);}
            
        if(isset($_POST['user_description'])){
            $descrp = mysqli_real_escape_string($con, $_POST['user_description']);
            $newdescrp = "UPDATE users SET 
           user_description = '$descrp'
           WHERE uid = {$uid}";
           mysqli_query($con, $newdescrp);     
            
        }
    
	
	$file = $_FILES['file'];
	
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	
	
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	
	$allowed_type = array('jpg', 'jpeg', 'png');
	if ($_FILES['file']['size'] > 0){
	   if (in_array($fileActualExt, $allowed_type)){
		  if ($fileError === 0){
			 if ($fileSize < 8388608){
				$fileNameNew = uniqid('',true).".".$fileActualExt;
				
				$fileDestination = 'avatars/'.$fileNameNew;
				
				move_uploaded_file($fileTmpName,$fileDestination);
				$sql="UPDATE users SET avatar = '$fileDestination' WHERE uid='$uid'";
				mysqli_query($con, $sql);
			 }else{
				echo "The file size is over 8 mb!";
			 }
		  }else{
			 echo "There was an error uploading your file!";
		  }
	   }else{
		  echo "You cannot upload files of this type!";
	   }
    }
        header("Location:profile.php?uid={$uid}");
}
mysqli_close($con);
?>
<!DOCTYPE html>
<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="editpage">
	<form class="editPage" action="edit.php" method="post" enctype="multipart/form-data">
		<a id="closePost" href="profile.php?uid=<?php echo $uid; ?>">+</a>
		<p>
            <img class="Pavatar" src=<?php echo $info['avatar']; ?> />
            <br>
             <h2><?php echo $info['fname']?> <?php echo $info['lname']?></h2>
			<label>Profile Image:</label><input type="file" name="file"/>
		</p>
		<p>
			<label>Contact:</label>
			<input type="text" placeholder="(xxx)-xxx-xxxx" name="newContact" value="<?php echo $info['contact']; ?>"/>
		</p>
		<p>
			<label>Email:</label>
			<input type="email" name="newEmail" value="<?php echo $info['email']; ?>"/>
		</p>
        <p>
        <?php if($info['role'] == "student"):?>
            <p>You are a <b>student</b></p>
        <input type="radio" name="role" value="trainer">
            <label>trainer</label>
           <input type="radio" name="role" value="student" checked>
            <label>student</label><br>
        <?php else: ?>
            <p>You are a <b>trainer</b></p>
        <input type="radio" name="role" value="trainer" checked>
            <label>trainer</label>
           <input type="radio" name="role" value="student" >
            <label>student</label><br>
        <?php endif ?>
            
        
        </p>
		<p>
			<p>Description:</p>
			<textarea type="text" name="user_description" placeholder="Please Write Something About Yourself (256 characters)"style="width: 100%; resize:vertical; font-size:16px;height:300px;" maxlength="256"></textarea>
		</p>
		
		<button type="submit" name="update">Update</button>
	</form>

</body>

</html>