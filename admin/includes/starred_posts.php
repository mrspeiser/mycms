<?php



?>    

    <table class="table table-bordered table-hover">


        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Image</th>
                <th>Category</th>
                <th>Comment Count</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Remove</th>
              
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


    $username = $_SESSION['username'];
    $userrole = $_SESSION['user_role'];


$query = "SELECT * FROM favorite_posts WHERE username = '{$username}' ORDER BY id DESC LIMIT $page_1, $per_page";
$select_posts = mysqli_query($connect, $query);

while($row = mysqli_fetch_assoc($select_posts)) {
$id = $row['id'];
$post_title = $row['post_title'];
$post_id = $row['post_id']; 


echo "<tr>"; 
echo "<td>{$post_title}</td>";

$postsquery = "SELECT * FROM Posts WHERE post_id = {$post_id}";
$select_all = mysqli_query($connect, $postsquery);

while($row = mysqli_fetch_assoc($select_all)) {

$post_user = $row['post_user'];
$post_image = $row['post_image'];
$post_category_id = $row['post_category_id'];
$post_date = $row['post_date'];

echo "<td>{$post_user}</td>";
echo "<td><img width='100' src='../images/$post_image'</td>";
    
}

$query = "SELECT * FROM categories WHERE id = {$post_category_id}";
$select_categories_id = mysqli_query($connect, $query);

while($row = mysqli_fetch_assoc($select_categories_id)) {
$cat_id = $row['id'];
$cat_title = $row['cat_title']; 


    echo "<td>{$cat_title}</td>";
}

    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
    $send_comment_query = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($send_comment_query);
    $comment_id = $row['comment_id'];
    $count_comments = mysqli_num_rows($send_comment_query);
    echo "<td>$count_comments</td>";



    echo "<td>{$post_date}</td>";
    echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";

    echo "<td><a href='posts.php?source=starred_posts&remove={$id}'>Remove</a></td>";
  
    echo "</tr>"; 

}

        

?>


            
    </tbody>
    </table>
<?php 
    $query = "SELECT * FROM favorite_posts WHERE username = '{$username}'";
    $per_page = 5;
    $find_count = mysqli_query($connect, $query);
    $count = mysqli_num_rows($find_count);
    $count = ceil($count / $per_page); 

    ?>

            <ul class="pager">
            <?php
            for ($i=1; $i <= $count; $i++) { 
                if($i == $page) {
                    echo "<li><a class='active_link' href='posts.php?source=starred_posts&page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='posts.php?source=starred_posts&page={$i}'>{$i}</a></li>";

                }
                
            }
        ?>

        </ul>
<?php 

deleteStarredPost();




?>