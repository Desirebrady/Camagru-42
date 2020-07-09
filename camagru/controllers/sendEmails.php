<?php
function sendVerificationEmail($userEmail, $token)
{
    $body = '
        Thank you for signing up on our site.<br> 
        Please click on the link below to verify your account:.
      <a href="http://localhost/camagru/admin/verification_mail.php?token=' . $token . '"> Click me</a>';
    $headers = "From: info@camagru.com";
    // Send the message
    if (mail($userEmail, "Verify your email", $body, $headers)) {
        echo "Message Sent";
    } else {
        echo "Message Error";
    }
}

function sendResetMail($userEmail, $token)
{
    $body = '
        Please click on the link below to reset your password:.
      <a href="http://localhost/camagru/admin/new_password.php?token=' . $token . '"> Click me </a>';
    $headers = "From: info@camagru.com";
    if (mail($userEmail, "Reset your password", $body, $headers)) {
        echo "Message Sent";
    } else {
        echo "Message Error";
    }
}
function sendMail($userEmail)
{
    $body = 'You have a new comment';
    $headers = "From: info@camagru.com";
    if (mail($userEmail, "New comment", $body, $headers)) {
        echo "Message Sent";
    } else {
        echo "Message Error";
    }
}
