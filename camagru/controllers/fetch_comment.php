<?php

//fetch_comment.php

$connect = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_GET['imageid']) && $_GET['imageid'] !== '') {
    $image_id = $_GET['imageid'];

    $query = "SELECT * FROM tbl_comment WHERE parent_comment_id = '0' ORDER BY comment_id DESC";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();
    $output = '';
    foreach ($result as $row) {
        if ($image_id === $row['image_id']) {
            $output .= '
        <div class="panel panel-default">
            <div class="panel-heading">
                By <b>' . $row["comment_sender_name"] . '</b> on <i>' . $row["date"] . '</i> 
            </div>
            <div class="panel-body">
                ' . $row["comment"] . '
            </div>
        </div>';
            $output .= get_reply_comment($connect, $row["comment_id"]);
        }
    }
    echo $output;
}


function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
    $query = "
 SELECT * FROM tbl_comment WHERE parent_comment_id = '" . $parent_id . "'
 ";
    $output = '';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    if ($parent_id == 0) {
        $marginleft = 0;
    } else {
        $marginleft = $marginleft + 48;
    }
    if ($count > 0) {
        foreach ($result as $row) {
            $output .= '
                <div class="panel panel-default" style="margin-left:' . $marginleft . 'px">
                    <div class="panel-heading">By <b>' . $row["comment_sender_name"] . '</b> on <i>' . $row["date"] . '</i></div>
                    <div class="panel-body">' . $row["comment"] . '</div>
                </div>';
            $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
        }
    }
    return $output;
}
