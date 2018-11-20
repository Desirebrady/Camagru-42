<?php 
    session_start();
    include     '../controllers/connect.php';
    include     'plus_like.php';
    date_default_timezone_set('Africa/Johannesburg');


    $images_per_page = 5;
    $sql = "SELECT * FROM images";
    $result = mysqli_query($db, $sql);
    $number_of_images = mysqli_num_rows($result);

    $number_of_pages = ceil($number_of_images/$images_per_page);

    if (isset($_GET['page'])){
        $page = intval($_GET['page']);

        if ($page > $number_of_pages){
            $page = $number_of_pages;
        } elseif($page < 1){
            $page = 1;
        }
        
    }
    else{
            $page = 1;
        }
    $start_limit = ($page -1) * $images_per_page;

    $results = mysqli_query($db, "SELECT * FROM images ORDER BY id DESC LIMIT ".$start_limit.','.$images_per_page);
    $images = mysqli_fetch_all($results, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <li ><a href="../index.php">Home</a></li>
            <li class="menu-active"><a href="gallery.php">Gallery</a></li>
            <li><a href="webcam.php">Profile</a></li>
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
    <?php foreach ($images as $image): ?>
    <div class="feeds">
        <div class="feed">
            <div class="feed-header">
                <a class="feed-author-name" href="upload.php" style="color: #14FFFF;"><?php echo $image['username']; ?></a>
            </div>
             <div class="feed-image">
                <a href="comments.php?imageid=<?php echo $image['id']; ?>"><img src="<?php echo '../img/' . $image['image'] ?>" width="450px"  alt=""></a>
                <br/><a href="<?php echo 'plus_like.php?id='. $image['id'] ?>"><img src="../img/alpha/like.png"></a>     
                <a href="<?php echo 'unlike.php?id='. $image['id'] ?>"><img src="../img/alpha/unlike.png"></a><br/><p  style="color:#47FF13;">[<?php echo $image['like_count']; ?>]</p>
            </div>
        </div>
    </div> 
    <?php endforeach; ?>
    <?php
     for ($page=1;$page<=$number_of_pages;$page++) {
         if($page === 1)
        echo '<a href="gallery.php?page=' . $page . '">' . '<img src="../img/alpha/prev.png">' . '</a> ';
        elseif ($page > 1)
        echo '<a href="gallery.php?page=' . $page . '">' . '<img src="../img/alpha/next.png">' . '</a> ';
      }
      ?>	
<?php include_once '../footer.php';?>
</body>
</html>