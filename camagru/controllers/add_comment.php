<?php
require 'db.php';
//add_comment.php

$connect = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

$error = '';
$comment_name = '';
$comment_content = '';


 if(isset($_GET['imageid']) && $_GET['imageid'] !== ''){
$image_id = $_GET['imageid'];
$sql = "SELECT username FROM images WHERE id ='$image_id' LIMIT 1";
$name  = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($name))
        {
            $username = trim($row['username']);
        }
$sql = "SELECT email FROM users WHERE username ='$username' LIMIT 1";
$results = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($results))
        {
            $email = trim($row['email']);
        }
        
        $headers = "From: info@camagru.com";
        // Send the message
        if (mail($email,"Comment recieved","fuck you",$headers)) {
            echo "Message Sent";
        } else {
            echo "Message Error";
        }
if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}
$commentl = strlen($comment_content);
if ($commentl > 100){
    $error .= '<p class="text-danger">Comment is too long</p>';
}
if($error == '')
{
 $query = "
 INSERT INTO tbl_comment 
 (parent_comment_id, comment, comment_sender_name, image_id) 
 VALUES (:parent_comment_id, :comment, :comment_sender_name, :image_id)
 ";

 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'    => $comment_content,
   ':comment_sender_name' => $comment_name,
   ':image_id'    => $image_id
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);
$sql = "INSERT INTO tbl_comment(image_id) VALUES ( where$image_id)";

$result = mysqli_query($conn, $sql);
 }

?>