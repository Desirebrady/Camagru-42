<?php
require 'db.php';
require_once 'sendEmails.php';
//add_comment.php
$conn = mysqli_connect("localhost", "root", "", "camagru");
$connect = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

$error = '';
$comment_name = '';
$comment_content = '';
$result = '';

if (isset($_GET['imageid']) && $_GET['imageid'] !== '') {
    $image_id = $_GET['imageid'];
    $sql = "SELECT username FROM images WHERE id ='$image_id' LIMIT 1";
    $name  = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($name))
        $username = trim($row['username']);

    $sql = "SELECT email FROM users WHERE username ='$username' LIMIT 1";
    $results = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($results)) {
        $email = trim($row['email']);
        // if ($row['recieveCommEmail'] == 1) {
        //     sendMail($email);
        // }
    }

    $comment_id = $_POST["comment_id"];
    if (empty($_POST["comment_name"]))
        $error .= '<p class="text-danger">Name is required</p>';
    else
        $comment_name = $_POST["comment_name"];
    if (empty($_POST["comment_content"])) {
        $error .= '<p class="text-danger">Comment is required</p>';
    } else {
        $comment_content = $_POST["comment_content"];
    }
    $commentl = strlen($comment_content);
    if ($commentl > 100) {
        $error .= '<p class="text-danger">Comment is too long</p>';
    }
    if ($error == '') {
        $query = "INSERT INTO tbl_comment (parent_comment_id, comment, comment_sender_name, image_id) 
        VALUES ('$comment_id', '$comment_content', '$comment_name', '$image_id')";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            $result = mysqli_error($conn);
        }

        $success = '<label class="text-success">Comment Added</label>';
    }
}

echo $result;
