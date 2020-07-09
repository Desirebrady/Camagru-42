<?php
session_start()
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Welcome</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/my_style.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
	<div class="content-w3ls" style="font-size: 20px; margin-top: 10%	">
		<div class="content-bottom">
			<h2 style="color: white">Welcome!</h2>
			<br>
			<p style="color: white">Already a member? <a style="text-decoration: none;margin-left: 40px;" href="admin/Login.php">Sign in</a></p>
			<p style="color: white">New member? <a style="text-decoration: none; margin-left: 84px;" href="admin/signup.php">Sign up</a></p>
			<p style="text-align: center;"><a style="text-decoration: none;" href="controllers/gallery.php">View Gallery</a></p>
		</div>
	</div>
</body>

</html>