<?php
session_start();
require 'db.php';
include     '../controllers/connect.php';

if(isset($_GET['imageid']) && $_GET['imageid'] !== ''){
    $image_id = $_GET['imageid'];

    $results = mysqli_query($db, "SELECT * FROM images");
    $images = mysqli_fetch_all($results, MYSQLI_ASSOC);
    $result = mysqli_query($db, "SELECT * FROM images");
}
?>
<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/comments.css">
    <link rel="stylesheet" type="text/css" href="../css/my_style.css">
    <script src="../js/4com.js"></script>
    <script src="../js/comment.js"></script>

</head>
<body>
<?php include_once '../header.php';?>
<br/>
<br/>
<br/>
<br/>
<div class="feeds">
        <div class="feed">
           
             <div class="feed-image">
             <?php
             while ($row = mysqli_fetch_array($result)) {
                 if ($image_id === $row['id']){
               echo "<div id='img_div'>";
                   echo "<img style='width: 450px' src='../img//".$row['image']."' >";
               echo "</div>";
             }  
         }?>
         </div>
            
            <div class="feed-footer">
                <form method="POST" id="comment_form">
                    <input type="hidden" name="comment_name" id="comment_name" value="<?php echo $_SESSION['username'] ?>"/>
                    <div class="form-group">
                    <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5" style="height:29px; width :396px;"></textarea>
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="comment_id" id="comment_id" value="0" />
                    <input type="hidden" name="image_id" id="image_id" value="<?php echo $image_id ?>" />
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                    </div>
                </form>
            </div>
        </div>

</div>
   

<div class="container">
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
</div>  </div>
<?php include_once '../footer.php';?> 
    </body>
</html>   


<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"add_comment.php?imageid=<?php echo $image_id?>",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php?imageid=<?php echo $image_id?>",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });
 
});
</script>