<div class="col-md-4 ">


                <!-- Blog Search Well -->
                <div  class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="POST">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" name="submit" class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form><!-- searchform -->
                    <!-- /.input-group -->
                </div>

                <!-- Login -->


<div class="well">
<?php if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    echo "Hi " .$username."!"; ?>
    <a href="admin/posts.php?source=add_post"><button class="btn btn-primary">Create a Post!</button></a>
<?php } else {

?>
    <h4>Login</h4>
    <form action="includes/login.php" method="POST">
    <div class="form-group">
        <input name="username" type="text" class="form-control" placeholder="Enter Username">
        
    </div>

    <div class="input-group">
        <input name="password" type="password" class="form-control" placeholder="Enter Password">
        <span class="input-group-btn">
        <button class="btn btn-primary" name="login" type="submit">Submit</button>
        </span>
        
    </div>

    

    </form>
    <?php } ?><!-- searchform -->
    <!-- /.input-group -->
</div>



                <!-- Blog Categories Well -->
<div class="well">




<?php if(isset($_SESSION['username'])){  ?>

<h4>My Categories <a href="all_categories.php">All Categories<span><i class="glyphicon glyphicon-chevron-right"></i></span></a></h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">


<?php
$username = $_SESSION['username'];
$query = "SELECT * FROM favorite_cat WHERE username = '{$username}' ";
// $query = "SELECT * FROM categories WHERE cat_title IN (SELECT * FROM favorite_cat WHERE username = '{$username}')";
$select_categories_sidebar = mysqli_query($connect, $query);
confirm($select_categories_sidebar);

while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
$cat_title = $row['cat_title'];
$cat_id = $row['cat_id'];


echo "<li class='col-lg-6'><a href='category.php?category=$cat_id&page=0'>{$cat_title}</a></li>";
}
?>

                
            </ul>
        </div>
    </div>
    <?php } else { ?> 
<?php

$query = "SELECT * FROM categories";
$select_categories_sidebar = mysqli_query($connect, $query);

?>
<h4>Categories <a href="all_categories.php">All Categories --></a></h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">


<?php
while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
$cat_title = $row['cat_title'];
$cat_id = $row['id'];
echo "<li class='col-lg-6' ><a href='category.php?category=$cat_id&page=0'>{$cat_title}</a></li>";
}
?>

                
            </ul>
        </div>
    </div>
    <?php } ?>
                    <!-- /.row -->

                <!-- Side Widget Well -->


</div>
<?php include "widget.php" ?>
</div>