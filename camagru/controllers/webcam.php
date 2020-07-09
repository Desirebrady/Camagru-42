<?php
include     'connect.php';
include 'get_uploads.php';
include '../lib/includes.php';
include	'../controllers/connect.php';
include	'logged_on.php';
//include 'logged_on.php';

function merge($filename_x, $filename_y, $username)
{

	// Get dimensions for specified images

	list($width_x, $height_x) = getimagesize($filename_x);
	list($width_y, $height_y) = getimagesize($filename_y);

	// Create new image with desired dimensions

	$image = imagecreatetruecolor($width_x,  $height_x);

	// Load images and then copy to destination image

	$image_x = imagecreatefromjpeg($filename_x);
	$image_y = imagecreatefrompng($filename_y);

	imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
	imagecopy($image, $image_y, 0, 0, 0, 0, $width_y, $height_y);
	imagecopymerge($image_x, $image, 0, 0, 0, 0, $width_x, $height_x, 100);

	// Save the resulting image to disk (as JPEG)
	$num = rand(10, 10000);
	$image_name = $num . '_' . $username . '.png';

	//imagepng($im,  IMAGES . '/' . $image_name);
	unlink(IMAGES . '/tmp1.png');
	imagejpeg($image, IMAGES . '/' . $image_name);

	return ($image_name);
	// Clean up
}
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{

	// function patch for respecting alpha work find on http://php.net/manual/fr/function.imagecopymerge.php
	$cut = imagecreatetruecolor($src_w, $src_h);
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

if (isset($_POST['cpt_1']) && $_POST['cpt_1'] != "" && isset($_POST['alpha'])) {
	$username = $_SESSION['username'];
	// get the content of the captured image from the webcam put it in a tmp img
	list($type, $data) = explode(';', $_POST['cpt_1']);
	list(, $data) = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents(IMAGES . '/tmp1.png', $data);

	// creat image from this temporary 
	$im = imagecreatefrompng(IMAGES . '/tmp1.png');

	// get selected alpha
	$alpha = imagecreatefrompng(IMAGES . '/alpha/' . $_POST['alpha'] . '.png');
	$image = merge(IMAGES . '/tmp1.png', IMAGES . '/alpha/' . $_POST['alpha'] . '.png', $username);
	$like_count = 0;

	$sql = "INSERT INTO images (username, image, like_count) VALUES ('$username','$image', '$like_count')";
	mysqli_query($db, $sql);
}

if (isset($_FILES['image']) && isset($_POST['alpha'])) {

	$image = $_FILES['image'];
	$extension = pathinfo($image['name'], PATHINFO_EXTENSION);

	if (in_array($extension, array('jpg', 'png'))) {
		$username = $_SESSION['username'];
		$num = rand(10, 10000);
		$image_name = $num . '_' . $username . '.' . $extension;
		move_uploaded_file($image['tmp_name'], IMAGES . '/' . $image_name);

		if ($extension == 'jpg')
			$im = imagecreatefromjpeg(IMAGES . '/' . $image_name);
		else if ($extension == 'png')
			$im = imagecreatefrompng(IMAGES . '/' . $image_name);

		$alpha = imagecreatefrompng(IMAGES . '/alpha/' . $_POST['alpha'] . '.png');

		imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

		imagepng($im,  IMAGES . '/' . $image_name);
		imagedestroy($im);
		$image = $image_name;
		$like_count = 0;

		$sql = "INSERT INTO images (username, image, like_count) VALUES ('$username','$image', '$like_count')";
		mysqli_query($db, $sql);
	}
}

if (isset($_GET['delete'])) {

	$id = $_GET['delete'];
	$select = mysqli_query($db, "SELECT * FROM images WHERE id=$id");
	$images = mysqli_fetch_all($select, MYSQLI_ASSOC);
	foreach ($images as $image) {
		unlink("../img/" . $image['image']);
		if ($image['username'] == $_SESSION['username']) {
			$db->query("DELETE FROM images WHERE id=$id");
			header('Location: webcam.php');
			die();
		}
	}
}
$results = mysqli_query($db, "SELECT * FROM images ORDER BY id DESC");
$images = mysqli_fetch_all($results, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/comments.css">
	<link rel="stylesheet" type="text/css" href="../css/my_style.css">
	<link rel="stylesheet" type="text/css" href="../css/Edit.css">
	<link rel="stylesheet" href="../css/admin.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style>
	</style>
</head>

<body data-spy="scroll" data-target="sidebar" data-offset="50">

	<div class="container-fluid">
		<header id="header">
			<div id="logo" class="pull-left">
				<h1><a href="#intro" class="scrollto">Camagru</a></h1>
			</div>
			<nav id="nav-menu-container">
				<ul class="nav-menu" style="color: #14FFFF; font-size: large">
					<?php if (!empty($_SESSION['username'])) : ?>
						<?php echo $_SESSION['username']; ?>
					<?php else : ?>
						Welcome Anonymouse
					<?php endif ?>
					<?php if (!$_SESSION['verified']) : ?>
						<li><a href="../index.php">Home</a></li>
						<li><a href="../admin/login.php?logout='0'">Logout</a></li>
					<?php else : ?>
						<li><a href="gallery.php">Gallery</a></li>
						<li class="menu-active menu-has-children"><a href="webcam.php">Profile</a>
							<ul style="margin-top: 0;">
								<li><a href="profile.php">Settings</a></li>
							</ul>
						</li>
						<li class="menu-has-children"><a href="#">Action</a>
							<ul style="margin-top: 0;">
								<?php if (!empty($_SESSION['username'])) : ?>
									<li><a href="../admin/login.php?logout='0'">Bye</a></li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif ?>
				</ul>
			</nav>
		</header>
		<div style="margin-top: 94px;">

			<div class="sidebar">
				<h2 style="margin-left: 6%;color: #14FFFF;">Your Pictures</h2>
				<div class="row">
					<main class="grid">
						<?php foreach ($images as $image) : ?>
							<div class="column" style="width: auto;padding: 27px !important">
								<?php
								if ($_SESSION['username'] === $image['username']) : ?>
									<img src="<?php echo '../img/' . $image['image'] ?>" width="450px" alt="">
									<a style="text-align: center; color: #18d26e;" href="?delete=<?php echo $image['id']; ?>" onclick="return('Sur sur sur ?')">Delete</a>
								<?php endif ?>
							</div>
						<?php endforeach; ?>
					</main>
				</div>
			</div>
		</div>
		<div class="container" style="margin-top: 3%;">

			<form method="POST" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="column">
						<div class="content-w3ls" style="margin-top:5%;">
							<div class="content-bottom" style="padding: 0em 1em; box-shadow: none">
								<div id="my_camera">

								</div>
							</div>
						</div>
						<div>
							<input class="btn btn-success" style="background-color: #03A9F4; border-color: #03A9F4;font-size: large;
									margin-left: 43%;margin-top: -12%;" type=button value="Smile" onClick="take_snapshot()">
							<input type="hidden" name="cpt_1" class="image-tag" id="cpt_1">
						</div>
					</div>
					<div class="column">
						<div class="content-w3ls" style="margin-top:5%;">
							<div class="content-bottom" style="padding: 0em 1em; box-shadow: none">
								<div id="results" style="color:  #14FFFF">Your captured image will appear here...</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div style="margin-left: 4.2%;">
						<input class="btn btn-info" type="file" name="image">
					</div>
					<div class="section over-hide z-bigger">
						<div class="section over-hide z-bigger">
							<div class="container pb-5">
								<div class="row justify-content-center pb-5">
									<div class="col-12 pt-5">
										<p class="mb-4 pb-2">Stickers</p>
									</div>
									<div class="col-12 pb-5">
										<input class="checkbox-tools" type="hidden" name="alpha" value="blank" id="tool-0" checked>
										<input class="checkbox-tools" type="radio" name="alpha" value="alphatest1" id="tool-1">
										<label class="for-checkbox-tools" for="tool-1">
											<img style="width: 118px; margin-left: -25px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest1.png">

										</label>
										<input class="checkbox-tools" type="radio" name="alpha" value="alphatest2" id="tool-2">
										<label class="for-checkbox-tools" for="tool-2">
											<img style="width: 50px; margin-left: -2px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest2.png">
										</label>
										<input class="checkbox-tools" type="radio" name="alpha" value="alphatest3" id="tool-3">
										<label class="for-checkbox-tools" for="tool-3">
											<img style="width: 100px;margin-left: -16px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest3.png">
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 text-center">
						<br />
						<button class="btn btn-success">Submit</button>
					</div>
				</div>
			</form>
		</div>
		<script language="JavaScript">
			Webcam.set({
				width: 445,
				height: 400,
				image_format: 'jpeg',
				jpeg_quality: 100
			});
			Webcam.attach('#my_camera');

			function take_snapshot() {
				Webcam.snap(function(data_uri) {
					$(".image-tag").val(data_uri);
					document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
				});
			}
		</script>


		<!-- <?php include '../footer.php'; ?> -->
	</div>

</body>

</html>