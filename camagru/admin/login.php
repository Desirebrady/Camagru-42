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


    <title>Login</title>

</head>

<body>

    <div class="content-w3ls" style="margin-top: 10%;">
        <div class="content-bottom">
            <h2 style="color: white">Sign In</h2>
            <form method="post">
                <div class="field-group">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <div class="wthree-field">
                        <input name="username" id="text1" type="text" placeholder="Username" required>
                    </div>
                </div>
                <div class="field-group">
                    <span class="fa fa-lock" aria-hidden="true"></span>
                    <div class="wthree-field">
                        <input name="password" id="myInput" type="password" placeholder="Password">
                    </div>
                </div>
                <div style="margin-top: 5%;">
                    <input id="saveForm" name="login-btn" class="btn btn-success" style="background-color: #03A9F4; border-color: #03A9F4;font-size: large;" type="submit" value="sign in" />
                </div>
                <div class="row">
                    <div style="margin-top: 5%;" class="col">
                        <a href="signup.php" style="margin-left: 15px;">No account?</a>
                        <a href="enter_email.php" style="margin-left: 30px;">Forgot password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>