<?php

//set random name for the image, used time() for uniqueness


if (isset($_POST['Take_photo']))
{   
    $image = $_FILES['webcam']['tmp_name'];
    $username = $_SESSION['username'];
    $image_text = "test";

    $sql = "INSERT INTO images (username, image, image_text) VALUES ('$username','$image', '$image_text')";
    mysqli_query($db, $sql);
}

$filename =  time() . '.jpg';
$filepath = 'saved_images/';

move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);

echo $filepath.$filename;
?>
