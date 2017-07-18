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
    Favorite Users
    <small></small>
    </h1>

    <div class="col-xs-12">



    <form action="favorite_users.php" method="post">
    <div class="form-group">
        <label for="cat-title">Search</label>
        <input class="form-control" type="text" name="search">
        </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit" value="Search Users">
    </div>
    </form>
    <?php 
    addFavUser(); 
    deleteFavUser();
    ?>

    <?php 
            if(isset($_POST['submit'])){ ?>

        <table class="table table-bordered table-hover">
        <label for="cat-title">Results:</label>
        <thead>
            <th>username</th>
            <th>first name</th>
            <th>last name</th>
            <th>user image</th>
            <th>View Profile</th>
            <th>Add user</th>
          
        </thead>
        <tbody>

            <?php 

            $search = escape($_POST['search']);

            $query = "SELECT * FROM users WHERE username LIKE '%$search%' ";
            $search_query = mysqli_query($connect, $query);

            if(!$search_query){
                die("query failed". mysqli_error($connect));
                }

            $count = mysqli_num_rows($search_query);
                if($count == 0){
                    echo "<h1> No Results</h1>";
                } else {

                    while($row = 
                    mysqli_fetch_assoc($search_query)) 

                    {
            $row_id = $row['user_id'];
            $row_username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname']; 
            $user_image = $row['user_image']; 

?>



            <?php
        echo "<tr>";
        echo "<td>{$row_username}</td>"; 
        echo "<td>{$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td><img width='100' src='../images/$user_image'</td>";
        echo "<td><a href='../profile.php?profile={$row_username}'>View Profile</a></td>";
        echo "<td><a href='favorite_users.php?add={$row_username}'>Add</a></td>";
        echo "</tr>"; 
            } 
        
        ?>

            </tbody>
        </table>
        <?php }
    }

?>



    <div class="col-xs-12">



    </div>

    </div> <!-- Add Category Form -->

    <div class="col-xs-12">


        <table class="table table-bordered table-hover">
        <label for="cat-title">Favorite Users:</label>
        <thead>
            <th>username</th>
            <th>first name</th>
            <th>last name</th>
            <th>user image</th>
            <th>View Profile</th>
            <th>remove user</th>
          
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


        $username = $_SESSION['username'];
        $query = "SELECT * FROM favorite_users WHERE username = '{$username}' ORDER BY id DESC LIMIT $page_1, $per_page";
        $select_favorited_users = mysqli_query($connect, $query);
        while($row = mysqli_fetch_assoc($select_favorited_users)) {
            $row_id = $row['id'];
            $row_username = $row['username'];
            $favorited_user_id = $row['favorited_user_id'];
            $favorited_username = $row['favorited_user'];

        echo "<tr>";
        echo "<td>{$favorited_username}</td>";
        
        

        $query2 = "SELECT user_image, user_firstname, user_lastname FROM users WHERE username = '{$favorited_username}'";
        $get_user_info = mysqli_query($connect, $query2);
        while($row2 = mysqli_fetch_assoc($get_user_info)){
             $user_image = $row2['user_image'];
             $user_firstname = $row2['user_firstname'];
             $user_lastname = $row2['user_lastname'];

        echo "<td>{$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td><img width='100' src='../images/$user_image'</td>";
        echo "<td><a href='../profile.php?profile={$favorited_username}'>View Profile</a></td>";
        echo "<td><a href='favorite_users.php?remove={$row_id}'>Remove</a></td>";
        echo "</tr>";
        }
           
        
        }

        ?>
       

 
          
        </tbody>
        </table>
<?php 
    $query = "SELECT * FROM favorite_users WHERE username = '{$username}'";
    $per_page = 5;
    $find_count = mysqli_query($connect, $query);
    $count = mysqli_num_rows($find_count);
    $count = ceil($count / $per_page); 

    ?>

            <ul class="pager">
            <?php
            for ($i=1; $i <= $count; $i++) { 
                if($i == $page) {
                    echo "<li><a class='active_link' href='favorite_users.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='favorite_users.php?page={$i}'>{$i}</a></li>";

                }
                
            }
        ?>

        </ul>

    </div>


    </div>
    </div>
    <!-- /.row -->

    </div>
<!-- /.container-fluid -->

</div>


<?php include "includes/admin_footer.php" ?>