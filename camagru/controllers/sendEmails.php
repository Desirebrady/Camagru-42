<?php
function sendVerificationEmail($userEmail, $token)
{
    $body = '
        Thank you for signing up on our site. Please click on the link below to verify your account:.
      "http://127.0.0.1:8080/camagru/admin/verification_mail.php?token=' . $token . '"';
    $headers = "From: info@camagru.com";
    // Send the message
    if (mail($userEmail,"Verify your email",$body,$headers)) {
        echo "Message Sent";
    } else {
        echo "Message Error";
    }
}

function sendResetMail($userEmail, $token)
{
    $body = '
        Please click on the link below to reset your password:.
      "http://127.0.0.1:8080/camagru/admin/new_password.php?token=' . $token . '"';
    $headers = "From: info@camagru.com";
    if (mail($userEmail,"Reset your password",$body,$headers)) {
        echo "Message Sent";
    } else {
        echo "Message Error";
    }
}

?>