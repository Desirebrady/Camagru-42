<?php include('../admin/app_logic.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Password Reset</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/my_style.css">
	<link rel="stylesheet" href="../css/admin.css">
</head>

<body>
	<div style="color: #14FFFF; margin-top: 20%">
		<form class="login-form" action="login.php" method="post" style="text-align: center;">
			<p>
				We sent an email to <b style="color: chartreuse;"><?php echo $_GET['email'] ?></b> to help you recover your account.
			</p>
			<p>Please login into your email account and click on the link we sent to reset your password</p>
			<p>You can close this window</p>
		</form>
	</div>
</body>

</html>