<!-- <?php include('server.php')?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="main.js"></script>
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row	justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
				<h1>Register Now!</h1>
				<img src="images/heya.png"><br><br>
					<form method="POST" action="register.php">
					<input class="form-control" name="username" placeholder="Username..."><br>
					<input class="form-control" name="email" placeholder="Email..."><br>
					<input class="form-control" name="password" placeholder="Password..."><br>
					<input class="form-control" name="cpassword" placeholder="Confirm password..."><br>
					<input class="btn btn-primary" type="submit" name="reg_user" value="Register">
					<p>Already a member? <a href="index.php">Sign in</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html> -->



<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="index.php">Sign in</a>
  	</p>
  </form>
</body>
</html>