<?php 
$auth = 0;
session_start();
$errors = [];
$user_id = "";
$db = mysqli_connect('localhost', 'root', '', 'camagru');

// ENTER A NEW PASSWORD
if (isset($_POST['new_password']))
{
    echo "bleh\n";
    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);
    
    // Grab to token that came from the email link
    $token = $_POST['token'];
    echo $token . "\n";
    if (empty($new_pass) || empty($new_pass_c))
    {
        array_push($errors, "Password is required");
    }
    if ($new_pass !== $new_pass_c)
    {
        array_push($errors, "Password do not match");
    }
    if (count($errors) == 0)
    {
        echo "bleh1\n";
        // select email address of user from the password_reset table
        $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
        $results = mysqli_query($db, $sql);
        while($row = mysqli_fetch_array($results))
        {
            $email = trim($row['email']);
            echo $email;
            
            if ($email)
            {
                echo "bleh2";
                $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
                $results = mysqli_query($db, $sql);
                //header('location: ../index.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset</title>
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<form class="login-form" action="new_password.php" method="post">
		<h2 class="form-title">New password</h2>
		<!-- form validation messages -->
		<?php include('../controllers/messages.php'); ?>
		<div class="form-group">
			<label>New password</label>
			<input type="password" name="new_pass">
			<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c">
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>