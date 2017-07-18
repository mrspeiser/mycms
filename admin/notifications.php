<?php include "includes/admin_header.php" ?>

    <div id="wrapper">


<?php 


if(isset($_GET['removenotifications'])){
$username = $_SESSION['username'];

$setcommentedviewedtoyes = "UPDATE comments SET viewed = 'yes' WHERE viewed = 'no' AND post_author = '$username' ";
$send_query1 = mysqli_query($connect, $setcommentedviewedtoyes);

$set_favorited_post_viewed_toyes = "UPDATE favorite_posts SET viewed = 'yes' WHERE viewed = 'no' AND post_author = '$username' ";
$send_query2 = mysqli_query($connect, $set_favorited_post_viewed_toyes);


$set_starred_comment_viewed_toyes = "UPDATE starred_comments SET viewed = 'yes' WHERE viewed = 'no' AND comment_author = '$username' ";
$send_query3 = mysqli_query($connect, $set_starred_comment_viewed_toyes);


$set_favorite_you = "UPDATE favorite_users SET viewed = 'yes' WHERE viewed = 'no' AND favorited_user = '$username' ";
$send_query4 = mysqli_query($connect, $set_favorite_you);

// if(!$send_query){
// die("the query did not succeed " .mysqli_error($connect));

// } 
header("Location: notifications.php");
}
?> 

      <!-- <?php if($connect) echo "it is connected"; ?>   -->
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <h1 class="page-header">
                            Notifications

                            <small>Signed in As: <?php echo $_SESSION['username']; ?></small>   
                        </h1>
                       <a href="notifications.php?removenotifications"><button class="btn btn-primary">Mark As Read</button></a>
                    </div>

                </div>
                <!-- /.row -->
                <!-- /.row -->
                <!-- /.row -->
<?php
$username = $_SESSION['username'];
$query = "SELECT * FROM comments WHERE post_author = '{$username}' AND viewed = 'no' ";
$result1 = mysqli_query($connect, $query);
$commented_on_post_notifications = mysqli_num_rows($result);
echo "# New comments on your posts: ".$commented_on_post_notifications;
echo "</br>";


$query2 = "SELECT * FROM favorite_posts WHERE post_author = '{$username}' AND viewed = 'no' ";
$result2 = mysqli_query($connect, $query2);
$favorited_post_notifications = mysqli_num_rows($result2);
echo "# New Favorites on your posts: ".$favorited_post_notifications;
echo "</br>";

$query3 = "SELECT * FROM starred_comments WHERE comment_author = '{$username}' AND viewed = 'no' ";
$result3 = mysqli_query($connect, $query3);
$starred_comments_notifications = mysqli_num_rows($result3);
echo "# Starred Comments: ".$starred_comments_notifications;
echo "</br>";

$query4 = "SELECT * FROM favorite_users WHERE favorited_user = '{$username}' AND viewed = 'no' ";
$result4 = mysqli_query($connect, $query4);
$starred_user_notifications = mysqli_num_rows($result4);
echo "# Favorited Your Profile: ".$starred_user_notifications;
echo "</br>";


?>




            </div>
            <!-- /.container-fluid -->

        </div>
        

<?php include "includes/admin_footer.php" ?>