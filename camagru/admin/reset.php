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
    $token = $_GET['token'];
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
        echo $results;
        while($row = mysqli_fetch_array($results))
        {
            $email = $row['email'];
            echo $email;
            
            if ($email)
            {
                echo "bleh2";
                $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
                $results = mysqli_query($db, $sql);
                header('location: ../index.php');
            }
        }
    }
}
?>