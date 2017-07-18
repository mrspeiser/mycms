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
<div class="col-md-8 moveup">

<?php if (isset($_GET['deletecomment'])) {
    $id = $_GET['deletecomment'];
    $the_post_id = $_GET['p_id'];
    $deletecomment = "DELETE FROM comments WHERE comment_id = $id";
    $deletecommentquery = mysqli_query($connect,$deletecomment);
    header("Location: post.php?p_id=$the_post_id");
    }


?>

<?php if (isset($_GET['deletereply'])) {
    $id = $_GET['deletereply'];
    $the_post_id = $_GET['p_id'];
    $deletereply = "DELETE FROM comment_replies WHERE id = $id";
    $deletereplyquery = mysqli_query($connect,$deletereply);
    header("Location: post.php?p_id=$the_post_id");
    }


?>

<?php

if(isset($_GET['starreply'])){
$id = escape($_GET['starreply']);
$the_post_id = escape($_GET['p_id']);
$comment_author = escape($_GET['comment_author']);
$username = escape($_SESSION['username']);
$stars_query2 = "UPDATE comment_replies SET star_count = star_count + 1 WHERE id = $id";
$star_query = mysqli_query($connect, $stars_query2);
confirm($star_query); 

$insertintostarred2 = "INSERT INTO starred_comments (username, comment_id, comment_author, comment_reply_id, viewed)";

$insertintostarred2 .= "VALUES('{$username}', 0, '{$comment_author}', '$id' , 'no')";
$insertintostarred_query = mysqli_query($connect, $insertintostarred2);
confirm($insertintostarred_query);
header("Location: post.php?p_id=$the_post_id");
}
?>

<?php
if(isset($_GET['unstarreply'])){
$id = $_GET['unstarreply'];
$the_post_id = $_GET['p_id'];
$comment_author = $_GET['comment_author'];
$username = $_SESSION['username'];
$stars_query3 = "UPDATE comment_replies SET star_count = star_count - 1 WHERE id = $id";
$star_query = mysqli_query($connect, $stars_query3);
confirm($star_query); 
$removestarred = "DELETE FROM starred_comments WHERE comment_reply_id = {$id}";
$remove_starred_query = mysqli_query($connect, $removestarred);
header("Location: post.php?p_id=$the_post_id");
}
?>



<?php
if(isset($_GET['star'])){
$comment_id = escape($_GET['star']);
$the_post_id = escape($_GET['p_id']);
$comment_author = escape($_GET['comment_author']);
$username = escape($_SESSION['username']);
$stars_query = "UPDATE comments SET comment_stars = comment_stars + 1 WHERE comment_id = $comment_id";
$star_query = mysqli_query($connect, $stars_query);
confirm($star_query); 

$insertintostarred = "INSERT INTO starred_comments (username, comment_id, comment_author, viewed)";

$insertintostarred .= "VALUES('{$username}', $comment_id, '{$comment_author}', 'no' )";
$insertintostarred_query = mysqli_query($connect, $insertintostarred);
confirm($insertintostarred_query);
header("Location: post.php?p_id=$the_post_id");
}
?>
<?php
if(isset($_GET['unstar'])){
$comment_id = escape($_GET['unstar']);
$the_post_id = escape($_GET['p_id']);
$comment_author = escape($_GET['comment_author']);
$username = escape($_SESSION['username']);
$stars_query = "UPDATE comments SET comment_stars = comment_stars - 1 WHERE comment_id = $comment_id";
$star_query = mysqli_query($connect, $stars_query);
confirm($star_query); 
$removestarred = "DELETE FROM starred_comments WHERE comment_id = {$comment_id}";
$remove_starred_query = mysqli_query($connect, $removestarred);
header("Location: post.php?p_id=$the_post_id");
}
?>

<?php 

