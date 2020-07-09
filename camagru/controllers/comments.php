<?php
session_start();
require 'db.php';
include '../controllers/connect.php';

if (isset($_GET['imageid']) && $_GET['imageid'] !== '') {
    $image_id = $_GET['imageid'];

    $results = mysqli_query($db, "SELECT * FROM images");
    $images = mysqli_fetch_all($results, MYSQLI_ASSOC);
    $result = mysqli_query($db, "SELECT * FROM images");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/comments.css">
    <link rel="stylesheet" type="text/css" href="../css/my_style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body>
    <header id="header">
        <div id="logo" class="pull-left">
            <h1><a href="#intro" class="scrollto">Camagru</a></h1>
        </div>
        <nav id="nav-menu-container">
            <ul class="nav-menu" style="color: #14FFFF; font-size: large">
                <?php if (!empty($_SESSION['username'])) : ?>
                    <?php echo $_SESSION['username']; ?>
                <?php else : ?>
                    Welcome Guest
                <?php endif ?>
                <?php if (!$_SESSION['verified']) : ?>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../admin/login.php?logout='0'">Logout</a></li>
                <?php else : ?>
                    <li class="menu-active"><a href="gallery.php">Back</a></li>
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
    <script>
        $(document).ready(function() {
            load_comment();
        });

        $(document).ready(function() {
            $('#comment_form').on('submit', function(event) {
                event.preventDefault();
                console.log("test");
                var form_data = $(this).serialize();
                jQuery.support.cors = true;
                $.ajax({
                    url: "add_comment.php?imageid=<?php echo $image_id ?>",
                    method: "POST",
                    data: form_data,
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            load_comment();
                        }
                    }
                })
            });

            function load_comment() {
                $.ajax({
                    url: "fetch_comment.php?imageid=<?php echo $image_id ?>",
                    method: "GET",
                    success: function(data) {
                        $('#display_comment').html(data);
                    }
                })
            }
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="feeds" style="margin-top: 10%;">
                    <div class="feed">
                        <div class="feed-image">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                if ($image_id === $row['id']) {
                                    echo "<div id='img_div'>";
                                    echo "<img style='width: 450px' src='../img//" . $row['image'] . "' >";
                                    echo "</div>";
                                }
                            } ?>
                        </div>
                        <div class="feed-footer">
                            <form method="POST" id="comment_form">
                                <input type="hidden" name="comment_name" id="comment_name" value="<?php echo $_SESSION['username'] ?>" />
                                <div class="form-group">
                                    <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5" style="height:29px; width :396px;"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="comment_id" id="comment_id" value="0" />
                                    <input type="hidden" name="image_id" id="image_id" value="<?php echo $image_id ?>" />
                                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="container" style="width: 50%;">
                    <span id="comment_message"></span>
                    <br />
                    <div id="display_comment"></div>
                </div>
                <script>
                    load_comment();

                    function load_comment() {
                        $.ajax({
                            url: "fetch_comment.php?imageid=<?php echo $image_id ?>",
                            method: "GET",
                            success: function(data) {
                                $('#display_comment').html(data);
                            }
                        })
                    }
                </script>
            </div>
        </div>
    </div>
    <?php include_once '../footer.php'; ?>
    </div>
</body>

</html>