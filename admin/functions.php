<?php


function escape($string){
global $connect;
return mysqli_real_escape_string($connect, trim($string));

}

function users_online() {

if(isset($_GET['usersonline'])){

global $connect;
if(!$connect){
session_start();
include("../includes/db.php");

$session = session_id();
$time = time();
$time_out_in_seconds = 05;
$time_out = $time - $time_out_in_seconds;

$query = "SELECT * FROM users_online WHERE session = '$session'";
$send_query = mysqli_query($connect, $query);
$count = mysqli_num_rows($send_query);

if($count == NULL){
mysqli_query($connect, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
} else {

mysqli_query($connect, "UPDATE users_online SET time = '$time' WHERE session = '$session' ");

}

$users_online_query = mysqli_query($connect, "SELECT * FROM users_online WHERE time > '$time_out' ");
echo $count_user = mysqli_num_rows($users_online_query);

		}

   	} //get request isset
}

users_online();


function confirm($result) {
	global $connect;
	if(!$result) {
		die("the query did not succeed " .mysqli_error($connect));
	}
}


function category_exists($cat_title){
	global $connect;
	$query = "SELECT cat_title FROM categories WHERE cat_title = '{$cat_title}'";
	$result = mysqli_query($connect, $query);
	confirm($result);
	if(mysqli_num_rows($result)>0){
		return true;
	} else {
		return false;
	}
}


function insert_categories() {
global $connect;

	if(isset($_POST['submit'])){
	    $cat_title = $_POST['cat_title'];

	    if($cat_title == "" || empty($cat_title)){
	        echo "Field cannot be empty";
	    } else if(category_exists($cat_title)){
	    	echo "Category Already Exists!";
	    } else {
	        $query = "INSERT INTO categories(cat_title) ";
	        $query .= "VALUE('{$cat_title}') ";

	        $create_category = mysqli_query($connect,$query);

	        if(!$create_category){
	            die('Query Failed' .mysqli_error($connect));
	        }
	    }
	}
}

function findAllCategories() {
global $connect;

	$query = "SELECT * FROM categories";
	$select_categories = mysqli_query($connect, $query);

	while($row = mysqli_fetch_assoc($select_categories)) {
	$cat_id = $row['id'];
	$cat_title = $row['cat_title'];
	echo "<tr>";
	echo "<td>{$cat_id}</td>";
	echo "<td>{$cat_title}</td>";
	echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
	echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>";
	echo "</tr>";
	    }


}

function findAllCategories2() {
global $connect;

	$query = "SELECT * FROM categories";
	$select_categories = mysqli_query($connect, $query);

	while($row = mysqli_fetch_assoc($select_categories)) {
	$cat_id = $row['id'];
	$cat_title = $row['cat_title'];
	echo "<tr>";
	echo "<td>{$cat_id}</td>";
	echo "<td>{$cat_title}</td>";
	echo "<td><a href='my_categories.php?fav={$cat_id}&title={$cat_title}'>FAV</a></td>";
	echo "</tr>";
	    }


}





function findFavCategories() {
global $connect;
	$current_user = $_SESSION['username'];
	$query = "SELECT * FROM favorite_cat WHERE username = '{$current_user}' ";
	$select_categories = mysqli_query($connect, $query);

	while($row = mysqli_fetch_assoc($select_categories)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];
	
	echo "<tr>";
	echo "<td>{$cat_title}</td>";
	echo "<td><a href='my_categories.php?remove={$cat_id}'>Remove</a></td>";
	echo "</tr>";
	    }


}

function deleteFavCategory() {
global $connect;
	$current_user = $_SESSION['username'];
	if(isset($_GET['remove'])){
	$cat_id = $_GET['remove'];
	$deletequery = "DELETE FROM favorite_cat WHERE username = '{$current_user}' AND cat_id = {$cat_id} ";
	$delete_query = mysqli_query($connect,$deletequery);
	header("Location: my_categories.php");
	}


}

function findFavCategories2() {
global $connect;
	$current_user = $_SESSION['username'];
	$query = "SELECT * FROM favorite_cat WHERE username = '{$current_user}' ";
	$select_categories = mysqli_query($connect, $query);

	while($row = mysqli_fetch_assoc($select_categories)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];
	
	echo "<tr>";
	echo "<td>{$cat_title}</td>";
	echo "<td><a href='all_categories.php?remove={$cat_id}'>Remove</a></td>";
	echo "</tr>";
	    }


}

function deleteFavCategory2() {
global $connect;
	$current_user = $_SESSION['username'];
	if(isset($_GET['remove'])){
	$cat_id = $_GET['remove'];
	$deletequery = "DELETE FROM favorite_cat WHERE username = '{$current_user}' AND cat_id = {$cat_id} ";
	$delete_query = mysqli_query($connect,$deletequery);
	header("Location: all_categories.php");
	}


}