if(isset($_GET['p_id'])) {
$the_post_id = escape($_GET['p_id']);

$view_query = "UPDATE Posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id";
$send_query = mysqli_query($connect, $view_query);

if(!$send_query){
    die("query failure");
}

$query = "SELECT * FROM Posts WHERE post_id = $the_post_id ";
$select_all_posts = mysqli_query($connect, $query);
    while($row = 
    mysqli_fetch_assoc($select_all_posts)) 

    {
        $post_title = $row['post_title'];
        $post_author = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_view_count = $row['post_views_count'];
          

?>


<h1 class="page-header">
<?php 
$numoffavoritesquery = "SELECT * FROM favorite_posts WHERE post_id = $the_post_id ";
$numoffavorites = mysqli_query($connect, $numoffavoritesquery);
$favcount = mysqli_num_rows($numoffavorites);


// <!-- ///////////////////////// -->
if(isset($_SESSION['username'])){
$username = $_SESSION['username'];
$query3 = "SELECT * FROM favorite_posts WHERE username = '{$username}' AND post_id = {$the_post_id}";
$select_post_stars_query = mysqli_query($connect, $query3);
$num_of_stars = mysqli_num_rows($select_post_stars_query);


if(!$username){ } else {
if($num_of_stars >= 1){ ?>

    <small><?php echo $favcount; ?><a href="post.php?unstar_post=<?php echo $the_post_id; ?>&title=<?php echo $post_title;?>" class="btn btn-warning btn-lg margin-left"><span class="glyphicon glyphicon-star "></span> Unstar</a></small>

<?php } else { ?>

    <small><?php echo $favcount; ?><a href="post.php?star_post=<?php echo $the_post_id; ?>&title=<?php echo $post_title; ?>&author=<?php echo $post_author; ?>" class="btn btn-info btn-lg margin-left"><span class="glyphicon glyphicon-star-empty"></span> Star</a></small>
<?php } } } else { echo $favcount; ?> <span class="glyphicon glyphicon-star "></span>
<?php }?>
<!-- ///////////////////////// -->
  
</h1>




<!-- First Blog Post -->
<h2>
<a href="#"><?php echo $post_title?></a>
</h2>
<p class="lead">
by <a href="profile.php?profile=<?php echo $post_author?>"><?php echo $post_author?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
<p><span class=""></span>View Count: <?php echo $post_view_count?></p>
<hr>
  <?php if($post_image == "") { } else { ?>
<img class="img-responsive post_image" src="images/<?php echo $post_image; ?>" alt="">
<hr>
<?php } ?>
<p><?php echo $post_content?></p>


<hr>
<?php } ?>

<?php  

} else {
    // header("Location: index.php");
} ?>

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



            <!-- Blog Comments -->
<!-- CREATE COMMENT PHP -->
<?php 
if(isset($_POST['create_comment'])) {
    if($comment_author = escape($_SESSION['username'])){
        $comment_author = escape($_SESSION['username']);
    } else {
        $comment_author = escape($_POST['comment_author']);
    }
    $the_post_id = escape($_GET['p_id']);

    $comment_email = 'subscribed';
    $comment_content = escape($_POST['comment_content']);

    if(!empty($comment_content)){
// !empty($comment_author) && !empty($comment_email) && 
    $insertquery = "INSERT INTO comments (comment_post_id, post_author, comment_author,comment_email, comment_content, comment_status, comment_date, viewed)";

    $insertquery .= "VALUES ($the_post_id, '{$post_author}', '{$comment_author}','{$comment_email}', '{$comment_content}','unapproved', now(), 'no')";

    $create_comment_query = mysqli_query($connect, $insertquery);
    if(!$create_comment_query){
        die('Query Failed' . mysqli_error($connect)); 
    }


    // $query = "UPDATE Posts SET post_comment_count = post_comment_count + 1 ";
    // $query .= "WHERE post_id = $the_post_id ";
    
    // $update_comment_count = mysqli_query($connect,$query);
} else {
    echo "<script>alert('Fields cannot be empty')</script>";
}

}
?>
<!-- FINISH CREATE COMMENT -->



<!-- CREATE REPLY PHP -->
<?php 
if(isset($_POST['create_reply'])) {
$original_comment_id = escape($_POST['original_comment_id']);
$original_comment_author = escape($_POST['original_comment_author']);
$reply_comment_author = escape($_SESSION['username']);
$comment_content = escape($_POST['comment_content']);

    if(!empty($comment_content)){

$insertquery = "INSERT INTO comment_replies (original_comment_id, original_comment_author, comment_author, comment_content)";

    $insertquery .= "VALUES ($original_comment_id, '{$original_comment_author}', '{$reply_comment_author}', '{$comment_content}')";

    $create_reply_query = mysqli_query($connect, $insertquery);
    if(!$create_reply_query){
        die('Query Failed' . mysqli_error($connect)); 
    }

} else {
    echo "<script>alert('Fields cannot be empty')</script>";
}

}
?>


