    <?php include "includes/admin_header.php" ?>

<div id="wrapper">




    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
    
    <small></small>
    </h1>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response To</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
               
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

<?php 

if(isset($_GET['approve'])){

    $the_comment_id = escape($_GET['approve']);
    $query = "UPDATE comments  SET comment_status = 'approved' WHERE comment_id = $the_comment_id";

    $approve_comment_query = mysqli_query($connect, $query);
    header("Location: post_comments.php?id=" . $_GET['id'] . "");
}



if(isset($_GET['unapprove'])){

    $the_comment_id = escape($_GET['unapprove']);
    $query = "UPDATE comments  SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id";

    $unapprove_comment_query = mysqli_query($connect, $query);
    header("Location: post_comments.php?id=" . $_GET['id'] . "");
}






if(isset($_GET['delete'])){
    $the_comment_id = escape($_GET['delete']);
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
    $delete_query = mysqli_query($connect, $query);
    header("Location: post_comments.php?id=" . $_GET['id'] . "");
}

   
?>

<?php

if(isset($_GET['page'])){

$per_page = 25;
$page = escape($_GET['page']);
} else {
    $page = "";
}
if($page == "" || $page == 1) {
    $page_1 = 0;
} else {
    $page_1 = ($page * $per_page) - $per_page;
}
$per_page = 25;

if(isset($_GET['id'])){
    $post_id = $_GET['id'];
    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id LIMIT $page_1, $per_page ";
    $select_comments = mysqli_query($connect, $query);
    confirm($select_comments);

    while($row = mysqli_fetch_assoc($select_comments)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_content = $row['comment_content'];
    $comment_email = $row['comment_email'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];


    echo "<tr>";
    echo "<td>{$comment_id}</td>";
    echo "<td>{$comment_author}</td>";
    echo "<td>{$comment_content}</td>";
    

// $query = "SELECT * FROM categories WHERE id = {$post_category_id}";
// $select_categories_id = mysqli_query($connect, $query);

// while($row = mysqli_fetch_assoc($select_categories_id)) {
// $cat_id = $row['id'];
// $cat_title = $row['cat_title']; 


//     echo "<td>{$cat_title}</td>";
// }


    echo "<td>{$comment_email}</td>";
    echo "<td>{$comment_status}</td>";

    $query = "SELECT * FROM Posts WHERE post_id = $comment_post_id";
    $select_post_id_query = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($select_post_id_query)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];

    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
    }
    

    echo "<td>{$comment_date}</td>";
    echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] ."'>Approved</a></td>";
    echo "<td><a href='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] ."'>Unapproved</a></td>";
    echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] ."'>Delete</a></td>";
    echo "</tr>";
        }

//end of php table script
}
?>
            
        </tbody>
    </table>

    <!-- end of table html -->
    <?php 
    # code...

   
    $select_comment_query_count = "SELECT * FROM comments WHERE comment_post_id = $post_id LIMIT $page_1, $per_page ";
    $find_count = mysqli_query($connect, $select_comment_query_count);
    $count = mysqli_num_rows($find_count);
    $count = ceil($count / $per_page);

?>


    <!-- // pagination =======================================================   -->


        <ul class="pager">
            <?php

            for ($i=1; $i <= $count; $i++) { 
                if($i == $page) {
                    echo "<li><a class='active_link' href='post_comments.php?id={$post_id}&page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='post_comments.php?id={$post_id}&page={$i}'>{$i}</a></li>";

                }
                
            }
        ?>

        </ul>








    </div>
    </div>
    <!-- /.row -->

    </div>
<!-- /.container-fluid -->

</div>


<?php include "includes/admin_footer.php" ?>