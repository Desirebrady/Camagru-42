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
</head>
<body> 
<header id="header">
    <div class="container-fluid">

      <div id="logo" class="pull-left">
		<h1><a href="#intro" class="scrollto">Camagru</a></h1>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
		<?php if (!empty($_SESSION['username'])) : ?>	
				Welcome, <?php echo $_SESSION['username']; ?>
				<?php else : ?>
				Welcome Anonymouse
		<?php endif ?>
          <li class="menu-active"><a href="index.php">Home</a></li>
          <li><a href="controllers/gallery.php">Gallery</a></li>
          <li><a href="controllers/webcam.php">Profile</a></li>
          <li class="menu-has-children"><a href="">Action</a>
            <ul>
              <li><a href="admin/login.php">Login</a></li>
              <li><a href="admin/signup.php">Sign Up</a></li>
			  <?php if (!empty($_SESSION['username'])) : ?>
              <li><a href="admin/logout.php" style="color: red;">Bye</a></li>
    		<?php endif; ?>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
<?php if (!empty($_SESSION['username'])): ?>

	<?php if (!$_SESSION['verified']): ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            You need to verify your email address!
            Sign into your email account and click
            on the verification link we just emailed you
            at
            <strong><?php echo $_SESSION['email']; ?></strong>
          </div>
        <?php else: ?>
          <button class="btn btn-lg btn-primary btn-block"> Verified User!!!</button>
        <?php endif;?>
		<?php endif;?>
		<br/>
  <br/>

		<div class="content-w3ls">
        	<div class="content-bottom">
				<h2>Welcome to Camagru</h2>
				<p>Already a member? <a href="admin/Login.php">Sign in</a></p>
				<p>New member? <a href="admin/signup.php">Sign up</a></p>
        	</div>
    	</div>
			</div>
		</div>
	</div>
    <div>
</body>
</html>
