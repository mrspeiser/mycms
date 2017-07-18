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

        <div>
        <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Sort By:
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
              <li><a href="index.php?sort=1">All Most Recent</a></li>
              <li><a href="index.php?sort=2">My Categories</a></li>
              <li><a href="index.php?sort=3">Starred Users</a></li>
              <li><a href="index.php?sort=4">Most Views</a></li>
              <li><a href="index.php?sort=5">Most Stars</a></li>
              <li><a href="index.php?sort=6">Random</a></li>
              
            </ul>
        <a href="index.php?sort=6"><button class="btn btn-default">Randomize</button></a>

        <button class="btn btn-default">Suggest Feature</button>
        <button class="btn btn-default">Report Bug</button>
            
            
      </div>

        
      </div>

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            
                
                
<div class="sitenews" style=" background-color: #101010;">
    <div class="newsbox">
    <h1>Check Here for Updates/Site News!</h1>
    <ul>
        <h3>In Process:</h3>
        <li>Sharing Options</li>
        <li>Mutually Starred Users Online</li>
        <li>Suggest Feature</li>
        <li>Report Bug</li>
        <li>Sort By Most Stars</li>
        
        
    </ul>
    
    
    <ul>
        <h3>To Add:</h3>
        <li>Ban User</li>
        <li>Full View Images On click</li>
        <li>Updated User Profile</li>
        <li></li>
        <li></li>
        
    </ul>
    </div>


</div>

                

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




if(isset($_GET['sort'])){
    $sort_by = escape($_GET['sort']);
    $username = $_SESSION['username'];
    $favorite_cats_query = "SELECT * FROM favorite_cat WHERE username = '{$username}'";
    $get_categories = mysqli_query($connect, $favorite_cats_query);
    while($row = mysqli_fetch_assoc($get_categories)){
        $cat_titles = $row['cat_title'];
        $cat_id = $row['cat_id'];
}
} else {
    $sort_by = '';
}

switch($sort_by){
    case '1';
    $query = "SELECT * FROM Posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
    echo "<h5>Sorted by Most Recent</h5>";
    break;

    case '2';
    $username = $_SESSION['username'];
    $query = "SELECT * FROM Posts WHERE post_category_id IN (SELECT cat_id FROM favorite_cat WHERE username = '{$username}') ORDER BY post_id DESC LIMIT $page_1, $per_page";
    echo "<h5>Sorted by my Favorite Categories</h5>";
    break;

    case '3';
    $username = $_SESSION['username'];
    $query = "SELECT * FROM Posts WHERE post_user IN (SELECT favorited_user FROM favorite_users WHERE username = '{$username}') ORDER BY post_id DESC LIMIT $page_1, $per_page";
    echo "<h5>Sorted by my Starred Users</h5>";
    break;

    case '4';
    $query = "SELECT * FROM Posts ORDER BY post_views_count DESC LIMIT $page_1, $per_page";
    echo "<h5>Most Views</h5>";
    break;

    case '5';
    ///need to figure out this query to sort by amount of stars on post.
    $numoffavoritesquery = "SELECT * FROM favorite_posts WHERE post_id = $post_id ";
    $numoffavorites = mysqli_query($connect, $numoffavoritesquery);
    $favcount = mysqli_num_rows($numoffavorites);

    $query = "SELECT * FROM Posts LIMIT $page_1, $per_page";
    echo "<h5>Most Stars</h5>";
    ///need to figure out this query to sort by amount of stars on post.
    break;

    case '6';
    $query = "SELECT * FROM Posts ORDER BY RAND() LIMIT $page_1, $per_page";
    echo "<h5>Random Posts!</h5>";
    break;

    default:
    $query = "SELECT * FROM Posts ORDER BY post_id DESC LIMIT $page_1, $per_page";


}

$select_all_posts = mysqli_query($connect, $query);
    if(!$select_all_posts){
        die('Query Failed' . mysqli_error($connect)); 
    }
    while($row = 
    mysqli_fetch_assoc($select_all_posts)) 

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

                <a href="post.php?unstar_post=<?php echo $post_id; ?>&title=<?php echo $post_title;?>" class="btn btn-warning  margin-left" style="margin: 0px;"><?php echo $favcount; ?> <span class="glyphicon glyphicon-star"></span> Unstar</a>

            <?php } else { ?>

                <a href="post.php?star_post=<?php echo $post_id; ?>&title=<?php echo $post_title; ?>&author=<?php echo $post_author; ?>" class="btn btn-info btn margin-left" style="margin: 0px;"><?php echo $favcount; ?> <span class="glyphicon glyphicon-star-empty"></span> Star</a>
            <?php } } } else { echo $favcount; ?> <span class="glyphicon glyphicon-star "></span>
            <?php }?>

            <a class="btn btn-success" href="#">Share Options<span class="glyphicon glyphicon-chevron-right"></span></a>

            </div>

            <hr>

                <?php } } ?>

            



            </div>

            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

       
        <!-- // pagination ======================================================= -->
        <?php 
                





$select_post_query_count = "SELECT * FROM Posts"; //


if(isset($_GET['sort'])){
    $sort_by = escape($_GET['sort']);
    $username = $_SESSION['username'];
    $favorite_cats_query = "SELECT * FROM favorite_cat WHERE username = '{$username}'";
    $get_categories = mysqli_query($connect, $favorite_cats_query);
    while($row = mysqli_fetch_assoc($get_categories)){
        $cat_titles = $row['cat_title'];
        $cat_id = $row['cat_id'];
}
} else {
    $sort_by = '';
}

switch($sort_by){
    case '1';
    $select_post_query_count = "SELECT * FROM Posts ORDER BY post_id DESC";
    echo "Sorted by Most Recent";
    break;

    case '2';
    $username = $_SESSION['username'];
    $select_post_query_count = "SELECT * FROM Posts WHERE post_category_id IN (SELECT cat_id FROM favorite_cat WHERE username = '{$username}') ORDER BY post_id DESC";
    echo "Sorted by my favorite categories";
    break;

    case '3';
    $username = $_SESSION['username'];
    $select_post_query_count = "SELECT * FROM Posts WHERE post_user IN (SELECT favorited_user FROM favorite_users WHERE username = '{$username}') ORDER BY post_id DESC";
    break;

    case '4';
    $select_post_query_count = "SELECT * FROM Posts ORDER BY post_id DESC";
    echo "Random Posts!";
    break;

    default:
    $select_post_query_count = "SELECT * FROM Posts";


}



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

<?php
include "includes/footer.php"
?>
