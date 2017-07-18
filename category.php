<?php
include "includes/db.php";
include "includes/header.php";

?>

    <!-- Navigation -->
<?php
include "includes/navigation.php"
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
<?php


?>

                <h1 class="page-header">
                    Category Filter
                    
                </h1>

<?php 

if(isset($_GET['category'])){
    $post_category_id = $_GET['category'];
    $page = $_GET['page'];
    $per_page = 10;
$query = "SELECT * FROM Posts WHERE post_category_id = $post_category_id ORDER BY post_id DESC LIMIT $page, $per_page";
$get_posts = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($get_posts)) {
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];

?>


            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title?></a>
            </h2>
            <p class="lead">
                by <a href="category.php"><?php echo $post_author?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
           
            <?php if($post_image == "") { } else { ?>
            <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive maxheight" src="images/<?php echo $post_image; ?>" alt=""></a>
          
            <?php } ?>
           
            <p><?php echo $post_content?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

               

<?php } } ?>   



            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>


                
    <!-- // pagination =======================================================      -->

        <ul class="pager">

        <?php 
                if(isset($_GET['category'])){
                $post_category_id = $_GET['category'];
                $page = $_GET['page'];
                $per_page = 10;
                $query = "SELECT * FROM Posts WHERE post_category_id = $post_category_id";

                $find_count = mysqli_query($connect, $query);
                $count = mysqli_num_rows($find_count);
                $pages = ceil($count / $per_page);

}

            // if (isset($_GET['sort'])) {
            //     $sort_by = $_GET['sort'];
            //     echo "<li><a href='index.php?sort={$sort_by}&page=1'>First</a></li>";  
            // } else {
            //     echo "<li><a href='index.php?page=1'>First</a></li>";  
            // }
     
    

            // if(isset($_GET['page'])){
            //     $i = $_GET['page'];
            //     $i = $i-1;
            //     if($i <=0){
            //         $i = 1;
            //     }
            // echo "<li><a href='index.php?sort={$sort_by}&page={$i}'>Previous</a></li>";
            // } else {
            // echo "<li><a href='index.php?sort={$sort_by}&page=1'>Previous</a></li>";
            // }

            if(isset($_GET['page'])){
            $i = $_GET['page'];
            $cat_id = $_GET['category'];

            for ($i=0; $i <= $pages; $i++) { 

                if($i == $page) {
                    echo "<li><a class='active_link' href='category.php?category={$cat_id}&page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='category.php?category={$cat_id}&page={$i}'>{$i}</a></li>";
                    }
                }
            } 






            // if(isset($_GET['page'])){
            //     $i = $_GET['page'];
             
            //     $i = $i+1;
            //     if($i >= $count){
            //         $i = $count;
            //     }
            //     echo "<li><a href='index.php?sort={$sort_by}&page={$i}'>Next</a></li>";
            // } else {
            //     echo "<li><a href='index.php?sort={$sort_by}&page=2'>Next</a></li>";
            // }


            // if (isset($_GET['sort'])) {
            //     $sort_by = $_GET['sort'];
            //     echo "<li><a href='index.php?sort={$sort_by}&page={$count}'>Last</a></li>";  
            // } else {
            //     echo "<li><a href='index.php?page={$count}'>Last</a></li>";  
            // }
            
        ?>

        </ul>

<?php
include "includes/footer.php"
?>
