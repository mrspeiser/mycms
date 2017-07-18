<?php 

if(isset($_POST['create_post'])){
	$post_title = escape($_POST['title']);
	$post_author = escape($_SESSION['username']);
	$post_category_id = escape($_POST['post_category']);
	$post_status = escape($_POST['post_status']);
	$post_user = $_SESSION['username'];
	$post_image = escape($_FILES['image']['name']);
	$post_image_temp = escape($_FILES['image']['tmp_name']);

	$post_tags = escape($_POST['post_tags']);
	$post_content = escape(nl2br($_POST['post_content']));
	$post_date = escape(date('d-m-y'));
	

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_user, post_image, post_content,post_tags,post_status) ";
	$query .=
	"VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(),'{$post_user}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}' ) ";
	

	$create_post_query = mysqli_query($connect, $query);
	confirm($create_post_query);

	$the_post_id = mysqli_insert_id($connect);

	echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post </a>or<a href='posts.php'> Edit More Posts</a></p>";

	

}


?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title">
	</div>	

	<div class="form-group">
	<label for="category">Category</label>
		<select name="post_category">
<?php

$username = $_SESSION['username'];
echo "<option value='0'>Select Category</option>";
$query = "SELECT * FROM favorite_cat WHERE username = '{$username}' ";
$select_categories = mysqli_query($connect, $query);
confirm($select_categories);

while($row = mysqli_fetch_assoc($select_categories)) {
$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];  

echo "<option value='$cat_id'>{$cat_title}</option>";
}


?>


		</select>
	</div>	
	


	<div class="form-group">
		
		<select name="post_status">
			<option value="draft">Post Status</option>
			<option value="published">Publish</option>
			<option value="draft">Draft</option>
		</select>
	</div>	

	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" class="form-control" name="image">
	</div>	

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>	

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div>	

	<input type="submit" class="btn btn-primary" name="create_post" value="Publish">

</form>