<!-- FINISH CREATE REPLY -->



<!-- Comments Form -->

<?php if(isset($_SESSION['username'])){ ?>
<div class="well">
    <h4>Leave a Comment:</h4>
    <form action="" method="post" role="form">

        <div class="form-group">
            <label for="comment">Your Comment</label>
            <textarea class="form-control" rows="3" name="comment_content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
    </form>
</div>

<?php } else { ?>




 <?php } ?>
<!-- Posted Comments -->

<!-- STAR OR UNSTAR QUERY -->




<!-- END OF STAR OR UNSTAR QUERY -->

<?php
$query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
$query .= "AND comment_status = 'approved' ";
$query .= "ORDER BY comment_id DESC ";
$select_comment_query = mysqli_query($connect, $query);
if(!$select_comment_query){
    die ("query failed" .mysqli_error($connect));
}
while ($row = mysqli_fetch_assoc($select_comment_query)){
    $comment_id = $row['comment_id'];
    $comment_date = $row['comment_date'];
    $comment_content = $row['comment_content'];
    $comment_author = $row['comment_author'];
    $comment_stars = $row['comment_stars'];
    $comment_post_id = $row['comment_post_id'];



?>






<!-- THIS IS ACTUAL COMMMENT -->
<div class="media parent">


    <?php 
    $pic_query = "SELECT user_image FROM users WHERE username = '{$comment_author}' ";
    $get_pic_query = mysqli_query($connect, $pic_query);
    while($row = mysqli_fetch_assoc($get_pic_query)){
        $user_image = $row['user_image'];
    }

    ?>
    <?php if($user_image == "") { } else { ?>
    <a class="pull-left" href="#">
        <img class="media-object" width="150" src="images/<?php echo $user_image;?>" alt="">
    </a>

    <?php } ?>


    <div class="media-body">

    <?php if($comment_author == $post_author){ ?>
        <a href="profile.php?profile=<?php echo $comment_author?>"><h4 class="media-heading" style="color: orange; font-size: 20px;"><strong><?php echo $comment_author; ?></strong></h4></a>
        <?php } else { ?> 
        <a href="profile.php?profile=<?php echo $comment_author?>"><h4 class="media-heading"><?php echo $comment_author; ?></h4></a>
        <?php } ?>
        <small><?php echo $comment_date; ?></small>
        
    </div>
    <p><?php echo $comment_content; ?></p>
    <?php if(isset($_SESSION['username'])){ ?>





        <div class="replysection">
            <?php
if(isset($_SESSION['username'])){  
$username = $_SESSION['username'];
$query2 = "SELECT * FROM starred_comments WHERE username = '{$username}' AND comment_id = {$comment_id}";
$select_starred_comments_query = mysqli_query($connect, $query2);
$num_of_rows = mysqli_num_rows($select_starred_comments_query);


if($num_of_rows >= 1){ ?>
    <span></span>
    <?php if(!$username = $_SESSION['username']){ } else { ?>
    <a href='post.php?p_id=<?php echo $comment_post_id; ?>&unstar=<?php echo $comment_id;?>&comment_author=<?php echo $comment_author ?>' class="starpost btn btn-warning"><span class="glyphicon glyphicon-star "></span> <?php echo $comment_stars; ?> </a>
    <?php } ?>

<?php } else { ?>
    <span></span> 
    <?php if(!$username = $_SESSION['username']){ } else { ?>
    <a href='post.php?p_id=<?php echo $comment_post_id; ?>&star=<?php echo $comment_id;?>&comment_author=<?php echo $comment_author ?>' class="starpost btn btn-info"><span class="glyphicon glyphicon-star-empty "></span> <?php echo $comment_stars; ?> </a>
    <?php } ?>
<?php } } else { }?><span><button class="btn btn-primary">Reply</button></span>


        <?php if($username == $comment_author || $username == $post_author){ ?>

            <a href="post.php?p_id=<?php echo $the_post_id ?>&deletecomment=<?php echo $comment_id;?>""><span><button class="btn btn-danger">Delete</button></span></a>
            <?php } else { } ?>



            <div class="reply_text" style="display: none;">

            <form action="" method="POST">
                <textarea name="comment_content" class="textarea form-control"></textarea>
                <button type="submit" name="create_reply" class="btn-sm btn-primary">submit</button>
                <input type="text" name="original_comment_author" value="<?php echo $comment_author;?>" style="display: none;">
                <input type="text" name="original_comment_id" value="<?php echo $comment_id;?>" style="display: none;">
            </form>
                
            </div>
            
            
        </div>
    <?php } else { } ?>


<!-- comment replies go here -->




<?php
$query = "SELECT * from comment_replies WHERE original_comment_id = {$comment_id} ";
$query .= "ORDER BY id ASC ";
$select_replies_query = mysqli_query($connect, $query);
if(!$select_replies_query){
    die ("query failed" .mysqli_error($connect));
}
while ($row = mysqli_fetch_assoc($select_replies_query)){
    $id = $row['id'];
    $original_comment_id = $row['original_comment_id'];
    $original_comment_author = $row['original_comment_author'];
    $comment_author = $row['comment_author'];
    $comment_content = $row['comment_content'];
    $comment_stars = $row['star_count'];




?>




<!-- THIS IS REPLY -->

<div class="media parent" style="margin-left: 20px;">



    <?php 
    $pic_query = "SELECT user_image FROM users WHERE username = '{$comment_author}' ";
    $get_pic_query = mysqli_query($connect, $pic_query);
    while($row = mysqli_fetch_assoc($get_pic_query)){
        $user_image = $row['user_image'];
    }

    ?>
 <?php if($user_image == "") { } else { ?>
    <a class="pull-left" href="#">
        <img class="media-object" width="125" src="images/<?php echo $user_image;?>" alt="">
    </a>

 <?php } ?>
    <div class="media-body">
        <a href="profile.php?profile=<?php echo $comment_author?>"><h4 class="media-heading"><?php echo $comment_author; ?></h4></a>
        <?php echo $comment_content; ?>
    </div>
    <?php if($username = $_SESSION['username']){ ?>
        <div class=" replysection">
        <?php 


        $username = $_SESSION['username'];
        $query4 = "SELECT * FROM starred_comments WHERE username = '{$username}' AND comment_reply_id = {$id}";
        $select_starred_comments_query = mysqli_query($connect, $query4);
        $num_of_rows2 = mysqli_num_rows($select_starred_comments_query);

        if(!$username = $_SESSION['username']){ } else {
        if($num_of_rows2 >= 1){ ?>

            <a href='post.php?p_id=<?php echo $comment_post_id; ?>&unstarreply=<?php echo $id;?>&comment_author=<?php echo $comment_author ?>' class="starpost btn btn-warning"><span class="glyphicon glyphicon-star"><?php echo $comment_stars; ?></a>

        <?php } else { ?>

            <a href='post.php?p_id=<?php echo $comment_post_id; ?>&starreply=<?php echo $id;?>&comment_author=<?php echo $comment_author ?>' class="starpost btn btn-info"><span class="glyphicon glyphicon-star-empty "></span><?php echo $comment_stars; ?></a>

        <?php } } ?>
            <button class="btn btn-primary">Reply</button>
            <?php if($username == $comment_author || $username == $post_author){ ?>
            <a href="post.php?p_id=<?php echo $the_post_id ?>&deletereply=<?php echo $id;?>"><button class="btn btn-danger">Delete</button></a>
            <?php } else { } ?>


            <div class="reply_text" style="display: none;">
            <form action="" method="POST">
                <textarea name="comment_content" class="textarea form-control"></textarea>
                <button type="submit" name="create_reply" class="btn-sm btn-primary">submit</button>
                <input type="text" name="original_comment_author" value="<?php echo $comment_author;?>" style="display: none;">
                <input type="text" name="original_comment_id" value="<?php echo $comment_id;?>" style="display: none;">
            </form>   
            </div>
        </div>

    <?php } else { } ?>
</div>
<?php } ?>
</div>
<?php } ?>


<!-- END OF Comment -->


</div>
<?php include "includes/sidebar.php" ?>
</div>
<!-- Blog Sidebar Widgets Column -->
</div>
<!-- /.row -->
<hr>
<?php
include "includes/footer.php"
?>