<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Categories</label>

<?php
if(isset($_GET['edit'])){
$cat_id = escape($_GET['edit']);
$query = "SELECT * FROM categories WHERE id = $cat_id";
$select_categories_id = mysqli_query($connect, $query);

while($row = mysqli_fetch_assoc($select_categories_id)) {
$cat_id = $row['id'];
$cat_title = $row['cat_title'];  
?>

<input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">


<?php }} ?>

<?php 

if(isset($_POST['update_category'])){
$the_cat_title = escape($_POST['cat_title']);
$updatequery = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE id = {$cat_id} ";
$updatequery = mysqli_query($connect,$updatequery);
    if(!$updatequery){
        die("query has failed" .mysqli_error($connect));
    }
}


?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>