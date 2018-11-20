<?php
    //  $msg = "";
    //  $results = mysqli_query($db, "SELECT * FROM images");
    //  $images = mysqli_fetch_all($results, MYSQLI_ASSOC);


    $result = mysqli_query($db, "SELECT * FROM images order by id desc");
?>