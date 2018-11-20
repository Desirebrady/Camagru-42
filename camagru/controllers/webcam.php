
<?php
include '../lib/includes.php';
include	'../controllers/connect.php';
include	'logged_on.php';
//include 'logged_on.php';


function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 

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
	file_put_contents( IMAGES .'/tmp1.png', $data);

	// creat image from this temporary 
	$im = imagecreatefrompng(IMAGES .'/tmp1.png');

	// get selected alpha
	$alpha = imagecreatefrompng(IMAGES .'/alpha/'.$_POST['alpha'].'.png');
		
	imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

	$num = rand(10, 10000);
	$image_name = $num.'_'.$username.'.png';

	imagepng($im,  IMAGES .'/'. $image_name);

	imagedestroy($im);
	$image = $image_name;
	$like_count = 0;

	$sql = "INSERT INTO images (username, image, like_count) VALUES ('$username','$image', '$like_count')";
	mysqli_query($db, $sql);

}

if (isset($_FILES['image']) && isset($_POST['alpha'])) {

	$image = $_FILES['image'];
	$extension = pathinfo($image['name'], PATHINFO_EXTENSION);

	if (in_array($extension, array('jpg', 'png'))){
		$username = $_SESSION['username'];
		$num = rand(10, 10000);
		$image_name = $num.'_'.$username.'.' . $extension;
		move_uploaded_file($image['tmp_name'], IMAGES .'/'. $image_name);

		if ($extension == 'jpg')
			$im = imagecreatefromjpeg(IMAGES .'/'. $image_name);
		else if ($extension == 'png')
			$im = imagecreatefrompng(IMAGES .'/'. $image_name);

		$alpha = imagecreatefrompng(IMAGES .'/alpha/'.$_POST['alpha'].'.png');

		imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

		imagepng($im,  IMAGES .'/'. $image_name);
		imagedestroy($im);
		$image = $image_name;
		$like_count = 0;

		$sql = "INSERT INTO images (username, image, like_count) VALUES ('$username','$image', '$like_count')";
  	    mysqli_query($db, $sql);
	}
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/my_style.css">
	<link rel="stylesheet" type="text/css" href="../css/comments.css">
</head>
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
            <li ><a href="../index.php">Home</a></li>
            <li ><a href="gallery.php">Gallery</a></li>
            <li class="menu-active"><a href="webcam.php">Profile</a></li>
            <li class="menu-has-children"><a href="">Action</a>
                <ul>
                <li><a href="../admin/login.php">Login</a></li>
                <li><a href="../admin/signup.php">Sign Up</a></li>
                <?php if (!empty($_SESSION['username'])) : ?>
                <li><a href="../admin/login.php?logout='0'" style="color: red;">Bye</a></li>
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
<li><a href="upload.php">Want to Edit Your Images ?</a></li>
	<div>
		<div >
			<video id="video"></video>
			<button class="btn btn-info" id="startbutton">Say Cheese</button>
			<canvas style="display: none" id="canvas"></canvas>
		</div>
		<div>
			<img id="photo" src="">
		</div>

		<form action="#" method="post" enctype="multipart/form-data">
			<div>
			<ul>
				<li><label><img style="width: 100px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest1.png"><input type="radio" name="alpha" value="alphatest1" checked="checked"></label></li>
				<li><label><img style="width: 100px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest2.png"><input type="radio" name="alpha" value="alphatest2"></label></li>
				<li><label><img style="width: 100px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest3.png"><input type="radio" name="alpha" value="alphatest3"></label></li>
			</ul>
			</div>
			<div>
				<input class="btn btn-info" type="file" name="image">
			</div>
			<br/>
			<div>
				<input id="cpt_1" type="hidden" name="cpt_1">
			</div>
			<button id="submit" class="btn btn-info" type="submit">POST</button>
		</form>
	</div>

	<script type="text/javascript">
	(function() {

		var streaming		= false,
			video			= document.querySelector('#video'),
			cover			= document.querySelector('#cover'),
			canvas			= document.querySelector('#canvas'),
			photo			= document.querySelector('#photo'),
			startbutton		= document.querySelector('#startbutton'),
			cpt_1			= document.querySelector('#cpt_1'),
			width			= 320,
			height			= 0;

		navigator.getMedia	= ( navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);

		function sleep(milliseconds) {
			var start = new Date().getTime();
				for (var i = 0; i < 1e7; i++) {
					if ((new Date().getTime() - start) > milliseconds){
						break;
				}
			}
		}

		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
		);

		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		function takepicture() {
			canvas.width = width;
			canvas.height = height;
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			var data = canvas.toDataURL('image/png');
			photo.setAttribute('src', data);
			cpt_1.setAttribute('value', data);
			console.log(data);
		}


		startbutton.addEventListener('click', function(ev){
			takepicture();
		}, false);

	})();
	</script>
<?php include '../footer.php'; 
