<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
	<title>Sign Up Page</title>
	<link rel="stylesheet" type="text/css" href="css\login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
	<div class="login-page">
  <div class="form-bkg">
	<form class="login-form" name="form" method="post">
        <a id="closePost" href="index.php">+</a>
      <input type="text" name="username"placeholder="username" required />
	  <input type="email" name="email" placeholder="enter your email" required />
      <input type="password" name="password" placeholder="password" required />
	  <input type="password" name="password2" placeholder=" repeat password" required />
      <input type="text" name="fname" placeholder="first name" required />
	  <input type="text" name="lname" placeholder="last name" required />
      <button type="submit" name="submit" >Create</button>
      <p class="message">Already registered? <a href="login.php">Sign In</a></p>
    </form>
      <?php
        include "connection.php";

        //When Clicked Submit Button
        if (isset($_POST['submit'])) {
        //    Set up variables
                $var_user = mysqli_real_escape_string($con, $_POST['username']);
                $var_email = mysqli_real_escape_string($con, $_POST['email']);
                $var_pass = mysqli_real_escape_string($con, $_POST['password']);
                $var_pass2 = mysqli_real_escape_string($con, $_POST['password2']);
                $var_fname = mysqli_real_escape_string($con, $_POST['fname']);
                $var_lname = mysqli_real_escape_string($con, $_POST['lname']);
        //    Find if email is existed
                $emails="SELECT * FROM users WHERE email = '$var_email'";
                $result = mysqli_query($con, $emails);
                $email_row = mysqli_fetch_assoc($result);
        //    Find if user is existed
                $users="SELECT * FROM users WHERE username = '$var_user'";
                $result2 = mysqli_query($con, $users);
                $username_row = mysqli_fetch_assoc($result2);
        //    Check conditions
                if ($var_user != $username_row['username'] && $var_email != $email_row['email'] && $var_pass == $var_pass2 && strlen($var_pass)>=8 ){
                $hashed_pass = password_hash($var_pass, PASSWORD_DEFAULT);
                $sql="INSERT INTO users (username, email, password, fname, lname) VALUES ('$var_user', '$var_email', '$hashed_pass', '$var_fname','$var_lname')";
                mysqli_query($con, $sql);
                echo 'Registration Successful!';
        //     Setting Up Sessions
                session_start();
                $_SESSION['name'] = $var_user;
                $usersID="SELECT uid FROM users WHERE username = '$var_user'";
                $result3 = mysqli_query($con, $usersID);
                $id_row = mysqli_fetch_assoc($result3);
                $_SESSION['uid'] = $id_row['uid'];
                header("Location: index.php");

                }

                if ($var_email == $email_row['email']){
                    echo "<p>The Email already existed</p>";
                }
                if ($var_user == $username_row['username']){
                    echo "<p>The Username already existed</p>";
                }
                if ($var_pass != $var_pass2) {
                    echo "<p>The repeat password doesn't match the first password</p>";
                }
                if (strlen($var_pass)<8){
                    echo "<p>password length is less than 8 characters</p>";
                }
                    }
        mysqli_close($con);
        ?>
  </div>
</div>

</body>

</html>