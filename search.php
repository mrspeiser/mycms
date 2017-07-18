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
if(isset($_GET['page'])){
                $per_page = 5;
                $page = escape($_GET['page']);
                } else {
                    $page = "";
                }
                if($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
$per_page = 5;
$query = "SELECT * FROM Posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
?>


            <?php 

          
            if(isset($_POST['submit'])){

            $search = escape($_POST['search']);

            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
            $search_query = mysqli_query($connect, $query);

            if(!$search_query){
                die("query failed". mysqli_error($connect));
                }

            $count = mysqli_num_rows($search_query);
                if($count == 0){
                    echo "<h1> No Results</h1>";
                } else {

    while($row = mysqli_fetch_assoc($select_all_posts)) 

    {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        // $post_content = substr($row['post_content'],0,100);  
        $post_status = $row['post_status'];
        $post_view_count = $row['post_views_count'];

        if($post_status == 'published') {    

?>



<?php 
if(isset($_GET['star_post'])){
    $user_username = escape($_SESSION['username']);
    $the_post_id = escape($_GET['star_post']);
    $post_title = escape($_GET['title']);
    $post_author = $_GET['author'];
    $favorite_post_query = "INSERT INTO favorite_posts(username, post_id, post_title, post_author, viewed) VALUES('{$user_username}', '{$the_post_id}', '{$post_title}', '{$post_author}', 'no')";
    $insert_favorite = mysqli_query($connect, $favorite_post_query);
    confirm($insert_favorite);
    header("Location: post.php?p_id=$the_post_id");
    
}

if(isset($_GET['unstar_post'])){
    $user_username = escape($_SESSION['username']);
    $the_post_id = escape($_GET['unstar_post']);
    $post_title = escape($_GET['title']);
    $removestarred = "DELETE FROM favorite_posts WHERE post_id = {$the_post_id} AND username = '{$user_username}' ";
$remove_starred_query = mysqli_query($connect, $removestarred);
header("Location: post.php?p_id=$the_post_id");
    
}

?>


            <!-- First Blog Post -->
            
            <h2>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title?></a>
            </h2>
            <p class="lead">
            by <a href="profile.php?profile=<?php echo $post_author?>"><?php echo $post_author?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
            <p>View Count: <?php echo $post_view_count;?></p>
           
            <?php if($post_image == "") { } else { ?>
            <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive maxheight" src="images/<?php echo $post_image; ?>" alt=""></a>
          
            <?php } ?>
            <p><?php echo $post_content?></p>
            <div>


            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <?php 
            $numoffavoritesquery = "SELECT * FROM favorite_posts WHERE post_id = $post_id ";
            $numoffavorites = mysqli_query($connect, $numoffavoritesquery);
            $favcount = mysqli_num_rows($numoffavorites);

            ?>

            <?php if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            $query3 = "SELECT * FROM favorite_posts WHERE username = '{$username}' AND post_id = {$post_id}";
            $select_post_stars_query = mysqli_query($connect, $query3);
            $num_of_stars = mysqli_num_rows($select_post_stars_query);


            if(!$username){ } else {
            if($num_of_stars >= 1){ ?>

                <small><a href="post.php?unstar_post=<?php echo $post_id; ?>&title=<?php echo $post_title;?>" class="btn btn-warning  margin-left"><?php echo $favcount; ?> <span class="glyphicon glyphicon-star"></span> Unstar</a></small>

            <?php } else { ?>

                <small><a href="post.php?star_post=<?php echo $post_id; ?>&title=<?php echo $post_title; ?>&author=<?php echo $post_author; ?>" class="btn btn-info btn margin-left"><?php echo $favcount; ?> <span class="glyphicon glyphicon-star-empty"></span> Star</a></small>
            <?php } } } else { echo $favcount; ?> <span class="glyphicon glyphicon-star "></span>
            <?php }?>

        

            </div>

            <hr>

                <?php } } ?>

            



            </div>

            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
        <!-- // pagination ======================================================= -->
        <?php 

                $find_count = mysqli_query($connect, $select_post_query_count);
                $count = mysqli_num_rows($find_count);
                $count = ceil($count / $per_page);
    // pagination =======================================================     
?>
        <ul class="pager">

        <?php 
            if (isset($_GET['sort'])) {
                $sort_by = $_GET['sort'];
                echo "<li><a href='index.php?sort={$sort_by}&page=1'>First</a></li>";  
            } else {
                echo "<li><a href='index.php?page=1'>First</a></li>";  
            }
     
     



            if(isset($_GET['page'])){
                $i = $_GET['page'];
                $i = $i-1;
                if($i <=0){
                    $i = 1;
                }
            echo "<li><a href='index.php?sort={$sort_by}&page={$i}'>Previous</a></li>";
            } else {
            echo "<li><a href='index.php?sort={$sort_by}&page=1'>Previous</a></li>";
            }

            if(isset($_GET['page'])){
            $i = $_GET['page'];
            $max_links = 10 + $i;
            if($max_links >= $count){
                $max_links = $count;
            }
            $min_page = 1 + $i;

            for ($i=$min_page; $i <= $max_links; $i++) { 

                if($i == $page) {
                    echo "<li><a class='active_link' href='index.php?sort={$sort_by}&page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='index.php?sort={$sort_by}&page={$i}'>{$i}</a></li>";
                    }
                }
            } else {
            $i = 0;
            $max_links = 10 + $i;
            if($max_links >= $count){
                $max_links = $count;
            }
            $min_page = 1 + $i;
            for ($i=$min_page; $i <= $max_links; $i++) { 

                if($i == $page) {
                    echo "<li><a class='active_link' href='index.php?sort={$sort_by}&page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='index.php?sort={$sort_by}&page={$i}'>{$i}</a></li>";
                    }
                }
            }






            if(isset($_GET['page'])){
                $i = $_GET['page'];
             
                $i = $i+1;
                if($i >= $count){
                    $i = $count;
                }
                echo "<li><a href='index.php?sort={$sort_by}&page={$i}'>Next</a></li>";
            } else {
                echo "<li><a href='index.php?sort={$sort_by}&page=2'>Next</a></li>";
            }


            if (isset($_GET['sort'])) {
                $sort_by = $_GET['sort'];
                echo "<li><a href='index.php?sort={$sort_by}&page={$count}'>Last</a></li>";  
            } else {
                echo "<li><a href='index.php?page={$count}'>Last</a></li>";  
            }
            

        ?>

        </ul>
            



            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

<?php
include "includes/footer.php"
?>