function addFavUser() {
	global $connect;
	$current_user = $_SESSION['username'];
	if(isset($_GET['add'])){
	$username = $_GET['add'];
	$addquery = "INSERT INTO favorite_users(username, favorited_user, viewed) VALUE('{$current_user}', '{$username}', 'no' )";
	$add_query = mysqli_query($connect,$addquery);
	header("Location: favorite_users.php");
	}
}

function deleteFavUser() {
global $connect;
	$current_user = $_SESSION['username'];
	if(isset($_GET['remove'])){
	$row_id = $_GET['remove'];
	$deletequery = "DELETE FROM favorite_users WHERE username = '{$current_user}' AND id = {$row_id} ";
	$delete_query = mysqli_query($connect,$deletequery);
	header("Location: favorite_users.php");
	}


}



function deleteStarredPost() {
global $connect;
	$current_user = $_SESSION['username'];
	if(isset($_GET['remove'])){
	$row_id = $_GET['remove'];
	$deletequery = "DELETE FROM favorite_posts WHERE username = '{$current_user}' AND id = {$row_id} ";
	$delete_query = mysqli_query($connect,$deletequery);
	header("Location: posts.php?source=starred_posts");
	}


}



function deleteCategory() {
global $connect;

	if(isset($_GET['delete'])){
	$cat_id = $_GET['delete'];
	$deletequery = "DELETE FROM categories WHERE id = {$cat_id} ";
	$delete_query = mysqli_query($connect,$deletequery);
	header("Location: categories.php");
	}


}

function username_exists($username){
	global $connect;

	$query = "SELECT username FROM users WHERE username = '{$username}'";
	$result = mysqli_query($connect, $query);
	confirm($result);
	if(mysqli_num_rows($result)>0){
		return true;
	} else {
		return false;
	}
}


function register_user(){
global $connect;

	if(isset($_POST['submit'])){

		$username = escape($_POST['username']);
		$email = escape($_POST['email']);
		$password = escape($_POST['password']);
		if(username_exists($username)){
		    $message = "username already exists!";
		}

		else if(!empty($username) && !empty($email) && !empty($password)) {

		$username = mysqli_real_escape_string($connect, $username);
		$email = mysqli_real_escape_string($connect, $email);
		$password = mysqli_real_escape_string($connect, $password);

		$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10) );


		$query = "INSERT INTO users(username, user_email, user_password, user_role) ";
		$query .=
		"VALUES('{$username}', '{$email}', '{$password}', 'subscriber' ) ";


		$register_user_query = mysqli_query($connect, $query);
		if(!$register_user_query){
		die("query was not successful" . mysqli_error($connect));
		}
		    $message = "Your Registration has been submitted";
		} else {
		    $message = "Fields cannot be empty";
		}

		} else {
		    $message = "";
	}
}



function favorite_profile(){
global $connect;

if(isset($_GET['favprofile'])){
    $user_username = $_SESSION['username'];
    $favorited_user = $_GET['favprofile'];
    $query = "INSERT INTO favorite_users(username, favorited_user, viewed) VALUES('{$user_username}', '{$favorited_user}', 'no' )";
    $insert_favorite = mysqli_query($connect, $query);
    confirm($insert_favorite);
    header("Location: profile.php?profile=$favorited_user");
	}
}

function unfavorite_profile(){
global $connect;

if(isset($_GET['unfavprofile'])){
    $user_username = $_SESSION['username'];
    $favorited_user = $_GET['unfavprofile'];
    $removefavorite = "DELETE FROM favorite_users WHERE username = '{$user_username}' AND favorited_user = '{$favorited_user}'";
    $remove_favorite = mysqli_query($connect, $removefavorite);
    confirm($remove_favorite);
    header("Location: profile.php?profile=$favorited_user");
	}	
}

function get_recent_user_posts(){
global $connect;

$getpostsquery = "SELECT * FROM Posts WHERE post_user = '{$profilename}' ORDER BY post_id DESC LIMIT $page_1, $per_page";
$all_posts = mysqli_query($connect, $getpostsquery);
confirm($all_posts);

while($row = mysqli_fetch_array($all_posts)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];

    echo "<div>";
    echo "<p>$post_date</p>";
    echo "<a href='post.php?p_id=$post_id'><h4>$post_title</h4></a>";
    if($post_image == "") { } else { 
    echo "<img width='100' src='./images/$post_image'>";
    }
    echo "</div>";
    echo "</br>";
    echo "</br>";
}
}

?>