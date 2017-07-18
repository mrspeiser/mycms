<?php 

	if(isset($_GET['p_id'])){  //fetches pre-fill data
		$the_post_id = escape($_GET['p_id']);
	}

    $query = "SELECT * FROM Posts WHERE post_id = $the_post_id";
    $select_posts = mysqli_query($connect, $query);

    while($row = mysqli_fetch_assoc($select_posts)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title']; 
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image= $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];

}

if(isset($_POST['update_post'])){ //get fields from form and update

	$post_title = escape($_POST['title']);
	$post_category_id = escape($_POST['post_category']);
	$post_status = escape($_POST['post_status']);
	$post_image = escape($_FILES['post_image']['name']);
	$post_image_temp = escape($_FILES['post_image']['tmp_name']);
	$post_tags = escape($_POST['post_tags']);
	$post_content = escape(nl2br($_POST['post_content']));
	
	move_uploaded_file($post_image_temp, "../images/$post_image");
	if(empty($post_image)){
		$query = "SELECT * FROM Posts WHERE post_id = {$the_post_id} ";
		$select_image = mysqli_query($connect,$query);
		while($row = mysqli_fetch_array($select_image)){
			$post_image = $row['post_image'];
		}
	}

	$query = "UPDATE Posts SET ";
	$query .= "post_title = '{$post_title}', ";
	$query .= "post_category_id = '{$post_category_id}', ";
	$query .= "post_date = now(), ";
	$query .= "post_author = '{$post_author}', ";
	$query .= "post_status = '{$post_status}', ";
	$query .= "post_tags = '{$post_tags}', ";
	$query .= "post_image = '{$post_image}', ";
	$query .= "post_content = '{$post_content}' ";
	$query .= "WHERE post_id = {$the_post_id} ";


	$update_post = mysqli_query($connect, $query);
	confirm($update_post);

	echo "<p class='bg-success'>Post Update. <a href='../post.php?p_id={$the_post_id}'>View Post </a>or<a href='posts.php'> Edit More Posts</a></p>";

	}
?>

<?php

if(isset($_POST['create_post'])){
	$post_title = escape($_POST['title']);
	$post_author = escape($_POST['author']);
	$post_category_id = escape($_POST['post_category_id']);
	$post_status = escape($_POST['post_status']);

	$post_image = escape($_FILES['image']['name']);
	$post_image_temp = escape($_FILES['image']['tmp_name']);

	$post_tags = escape($_POST['post_tags']);
	$post_content = escape($_POST['post_content']);
	$post_date = escape(date('d-m-y'));
	$post_comment_count = 4;

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "INSERT INTO posts(post_category_id, post_title, post_date, post_image, post_content,post_tags,post_comment_count,post_status) ";
	$query .=
	"VALUES({$post_category_id}, '{$post_title}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}' ) ";
	

	$create_post_query = mysqli_query($connect, $query);
	confirm($create_post_query);

}


?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
	</div>	

	<div class="form-group">
		<label for="category">Category</label>
		<select name="post_category" id="">
<?php
$query = "SELECT * FROM categories";
$select_categories = mysqli_query($connect, $query);
confirm($select_categories);

while($row = mysqli_fetch_assoc($select_categories)) {
$cat_id = $row['id'];
$cat_title = $row['cat_title'];  

echo "<option value='$cat_id'>{$cat_title}</option>";
echo $cat_title;
}
?>


		</select>
	</div>	
	


	<div class="form-group">
	<select name="post_status" id="">
		<option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
		<?php
		if($post_status == 'published'){
			echo "<option value='draft'>Draft</option>";
		} else {
			echo "<option value='published'>Published</option>";
		}

			?>

	</select>
	</div>



<!-- 	
		<label for="post_status">Post Status</label>
		<input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
	</div>	 -->

	<div class="form-group">
		<img width="100px;" src="../images/<?php echo $post_image; ?>" name="image">
		<input type="file" name="post_image">
	</div>	

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
	</div>	

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
	</div>	

	<input type="submit" class="btn btn-primary" name="update_post" value="Update Post">

</form>