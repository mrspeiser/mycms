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
    My Categories
    <small></small>
    </h1>

    <div class="col-xs-6">


<h5>Search For Category:</h5>
<form action="my_categories.php" method="POST">
    <div class="input-group">
        <input name="search" type="text" class="form-control">
    <span class="input-group-btn">
        <button type="submit" name="submit" class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
        </button>
                </span>
    </div>
</form>

    <div class="col-xs-6">


        <table class="table table-bordered table-hover">
        <thead>
            <tr>
            <label>All Categories:</label>
            

            </tr>
        </thead>
        <tbody>

            
<?php 
            if(isset($_POST['submit'])){

            $search = escape($_POST['search']);

            $query = "SELECT * FROM categories WHERE cat_title LIKE '%$search%' ";
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
                        $id = $row['id'];
                        $cat_title = $row['cat_title'];
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$cat_title}</td>";
                        echo "<td><a href='my_categories.php?fav={$id}&title={$cat_title}'>FAV</a></td>";
                        echo "</tr>";   
            } 
        }
    }

?>

 <?php if(isset($_GET['fav'])){
    $cat_id = $_GET['fav'];
    $cat_title = $_GET['title'];
    $username = $_SESSION['username'];
    $query = "INSERT INTO favorite_cat(username, cat_id, cat_title) ";
    $query .= "VALUE('{$username}',{$cat_id}, '{$cat_title}')";
    $favorite_cat_query = mysqli_query($connect, $query);
    if(!$favorite_cat_query){
                die('Query Failed' .mysqli_error($connect));
    header("Location: my_categories.php");}
    } ?>
          
        </tbody>
        </table>


    </div>

    </div> <!-- Add Category Form -->

    <div class="col-xs-6">


        <table class="table table-bordered table-hover">
        <label for="cat-title">Favorite Categories</label>
        <thead>
            <?php findFavCategories(); ?>
            <?php deleteFavCategory(); ?>
        </thead>
        <tbody>


        </tbody>
        </table>


    </div>


    </div>
    </div>
    <!-- /.row -->

    </div>
<!-- /.container-fluid -->

</div>


<?php include "includes/admin_footer.php" ?>