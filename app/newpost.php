<?php
    session_start();
?>
<!DOCTYPE html>
<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>NewPost Page</title>
	<link rel="stylesheet" type="text/css" href="css/newpos.css">
</head>

<body>
<div class="form-group">
     <a id="closePost" href="index.php">+</a>
    <h2>Upload Your Post</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<p>
			<label class="label">Title:</label>
			<input class="form-controll" type="text" placeholder="Enter Your Title (100 characters)" name="title" maxlength="100" required>
		</p>
		<p>
			<label class="label">Image File:</label>
			<input class="form-controll" type="file" name="file"/>
		</p>
		<p>
			<label class="label">Contact:</label>
			<input class="form-controll" type="text" placeholder="(xxx)-xxx-xxxx" name="contact" maxlength="30" required>
		</p>
		<p>
			<label class="label">Email:</label>
			<input class="form-controll" type="email" placeholder="Enter your email"name="email" required>
		</p>
		<p>
			<label class="label">Description:</label>
			<textarea class="form-controll" type="text" name="description" placeholder="Please Write Some Descriptions...... (1800 characters)"style="width: 100%;font-size:16px;height:150px;font-family:Times New Roman; max-width:100%;" maxlength="1800" required></textarea>
		</p>
		
		<button type="submit" name="submit">Upload</button>
	</form>
	  
</div>

</body>

</html>