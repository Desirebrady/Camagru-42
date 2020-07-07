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
    <link rel="stylesheet" type="text/css" href="../css/my_style.css">
    <link rel="stylesheet" type="text/css" href="../css/Edit.css">

    <link rel="stylesheet" type="text/css" href="../stylesheet/css/style.css?v=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <div class="wrap3">
            <div class="clearing"></div>
            <form method="POST">
                <div class="contact-form mar-top30">
                    <label> <span>username</span>
                        <input type="text" name="username" class="input_text" placeholder="<?php echo $gusername ?>">
                    </label>
                    <br>
                    <br>
                    <label> <span>email</span>
                        <input type="text" name="email" class="input_text" placeholder="<?php echo $gemail ?>">
                    </label>
                    <br>
                    <br>
                    <label> <span>Recieve comments notifications? </span>
                        <?php if ($grcom == 0) { ?>
                            <select name="rcom">
                                <option value="0">False</option>
                                <option value="1">True</option>
                            </select>
                        <?php } else { ?>
                            <select name="rcom">
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                    </label>
                <?php } ?>

                </div>
                <button type="submit" name="save">SAVE</button>
            </form>
        </div>
    </div>

</body>

</html>