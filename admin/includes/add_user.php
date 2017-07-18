<?php 

if(isset($_POST['create_user'])){
	
	$user_firstname = escape($_POST['user_firstname']);
	$user_lastname = escape($_POST['user_lastname']);
	$user_role = escape($_POST['user_role']);

	// $post_image = $_FILES['image']['name'];
	// $post_image_temp = $_FILES['image']['tmp_name'];

	$username = escape($_POST['username']);
	$user_email = escape($_POST['user_email']);
	$user_password = escape($_POST['user_password']);
	// $post_date = date('d-m-y');
	$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));


	$query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
	$query .=
	"VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}' ) ";
	

	$create_user_query = mysqli_query($connect, $query);
	confirm($create_user_query);


	echo "User Created: " . " " . "<a href='users.php'>View Users</a> ";

}


?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="author">First Name</label>
		<input type="text" class="form-control" name="user_firstname">
	</div>	

	<div class="form-group">
		<label for="post_status">Last Name</label>
		<input type="text" class="form-control" name="user_lastname">
	</div>	

	<select name="user_role" id="">
		<option value="subscriber">Select Options</option>
		<option value="admin">Admin</option>
		<option value="subscriber">Subscriber</option>
	</select>	


	<div class="form-group">
		<label for="image">Username</label>
		<input type="text" class="form-control" name="username">
	</div>	

	<div class="form-group">
		<label for="post_tags">Email</label>
		<input type="email" class="form-control" name="user_email">
	</div>	

	<div class="form-group">
		<label for="post_content">Password</label>
		<input type="password" class="form-control" name="user_password">
	</div>	

	<input type="submit" class="btn btn-primary" name="create_user" value="Add User">

</form>