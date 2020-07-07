<?php
session_start();
include     '../controllers/connect.php';
include     'plus_like.php';
date_default_timezone_set('Africa/Johannesburg');


$images_per_page = 3;
$sql = "SELECT * FROM images";
$result = mysqli_query($db, $sql);
$number_of_images = mysqli_num_rows($result);

$number_of_pages = ceil($number_of_images / $images_per_page);

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);

	if ($page > $number_of_pages) {
		$page = $number_of_pages;
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
					<?php if (!$_SESSION['verified']) : ?>
						<li><a href="../index.php">Home</a></li>
						<li><a href="../admin/login.php?logout='0'">Logout</a></li>
					<?php else : ?>
						<li><a href="gallery.php">Gallery</a></li>
						<li class="menu-has-children"><a href="webcam.php">Profile</a></li>
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
		</div>
	</header>
	<div class="container-fluid">
		<div class="row">
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
						<div class="feeds">
							<div class="feed">
								<div class="feed-header">
									<a class="feed-author-name" href="upload.php" style="color: #14FFFF;"><?php echo $image['username']; ?></a>
								</div>
								<div class="feed-image">
									<a href="comments.php?imageid=<?php echo $image['id']; ?>"><img src="<?php echo '../img/' . $image['image'] ?>" width="450px" height="450px;" alt=""></a>
									<br /><a href="<?php echo 'plus_like.php?id=' . $image['id'] ?>&page=<?php echo $page ?>"><img src="../img/alpha/like.png"></a>
									<a href="<?php echo 'unlike.php?id=' . $image['id'] ?>&page=<?php echo $page ?>"><img src="../img/alpha/unlike.png"></a><br />
									<p style="color:#47FF13;">[<?php echo $image['like_count']; ?>]</p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php
				for ($page = 1; $page <= $number_of_pages; $page++) {
					if ($page === 1)
						echo '<a href="gallery.php?page=' . $page . '">' . '<p style="color: #14FFFF;">' . $page . '</p>' . '</a> ';
					if ($page > 1)
						echo '<a href="gallery.php?page=' . $page . '">' .  '<p style="color: #14FFFF;">' . $page . '</p>' . '</a> ';
				}
				?>
			<?php endif ?>

			<?php include_once '../footer.php'; ?>
		</div>
	</div>
</body>

</html>