<?php include('app_logic.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Password Reset</title>
	<link rel="stylesheet" href="">
	<link rel="stylesheet" type="text/css" href="../css/my_style.css">
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
	<form class="login-form" action="enter_email.php" method="post">
		<div class="content-w3ls" style="font-size: 20px;">
			<div class="content-bottom" style="color: #14FFFF;">
				<h2>Reset password</h2>
				<?php include('../controllers/messages.php'); ?>
				<div class="form-group">
					<label>Your email address</label>
					<input type="email" name="email">
				</div>
				<div class="form-group">
					<button type="submit" name="reset-password" class="btn btn-success" style="background-color: #03A9F4; border-color: #03A9F4;">Submit</button>
				</div>
				<div>
					<a href="login.php" class="text-right">back</a>
				</div>
			</div>
		</div>
	</form>
</body>

</html>