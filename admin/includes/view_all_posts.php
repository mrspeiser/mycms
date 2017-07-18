<?php
if(isset($_POST['checkBoxArray'])){

    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = escape($_POST['bulk_options']);
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId} ";
                
                $update_to_published_status = mysqli_query($connect,$query);
                confirm($update_to_published_status);

                break;


            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId} ";
                
                $update_to_draft_status = mysqli_query($connect,$query);
                confirm($update_to_draft_status);

                break;


            case 'delete':
                $query = "DELETE FROM posts WHERE post_id= {$postValueId} ";
                
                $update_to_delete_status = mysqli_query($connect,$query);
                confirm($update_to_delete_status);

                break;

            case 'clone':

                $query = "SELECT * FROM posts WHERE post_id= '{$postValueId}' ";
                $select_post_query = mysqli_query($connect, $query);

                while($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_user = $row['post_user'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content,post_tags,post_status) ";
                $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}' ) ";
                    $copy_post_query = mysqli_query($connect, $query);
                    if(!$copy_post_query){
                        die("QUERY FAILED" . mysqli_error($connect));
                    }

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
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
                <?php 

    $username = $_SESSION['username'];
    $userrole = $_SESSION['user_role'];

    if($userrole == 'admin'){ ?>
            <option value="clone">Clone</option> <?php } else { }?>
        </select>

    </div>
<?php

?>

    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox" name=""></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>
<?php

if(isset($_GET['page'])){

$per_page = 50;
$page = escape($_GET['page']);
} else {
    $page = "";
}
if($page == "" || $page == 1) {
    $page_1 = 0;
} else {
    $page_1 = ($page * $per_page) - $per_page;
}
$per_page = 50;
$username = $_SESSION['username'];
$userrole = $_SESSION['user_role'];

    if($userrole == 'admin'){

    $query = "SELECT * FROM Posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
    $select_posts = mysqli_query($connect, $query);

    
    } else {
    $subquery = "SELECT * FROM Posts WHERE post_user = '$username' ORDER BY post_id DESC LIMIT $page_1, $per_page";
    $select_posts = mysqli_query($connect, $subquery);
    
    }
    

    while($row = mysqli_fetch_assoc($select_posts)) {
    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title']; 
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image= $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_views_count = $row['post_views_count'];


    echo "<tr>";
    ?>
    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
    <?php
    echo "<td>{$post_id}</td>";
    echo "<td>{$post_user}</td>";
    echo "<td>{$post_title}</td>";

$query = "SELECT * FROM categories WHERE id = {$post_category_id}";
$select_categories_id = mysqli_query($connect, $query);

while($row = mysqli_fetch_assoc($select_categories_id)) {
$cat_id = $row['id'];
$cat_title = $row['cat_title']; 


    echo "<td>{$cat_title}</td>";
}
    echo "<td>{$post_status}</td>";
    echo "<td><img width='100' src='../images/$post_image'</td>";
    echo "<td>{$post_tags}</td>";

    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
    $send_comment_query = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($send_comment_query);
    $comment_id = $row['comment_id'];
    $count_comments = mysqli_num_rows($send_comment_query);
    echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";



    echo "<td>{$post_date}</td>";
    echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
    echo "<td><a href='posts.php?reset={$post_id}'>$post_views_count</a></td>";
    echo "</tr>";
        }

?>


            
    </tbody>
    </table>
    </form>

    <?php 

    $username = $_SESSION['username'];
    $userrole = $_SESSION['user_role'];

    if($userrole == 'admin'){

    $query = "SELECT * FROM Posts ORDER BY post_id DESC";
    $select_posts = mysqli_query($connect, $query);

    
    } else {
    $query = "SELECT * FROM Posts WHERE post_user = '$username' ";
    $select_posts = mysqli_query($connect, $subquery);
    
    }

    $per_page = 50;
    $find_count = mysqli_query($connect, $query);
    $count = mysqli_num_rows($find_count);
    $count = ceil($count / $per_page); 

    ?>

            <ul class="pager">
            <?php
            for ($i=1; $i <= $count; $i++) { 
                if($i == $page) {
                    echo "<li><a class='active_link' href='posts.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='posts.php?page={$i}'>{$i}</a></li>";

                }
                
            }
        ?>

        </ul>


<?php 

if(isset($_GET['delete'])){
    $post_id = escape($_GET['delete']);
    $query = "DELETE FROM posts WHERE post_id = {$post_id}";
    $delete_query = mysqli_query($connect, $query);
    header("Location: posts.php");

}

if(isset($_GET['reset'])){
    $post_id = escape($_GET['delete']);
    $query = "UPDATE Posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connect, $_GET['reset']) . " ";
    $reset_query = mysqli_query($connect, $query);
    header("Location: posts.php");

}



?>