 <?php 

if(isset($_GET['edit_user'])){
	$the_user_id = escape($_GET['edit_user']);


	$query = "SELECT * FROM users WHERE user_id = $the_user_id ";
    $select_user_query = mysqli_query($connect, $query);

    while($row = mysqli_fetch_assoc($select_user_query)) {
    $user_id = $row['user_id'];
    echo $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];
    $user_quote = $row['user_quote'];
    $user_description = $row['user_description'];
	}


if(isset($_POST['edit_user'])){
	$user_firstname = escape($_POST['user_firstname']);
	$user_lastname = escape($_POST['user_lastname']);
	$user_role = escape($_POST['user_role']);
	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];
	$username = escape($_POST['username']);
	$user_email = escape($_POST['user_email']);
	$user_password = escape($_POST['user_password']);
	$user_quote = escape($_POST['user_quote']);
	$user_description = escape($_POST['user_description']);
	// $post_date = date('d-m-y');
	

	

if(!empty($user_password)){


	$query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
	$get_user = mysqli_query($connect, $query_password);
	confirm($get_user);
	$row = mysqli_fetch_array($get_user);
	$db_user_password = $row['user_password'];


if($db_user_password != $user_password){
	$hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
}

	$query = "UPDATE users SET ";
	$query .= "user_firstname = '{$user_firstname}', ";
	$query .= "user_lastname = '{$user_firstname}', ";
	$query .= "user_role = '{$user_role}', ";
	$query .= "username = '{$username}', ";
	$query .= "user_email = '{$user_email}', ";
	$query .= "user_password = '{$hashed_password}' ";
	$query .= "WHERE user_id = {$the_user_id} ";
$update_user = mysqli_query($connect, $query);
	confirm($update_user);

	echo "User Updated" . " <a href='users.php'>View Users?</a>";

	}

	// move_uploaded_file($post_image_temp, "../images/$post_image");

}

} else {
	header("Location: index.php");
}


?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="author">First Name</label>
		<input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
	</div>	

	<div class="form-group">
		<label for="post_status">Last Name</label>
		<input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">
	</div>	

	<select name="user_role" id="">
	<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
		<?php 
		if($user_role == 'admin'){
			echo "<option value='subscriber'>Subscriber</option>";
		} else {
			echo "<option value='admin'>Admin</option>";
		}

		?>

		
		
		
	</select>	


	<div class="form-group">
		<label for="image">Username</label>
		<input type="text" class="form-control" name="username" value="<?php echo $username;?>">
	</div>	

	<div class="form-group">
		<label for="post_tags">Email</label>
		<input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>">
	</div>	

	<div class="form-group">
		<label for="post_tags">My Quote</label>
		<input type="text" class="form-control" name="user_quote" value="<?php echo $user_quote;?>">
	</div>

	

	<div class="form-group">
		<label for="post_content">Password</label>
		<input type="password" class="form-control" name="user_password" value="<?php echo $user_password;?>">
	</div>	

	<input type="submit" class="btn btn-primary" name="edit_user" value="Update User">

</form>