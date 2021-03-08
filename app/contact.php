<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Contact Form </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/contact.css">
    <style>
        #closePost{
            color:white;
        }
    </style>
</head>

<body>
    <a id="closePost" href="index.php">+</a>
		<div class= "contact-title">
            
		<h1>Say hello</h1>
		<h2>We are here to help you</h2>
		</div>
		
		<div class="contact-bkg">
            
		<form id="contact-form" method="post" action="contact-form-handler.php">
            
		<input name="name" type="text" class="form-control" placeholder="Your name" required>
		<br>
		<input name="email" type="email" class="form-control" placeholder="Your email" required>
		<br>
		<textarea name="message" class="form-control" placeholder="Your Message" row="4" required></textarea>
		<br>
		<input type="submit" class="form-control submit" value="Send Message">
		<br>
		
		</form>
		</div>

		
</body>

</html> 