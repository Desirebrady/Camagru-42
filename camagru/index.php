<!--
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sign In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="main.js"></script>
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row	justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
				<h1>Welcome!</h1>
				<img src="images/heya.png"><br><br>

				<form method="post" action="index.php">
				
					<input class="form-control" name="Username" placeholder="Username..."><br>
					<input class="form-control" name="password" placeholder="Password..."><br>
					<button class="btn btn-primary" type="submit" class="btn" name="login_user">Login</button>
					<p>New member? <a href="register.php">Sign up</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
?>-->

<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="gallery.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>