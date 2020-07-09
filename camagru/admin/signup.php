<?php
include        '../controllers/authController.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Register</title>
</head>

<body>
    <?php if (count($errors) != 0) { ?>
        <div class="alert alert-danger" role="alert" style="text-align: center;">
            <?php include('../controllers/messages.php'); ?>
        </div>
    <?php } ?>
    <div class="content-w3ls" style="margin-top:5%;">
        <div class="content-bottom">
            <h2 style="color: white;">Register In Here</h2>
            <form action="signup.php" method="post">
                <div class="field-group">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <div class="wthree-field">
                        <input name="username" id="text1" type="text" placeholder="Username.." required>
                    </div>
                </div>
                <div class="field-group">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <div class="wthree-field">
                        <input name="email" id="text1" type="text" placeholder="Email.." required>
                    </div>
                </div>
                <div class="field-group">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <div class="wthree-field">
                        <input name="password" id="myInput" type="password" placeholder="Password..">
                    </div>
                </div>
                <div class="field-group">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <div class="wthree-field">
                        <input name="passwordConf" id="myInput" type="password" placeholder="Confirm Password..">
                    </div>
                </div>
                <div style="margin-top: 5%;">
                    <input id="saveForm" name="signup-btn" type="submit" class="btn btn-success" style="background-color: #03A9F4; border-color: #03A9F4;font-size: large;" value="Sign up" />
                </div>
                <div class="row">
                    <div style="margin-top: 5%;" class="col">
                        <a href="login.php" style="margin-left: 15px;">Have an account ?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>