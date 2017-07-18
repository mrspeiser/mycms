<?php
include "includes/db.php";
include "includes/header.php";

?>

    <!-- Navigation -->
<?php
include "includes/navigation.php"
?>

<?php 

if(isset($_GET['profile'])){
    $profilename = escape($_GET['profile']);
    $profilequery = "SELECT * FROM users WHERE username = '{$profilename}' ";
    $profile_query = mysqli_query($connect, $profilequery);

if(!$profile_query){
die("the query did not succeed " .mysqli_error($connect));
        }

       while($row = mysqli_fetch_array($profile_query)){

        
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_quote = $row['user_quote'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        $user_description = $row['user_description'];
    }
}

?>

<?php
if(isset($_GET['page'])){
                $per_page = 10;
                $page = escape($_GET['page']);
                } else {
                    $page = "";
                }
                if($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
$per_page = 10;

?>


<?php 
favorite_profile();
unfavorite_profile();
?>

<!-- fav={$cat_id}&title={$cat_title}' -->

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div style="margin-bottom: 33px;" class="dropdown">
        
      
            
            </div>

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <div class="" >
                    

<?php 

    if(isset($_GET['profile'])){
        $user_profile = $_GET['profile'];
        $total_fav_query = "SELECT * FROM favorite_users WHERE favorited_user = '{$user_profile}'"; 
        $select_total_fav_query = mysqli_query($connect, $total_fav_query);
        $total_num_fav = mysqli_num_rows($select_total_fav_query);
    }


    if(isset($_SESSION['username'])){
    $user_username = $_SESSION['username'];
    $query3 = "SELECT * FROM favorite_users WHERE username = '{$user_username}' AND favorited_user = '{$username}' ";
    $select_user_fav_query = mysqli_query($connect, $query3);
    $num_of_fav = mysqli_num_rows($select_user_fav_query);


    

if($num_of_fav >= 1){ ?>
                    <h2><?php echo $total_num_fav ?><a href="profile.php?unfavprofile=<?php echo $username; ?>" class="btn btn-warning btn-lg margin-left"><span class="glyphicon glyphicon-star "></span> Unstar</a></h2>


<?php } else { ?>
                    <h2><?php echo $total_num_fav ?><a href="profile.php?favprofile=<?php echo $username; ?>" class="btn btn-info btn-lg margin-left"><span class="glyphicon glyphicon-star-empty"></span> Star</a></h2>
<?php } } else{ echo "<h1>{$total_num_fav} <span class='glyphicon glyphicon-star'></span></h1>"; } ?>

<?php 
$get_status_query = "SELECT user_status FROM users WHERE username = '{$username}' ";
    $get_status = mysqli_query($connect, $get_status_query);
    if(!$get_status){
          die('Query Failed' .mysqli_error($connect));
      }
    while($row = mysqli_fetch_assoc($get_status)){
      $status = $row['user_status'];
    }
?>              <h1><?php echo $username; ?></h1>
                <h3>Status: <?php echo $status; ?> </h3>
                </div>
                <?php if($user_image == "") { } else { ?>
                 <div style="padding: 0px;" class="col-lg-8 col-md-6">
                    <img width='100%' height="300px" src='images/<?php echo $user_image;?>'>
                 </div>


                 <?php 


                    
                    $query5 = "SELECT * FROM users WHERE username IN(SELECT favorited_user FROM favorite_users WHERE username = '{$username}') "; 
                    $get_favorite_users = mysqli_query($connect, $query5);
                    confirm($get_favorite_users);

                    while($row = mysqli_fetch_assoc($get_favorite_users)){
                        $username = $row['username'];
                        $user_image = $row['user_image']; ?>

                    <div style="padding: 0px;">
                    <img style="padding: 0px;" height="100" width="100" class="col-md-2 col-sm-2 col-xs-4" src='images/<?php echo $user_image;?>'>
                 </div>
                        
                    <?php } ?>


                 
                 <?php } ?>
                <div style="margin-top: 550px;" class="">
                <h1>full name: <?php echo $user_firstname." ".$user_lastname ?></h1>
                <h2>type: <?php echo $user_role; ?></h1>
                <h2>Quote: <?php echo $user_quote; ?></h1>
                <h3>Description: <?php echo $user_description; ?></h3>
                </div>

<div style="margin-top: 70px;">
<h5>Recent Posts:</h5>
</div>


<?php 

$getpostsquery = "SELECT * FROM Posts WHERE post_user = '{$profilename}' ORDER BY post_id DESC LIMIT $page_1, $per_page";
$all_posts = mysqli_query($connect, $getpostsquery);
confirm($all_posts);

while($row = mysqli_fetch_array($all_posts)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];

    echo "<div>";
    echo "<p>$post_date</p>";
    echo "<a href='post.php?p_id=$post_id'><h4>$post_title</h4></a>";
    if($post_image == "") { } else { 
    echo "<img width='100' src='./images/$post_image'>";
    }
    echo "</div>";
    echo "</br>";
    echo "</br>";
}
?>



</div>
           <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php" ?>

</div>
        <!-- /.row -->

<hr>
        <ul class="pager">
<?php
        $getnumposts = "SELECT * FROM Posts WHERE post_user = '{$profilename}'";
        $all_posts = mysqli_query($connect, $getnumposts);
        $count = mysqli_num_rows($all_posts);
        $count = ceil($count / $per_page);
    
    for ($i=1; $i <= $count; $i++) { 
        if($i == $page) {
            echo "<li><a class='active_link' href='profile.php?profile={$profilename}&page={$i}'>{$i}</a></li>";
        } else {
            echo "<li><a href='profile.php?profile={$profilename}&page={$i}'>{$i}</a></li>";
        }
    }
?>

        </ul>


<?php
include "includes/footer.php"
?>
