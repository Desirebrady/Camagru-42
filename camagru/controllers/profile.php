<?php
session_start();
include     '../controllers/connect.php';
include    'logged_on.php';

$user = $_SESSION['username'];
if (isset($_POST['save'])) {

    $rename = $_POST['username'];
    $email = $_POST['email'];
    $rcom = $_POST['rcom'];

    $query1 = "UPDATE users set username='$rename', email='$email', rcom='$rcom' WHERE username='$user'";
    $results1 = mysqli_query($db, $query1);
    $query2 = "UPDATE images set username='$rename' WHERE username='$user'";
    $results2 = mysqli_query($db, $query2);
    $query2 = "UPDATE tbl_comment set comment_sender_name='$rename' WHERE username='$user'";
    $results3 = mysqli_query($db, $query3);
    header('location: ../admin/login.php');
    exit(0);
}
$myinfo = mysqli_query($db, "SELECT * FROM users where username='$user'");
while ($row = mysqli_fetch_array($myinfo)) {
    $gusername = $row['username'];
    $gemail = $row['email'];
    $grcom = $row['rcom'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/my_style.css">
    <link rel="stylesheet" href="../css/admin.css">

</head>

<body>
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
                        Welcome Guest
                    <?php endif ?>
                    <?php if (!$_SESSION['verified']) : ?>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../admin/login.php?logout='0'">Logout</a></li>
                    <?php else : ?>
                        <li><a href="webcam.php">Back</a></li>
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


        <div class="content-w3ls" style="font-size: 20px; margin-top: 10%	">
            <div class="content-bottom">
                <form method="POST">
                    <div class="contact-form mar-top30">
                        <label> <span>username</span>
                            <input type="text" name="username" class="input_text" value="<?php echo $gusername ?>">
                        </label>
                        <label> <span>email</span>
                            <input type="text" name="email" class="input_text" value="<?php echo $gemail ?>">
                        </label>

                        <label> <span>Recieve comment notifications? </span>
                            <?php if ($grcom == 0) { ?>

                                <select name="rcom" class="btn btn-success" style="margin-left: 50px; background-color: #03A9F4; border-color: #03A9F4">
                                    <option value="0">False</option>
                                    <option value="1">True</option>
                                </select>
                            <?php } else { ?>
                                <select name="rcom" style="margin-left: 57px;" class="btn btn-success" style="margin-left: 50px; background-color: #03A9F4; border-color: #03A9F4">
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                        </label>
                    <?php } ?>

                    </div>
                    <button type="submit" name="save" class="btn btn-success" style="background-color: #03A9F4; border-color: #03A9F4">SAVE</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>