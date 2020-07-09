<?php
session_start();
include     '../controllers/connect.php';
include     'plus_like.php';
date_default_timezone_set('Africa/Johannesburg');

$next = 0;
$prev = 0;
$images_per_page = 5;
$sql = "SELECT * FROM images";
$result = mysqli_query($db, $sql);
$number_of_images = mysqli_num_rows($result);
$page = 1;

$number_of_pages = ceil($number_of_images / $images_per_page);

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	$next = $page + 1;
	$prev = $page - 1;
	if ($page > $number_of_pages && $next > $number_of_pages) {
		$page = $number_of_pages;
		$next = $page;
	} elseif ($page < 1) {
		$page = 1;
	}
} else {
	$page = 1;
}
$start_limit = ($page - 1) * $images_per_page;

$results = mysqli_query($db, "SELECT * FROM images ORDER BY id DESC LIMIT " . $start_limit . ',' . $images_per_page);
$images = mysqli_fetch_all($results, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Gallery</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/my_style.css">
	<link rel="stylesheet" href="../css/admin.css">
	<style>
		.column {
			float: left;
			width: 33.33%;
			padding: 5px;
		}

		/* Clear floats after image containers */
		.row::after {
			content: "";
			clear: both;
			display: table;
		}

		.pagination {
			display: inline-flex;
			padding-left: 0;
			/* margin: 20px 0; */
			border-radius: 4px;

		}

		.pagination a {
			background: rgba(0, 0, 0, 0.4);
			margin-left: 50%;
			color: black;
			float: left;
			padding: 8px 16px;
			text-decoration: none;
			transition: background-color .3s;
			border: 1px solid #ddd;
		}

		.pagination a.active {
			background-color: #4CAF50;
			color: white;
			border: 1px solid #4CAF50;
		}

		.pagination a:hover:not(.active) {
			background-color: #ddd;
		}
	</style>
</head>

<body>

	<div class="container-fluid">
		<div class="">
			<header id="header">
				<div id="logo" class="pull-left">
					<h1><a href="#intro" class="scrollto">Camagru</a></h1>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu" style="color: #14FFFF; font-size: large">
						<?php if (!empty($_SESSION['username'])) : ?>
							Welcome, <?php echo $_SESSION['username']; ?>
						<?php else : ?>
							Welcome Guest
						<?php endif ?>
						<?php if (!$_SESSION['verified']) : ?>
							<li><a href="../index.php">Home</a></li>
							<li><a href="../admin/login.php?logout='0'">Logout</a></li>
						<?php else : ?>
							<li class="menu-active"><a href="gallery.php">Gallery</a></li>
							<li class="menu-has-children"><a href="webcam.php">Profile</a></li>
							<li class="menu-has-children"><a href="#">Action</a>
								<ul style="margin-top: 0;">
									<?php if (!empty($_SESSION['username'])) : ?>
										<li><a href="../admin/login.php?logout='0'" style="color: white">Bye</a></li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif ?>
					</ul>
				</nav>
			</header>
			<?php if (!$_SESSION['verified']) : ?>
				<div class="alertalert-success" role="alert" style="margin-top: 5%;margin-left: 20%;margin-right: 20%;">
					<h4 class="alert-heading" style="color: #14FFFF;">Welcome! </h4>
					<p style="color: #14FFFF;">Aww yeah, you successfully registered. One more step!</p>
					<hr>
					<p class="mb-0" style="color: #14FFFF;">
						You need to verify your email address! Sign into your email account and click on the verification link we just emailed you at
						<strong style="color: red;"><?php echo $_SESSION['email']; ?></strong>
					</p>
				</div>
			<?php else : ?>

				<div style="margin-top: 5%;">
					<?php foreach ($images as $image) : ?>
						<div class="column">
							<div class="content-w3ls" style="margin-top:5%;">
								<div class="content-bottom" style="padding: 0em 1em;">
									<div class="feed-header">
										<a class="feed-author-name" href="upload.php" style="color: #14FFFF;font-size: large"><?php echo $image['username']; ?></a>
									</div>
									<div>
										<a href="comments.php?imageid=<?php echo $image['id']; ?>"><img src="<?php echo '../img/' . $image['image'] ?>" width="450px" height="450px;" alt=""></a>
										<br /><a href="<?php echo 'plus_like.php?id=' . $image['id'] ?>&page=<?php echo $page ?>"><img src="../img/alpha/like.png" width="35px;"></a>
										<a href="<?php echo 'unlike.php?id=' . $image['id'] ?>&page=<?php echo $page ?>"><img src="../img/alpha/unlike.png" width="35px;"></a><br />
										<?php if ($image['like_count'] == 1 && $_SESSION['username']) { ?>
											<p style="color:#14FFFF"><?php echo $image['like_count']; ?> Like</p>
										<?php } ?>
										<?php if ($image['like_count'] == 0 || $image['like_count'] > 1 && $_SESSION['username']) { ?>
											<p style="color:#14FFFF"><?php echo $image['like_count']; ?> Likes</p>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

				</div>
				<div class="row">
					<div class="column" style="margin-left: 45%;">
						<?php
						if ($page < $number_of_pages && $page > 1) {
							echo	'<div class="pagination">
								<a style="color: #14FFFF;" href="gallery.php?page=' . $prev . '">' .  '❮' . '</a>';
							echo		'<a style="color: #14FFFF;" href="gallery.php?page=' . $next . '">' .  '❯' . '</a>
							</div>  ';
						} elseif ($page == $number_of_pages && $page > 1) {
							echo	'<div class="pagination">
								<a style="color: #14FFFF;" href="gallery.php?page=' . $prev . '">' .  '❮' . '</a>';
						}
						if ($page == 1 && $number_of_pages != 1) {
							$next = $page + 1;
							echo	'<div class="pagination">
								<a style="color: #14FFFF;" href="gallery.php?page=' . $next . '">' .  '❯' . '</a> 
							</div>';
						}
						?>
					</div>
				</div>
			<?php endif ?>


		</div>

		<?php include_once '../footer.php'; ?>
	</div>
</body>

</html>