<?php include "includes/admin_header.php" ?>

 <?php include "includes/admin_navigation.php" ?>
    <!-- Navigation -->
<?php

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
      
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];




}
}

?>





    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    This is Profile Page
                    <small>Cool</small>
                </h1>

               
                <h1><?php echo $username; ?></h1>
                <h1><?php echo $user_firstname." ".$user_lastname ?></h1>
                <h1><?php echo $user_role; ?></h1>






            



            </div>

            <!-- Blog Sidebar Widgets Column -->


        </div>
        <!-- /.row -->

        <hr>



<?php include "includes/admin_footer.php" ?>
