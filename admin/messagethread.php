<?php include "includes/admin_header.php" ?>


<!-- start show message modal -->
<?php 
$username = $_SESSION['username'];


?>
<?php

$sender = $_GET['sender'];
$recipient = $_GET['recipient'];
$tid1 = $sender . $recipient;
$tid2 = $recipient . $sender;

$query = "SELECT * FROM messages WHERE recipient = '{$username}' OR sender = '{$username}' OR thread_id = '{$tid1}' OR thread_id = '{$tid2}' ORDER BY id DESC ";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($result)){

$sender = $row['sender'];
$recipient = $row['recipient'];
$message = $row['message'];
$date = $row['date'];
$thread_id = $row['thread_id'];
}
?>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <form action="" method="POST">
        <div>
            <textarea style="margin-bottom: 10px;" class="form-control" name="message"></textarea>
            <input type="text" name="recipient" value="<?php echo $sender; ?>" style="display: none;" >
            <input type="text" name="thread_id" value="<?php echo $thread_id; ?>" style="display: none;" >
          </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Send</button>
        </form>
      </div>

<?php

$sender = $_GET['sender'];
$recipient = $_GET['recipient'];
$tid1 = $sender . $recipient;
$tid2 = $recipient . $sender;

$query = "SELECT * FROM messages WHERE recipient = '{$username}' OR sender = '{$username}' OR thread_id = '{$tid1}' OR thread_id = '{$tid2}' ORDER BY id DESC ";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($result)){

$sender = $row['sender'];
$recipient = $row['recipient'];
$message = $row['message'];
$date = $row['date'];
$thread_id = $row['thread_id'];

?>


      <div class="modal-body">

      <div class="well">
        <h5>From: <?php echo $sender; ?></h5> 
        <p><?php echo $message; ?></p> 
        <!-- <?php echo $recipient; ?> -->
        <?php echo $date; ?>
        
      </div>
        
      </div>

<?php } ?>    

      <div class="modal-footer">
      


      </div>
   
<!-- end show message modal