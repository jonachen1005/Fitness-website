

<!DOCTYPE html>
<head>
	<title>Post Page</title>
</head>

<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<p>
			<label>Title:</label>
			<input type="text" placeholder="Enter Your Title" name="title"/required>
		</p>
		<p>
			<label>Image File:</label>
			<input type="file" name="file"/>
		</p>
		<p>
			<label>Contact:</label>
			<input type="text" placeholder="(xxx)-xxx-xxxx" name="contact"/required>
		</p>
		<p>
			<label>Email:</label>
			<input type="email" name="email"/required>
		</p>
		<p>
			<p>Description:</P>
			<textarea type="text" name="description" placeholder="Please Write Some Descriptions......"style="width: 300px;font-size:16px;height:300px;"required></textarea>
		</p>
		
		<button type="submit" name="submit">Upload</button>
	</form>

</body>

</html>