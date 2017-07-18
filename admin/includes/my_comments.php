<?php
if(isset($_POST['checkBoxArray'])){

    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            


            case 'delete':
                $query = "DELETE FROM comments WHERE comment_id= {$postValueId} ";
                
                $update_to_delete_status = mysqli_query($connect,$query);
                confirm($update_to_delete_status);

                break;


            default:
                # code...
                break;
        }
    }

}


?>    
<form action="" method="post">
    <table class="table table-bordered table-hover">

        <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="delete">Delete</option>
            
        </select>

    </div>

    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        
    </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox" name=""></th>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response To</th>
                <th>Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
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



    echo $username = $_SESSION['username'];
    echo $userrole = $_SESSION['user_role'];

    $subquery = "SELECT * FROM comments WHERE comment_author = '$username' ORDER BY comment_id DESC LIMIT $page_1, $per_page";
    $select_comments = mysqli_query($connect, $subquery);
    
    


    while($row = mysqli_fetch_assoc($select_comments)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_content = $row['comment_content'];
    $comment_email = $row['comment_email'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];


    echo "<tr>";
    ?>
    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>'></td>
    <?php
    echo "<td>{$comment_id}</td>";
    echo "<td>{$comment_author}</td>";
    echo "<td>{$comment_content}</td>";


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
    echo "<td><a href='comments.php?source=edit_comment&c_id={$comment_id}'>Edit</a></td>";
    echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
    echo "</tr>";
        }

?>
            
        </tbody>
    </table>
</form>
<?php 
    $query = "SELECT * FROM comments WHERE comment_author = '{$username}'";
    $per_page = 5;
    $find_count = mysqli_query($connect, $query);
    $count = mysqli_num_rows($find_count);
    $count = ceil($count / $per_page); 

    ?>

            <ul class="pager">
            <?php
            for ($i=1; $i <= $count; $i++) { 
                if($i == $page) {
                    echo "<li><a class='active_link' href='comments.php?source=my_comments&page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='comments.php?source=my_comments&page={$i}'>{$i}</a></li>";

                }
                
            }
        ?>

        </ul>

<?php 


if(isset($_GET['delete'])){
    $the_comment_id = escape($_GET['delete']);
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
    $delete_query = mysqli_query($connect, $query);
    header("Location: comments.php");
}

?>