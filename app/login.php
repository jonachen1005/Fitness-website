<?php
include "connection.php";

require_once "config.php";
$loginURL = $gClient->createAuthUrl();

if (isset($_GET['code'])){
    try{
        $gClient->authenticate($_GET['code']);
        $access_token = $gClient->getAccessToken();
        $token = $gClient->setAccessToken($access_token);
    }catch (Exception $e){
        echo $e->getMessage();
    }
    
    try {
        $pay_load = $gClient->verifyIdToken();
    }catch (Exception $e){
        echo $e->getMessage();
    }
//    var_dump($pay_load);
    $sql="SELECT * FROM users WHERE google_id = '{$pay_load['sub']}'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
    
    if ($row['google_id'] == NULL){
        $var_uid = $pay_load['sub'];
        $var_user = $pay_load['family_name'];
        $var_email = $pay_load['email'];
        $hashed_pass = $pay_load['at_hash'];
        $var_fname = $pay_load['family_name'];
        $var_lname = $pay_load['given_name'];
        $var_avartar = $pay_load['picture'];
        $sql2 ="INSERT INTO users (google_id, username, email, password, fname, lname, avatar) VALUES ('$var_uid','$var_user', '$var_email', '$hashed_pass', '$var_fname','$var_lname', '$var_avartar')";
		mysqli_query($con, $sql2);
    }
    else{
        $var_user = $pay_load['family_name'];
        $var_email = $pay_load['email'];
        $hashed_pass = $pay_load['at_hash'];
        $var_fname = $pay_load['family_name'];
        $var_lname = $pay_load['given_name'];
        $var_avartar = $pay_load['picture'];
        
        $sql3="UPDATE users SET
        username = '$var_user', 
        email = '$var_email',
        password = '$hashed_pass', 
        fname = '$var_fname', 
        lname = '$var_lname',
        avatar = '$var_avartar'
        WHERE google_id = {$pay_load['sub']}";
		mysqli_query($con, $sql3);
        
    }
    $sql4 = "SELECT * FROM users WHERE google_id = {$pay_load['sub']}";
        $uid = mysqli_query($con, $sql4);
        $row = mysqli_fetch_assoc($uid);
        $_SESSION['uid'] = $row['uid'];
        $_SESSION['name'] = $var_user;
        header("Location: index.php");
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Login Page</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
  <div class="form-bkg">
	<form class="login-form" name="form" method="post">
        <a id="closePost" href="index.php">+</a>
		<input type="text" name="username" placeholder="your username"/>
		<input type="password" name="password" placeholder="your password"/>
		<button type="submit" name="submit">Sign in</button>
        <br>
        <?php echo "<br><a class='glogin' href='$loginURL'>Login with Google </a>";?>
        <br>
        <br>
        <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
        
    </form>
      <?php
        if (isset($_POST['submit'])) {
            $var_user = mysqli_real_escape_string($con, $_POST['username']);
            $var_pass = mysqli_real_escape_string($con, $_POST['password']);

            $sql="SELECT * FROM users WHERE username = '$var_user'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $usersID="SELECT uid FROM users WHERE username = '$var_user'";
            $result3 = mysqli_query($con, $usersID);
            $id_row = mysqli_fetch_assoc($result3);
            if (password_verify($var_pass, $row['password'])) {
                session_start();
                $_SESSION['name'] = $var_user;
                $_SESSION['uid'] = $id_row['uid'];
                header("Location: index.php");
            }
            else{
                echo "<p>Invalid Password</p>";
            if ($row['username'] != $var_user){
                echo "<p>Invalid User Name </p>";
            }
        }
        }
        mysqli_close($con);
        ?>
</div>

</body>

</html>