<?php include "includes/admin_header.php" ?>

    <div id="wrapper">


        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>
<hr>

<?php 

if(isset($_POST['submit'])){
  $sender = $_SESSION['username'];
  $message = $_POST['message'];
  $recipient = $_POST['recipient'];
  $date = date(DATE_RFC822);
  $thread_id = $sender . $recipient;

  $query = "INSERT INTO messages(sender, message, recipient, date, thread_id) VALUES('{$sender}', '{$message}', '{$recipient}', now(), '{$thread_id}') ";

  $insert_message = mysqli_query($connect, $query);
  confirm($insert_message);
  echo "message success";
}
?>

<div class="container">
  <div class="row">
      <div class="col-sm-10"><h1>Messages</h1></div>
      
    </div>

<!-- start show users modal -->

<div class="modal fade" id="show_users_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <div class="well">
        <h4>Contacts:</h4>
<?php 
if(isset($_SESSION['username'])){

$username = $_SESSION['username'];
$query = "SELECT * FROM favorite_users WHERE username = '{$username}' ORDER BY id DESC";
$recipients = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($recipients)){
$row_id = $row['id'];
$row_username = $row['username'];
$favorited_user_id = $row['favorited_user_id'];
$favorited_username = $row['favorited_user'];

?> 


<div class="recipient_row">
<strong><span id="recipient_name"><?php echo $favorited_username; ?></span></strong>
<span class="add_recipient btn btn-default" style="margin-left: 10px;" value='<?php echo $favorited_username; ?>' >add</span>
</div>


<?php } } ?>


        </div>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>





<!-- end show users modal -->


    <div class="row">




      <div class="col-sm-12" style="background-color: white;">
          
          <ul class="nav nav-tabs" id="myTab">

            <li class="active"><a href="#messages" data-toggle="tab">Messages</a></li>
            <li><a href="#sent-messages" data-toggle="tab">Sent Message</a></li>
            <li><a href="#newmessage" data-toggle="tab">New Message</a></li>
          </ul>
              
          <div class="tab-content">
            <div class="tab-pane active" id="#home">   
            
            
             </div><!--/tab-pane-->



             <div class="tab-pane active" id="messages">
               <ul class="list-group">
                  <li class="list-group-item text-muted">Inbox</li>

<?php 
$username = $_SESSION['username'];
$query = "SELECT * FROM messages WHERE recipient = '{$username}' ORDER BY id DESC ";
$all_received_messages = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($all_received_messages)){

$sender = $row['sender'];
$recipient = $row['recipient'];
$message = $row['message'];
$date = $row['date'];
$thread_id = $row['thread_id'];


?>

   <li class="list-group-item text-right"><?php echo $date; ?><p style="margin-right: 75px;" class="pull-left">FROM: <?php echo $sender; ?> </p>
   <a href="messagethread.php?sender=<?php echo $sender; ?>&recipient=<?php echo $recipient; ?>" class="pull-left" data-toggle="modal" data-target="#myModal"><?php echo $message; ?></a></li>



      <!-- start show message modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">



      </div>
    </div>
  </div>

<!-- end show message modal -->
                  
<?php } ?>
            </ul> 
               
             </div>

             <!-- end messages pane -->


 <div class="tab-pane" id="sent-messages">
   <ul class="list-group">
      <li class="list-group-item text-muted">Sent</li>

<?php 
$username = $_SESSION['username'];
$query = "SELECT * FROM messages WHERE sender = '{$username}' ";
$all_sent_messages = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($all_sent_messages)){

$recipient = $row['recipient'];
$message = $row['message'];
$date = $row['date'];


?>


                  <li class="list-group-item text-right">
                  <p style="margin-right: 100px;" class="pull-left">Sent To: <?php echo $recipient; ?> </p>
                  <a href="#" class="pull-left" data-toggle="modal" data-target="#myModal"><?php echo $message; ?></a> <?php echo $date; ?>
                  </li>
                  
                  <?php } ?>
                  
                </ul> 
               
             </div>

             <!--/tab-pane-->


             <div class="tab-pane" id="newmessage">
                
                
                 
                  <form style="margin-bottom: 10px;" class="form" action="##" method="post" id="registrationForm">
                      <h4 class="" id="myModalLabel">Send to: <a href="" id="show_users_modal" data-toggle="modal" data-target="#show_users_modal"><button class="btn btn-primary">show users</button></a> </h4>
                      <div class="" >
                        <label>Send To:</label>
                        <p id="" class="recipient_show" name="recipient"></p>
                        <input type="text" class="recipient_input" name="recipient" style="display: none;" ">
                      </div>
                      
                    
                      <label>Message:</label>
                      

                      <div>

                          <textarea rows="10" style="margin-bottom: 10px;" class="form-control" name="message"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="submit">Send</button>
                    
                   
                </form>

              </div>
               <!-- settings end -->
              </div>
              <!--/tab-content-->
          </div>
          <!--/col-9-->

          <!-- Modal -->


        </div>
        <!-- row -->
        

<?php include "includes/admin_footer.php" ?>