<?php
include 'db.php';
$auth = 0;
    $db = mysqli_connect('localhost', 'root', '', 'camagru');

    if (!$db){
        die("connection failed: ".mysqli_connect_error());
    }
?>