<?php
session_start();
$uid = $_SESSION["uid"];
include "connection.php";

if (isset($_POST['submit'])){
	$var_title = mysqli_real_escape_string($con, $_POST['title']);
	$var_contact = mysqli_real_escape_string($con, $_POST['contact']);
	$var_email = mysqli_real_escape_string($con, $_POST['email']);
	$var_description = mysqli_real_escape_string($con, $_POST['description']);
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
				
				$fileDestination = 'uploads/'.$fileNameNew;
				
				move_uploaded_file($fileTmpName,$fileDestination);
                date_default_timezone_set('America/New_York');
                $date = date('Y/m/d H:i:s', time());
				$sql="INSERT INTO posts (title, description, img_link, contact, email,upload_date,uid_fk) VALUES ('$var_title', '$var_description', '$fileDestination', '$var_contact','$var_email','$date','$uid')";
				mysqli_query($con, $sql);
				echo "upload sucessfully!";
				header("Location:index.php");
			 }else{
				echo "The file size is over 8 mb!";
			 }
		  }else{
			 echo "There was an error uploading your file!";
		  }
	   }else{
		  echo "You cannot upload files of this type!";
	   }
    }else{
                date_default_timezone_set('America/New_York');
                $date = date('Y/m/d H:i:s', time());
				$sql="INSERT INTO posts (title, description, contact, email,upload_date,uid_fk) VALUES ('$var_title', '$var_description', '$var_contact','$var_email','$date','$uid')";
				mysqli_query($con, $sql);
				echo "upload sucessfully!";
                header("Location:index.php");
        }
}
mysqli_close($con);
?>
