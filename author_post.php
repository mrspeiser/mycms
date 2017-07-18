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

<h1 class="page-header">
    Page Heading
    <small>Secondary Text</small>
</h1>

<?php 

if(isset($_GET['p_id'])) {
$the_post_id = escape($_GET['p_id']);
$the_post_author = escape($_GET['author']);

}

$query = "SELECT * FROM Posts WHERE post_author = '{$the_post_author}' ";
$select_all_posts = mysqli_query($connect, $query);

    while($row = 
    mysqli_fetch_assoc($select_all_posts)) 

    {
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];     

?>


<!-- First Blog Post -->
<h2>
<a href="#"><?php echo $post_title?></a>
</h2>
<p class="lead">All Posts by <strong><?php echo $post_author?></strong></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
<hr>
<img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
<hr>
<p><?php echo $post_content?></p>


<hr>

<?php } ?>

            <!-- Blog Comments -->

<?php 
if(isset($_POST['create_comment'])) {

    $the_post_id = escape($_GET['p_id']);
    $comment_author = escape($_POST['comment_author']);
    $comment_email = escape($_POST['comment_email']);
    $comment_content = escape($_POST['comment_content']);


    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

    $query = "INSERT INTO comments (comment_post_id,comment_author,comment_email, comment_content, comment_status, comment_date)";

    $query .= "VALUES ($the_post_id,'{$comment_author}','{$comment_email}', '{$comment_content}', 'unapproved',now())";

    $create_comment_query = mysqli_query($connect, $query);
    if(!$create_comment_query){
        die('Query Failed' . mysqli_error($connect)); 
    }


    $query = "UPDATE Posts SET post_comment_count = post_comment_count + 1 ";
    $query .= "WHERE post_id = $the_post_id ";
    
    $update_comment_count = mysqli_query($connect,$query);
} else {
    echo "<script>alert('Fields cannot be empty')</script>";
}

}



?>


</div>




</div>

<!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php" ?>

</div>
<!-- /.row -->

<hr>

<?php
include "includes/footer.php"
?>
