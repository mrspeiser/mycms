<?php include "includes/admin_header.php" ?>

<?php if(isset($_SESSION['username'])){

    $username = escape($_SESSION['username']);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile_query = mysqli_query($connect, $query);

    while($row = mysqli_fetch_array($select_user_profile_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        $user_quote = $row['user_quote'];
        $user_description = $row['user_description'];
    }

} 

?>

<?php 

if(isset($_POST['edit_user'])){
    
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = $user_role;
    $username = escape($_POST['username']);
    $user_email = escape($_POST['user_email']);
    // $user_password = escape($_POST['user_password']);
    $user_quote = escape($_POST['user_quote']);
    $user_description = escape($_POST['user_description']);
    // $post_date = date('d-m-y');

    // $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );
    

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_image = '{$user_image}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_quote = '{$user_quote}', ";
    $query .= "user_description = '{$user_description}', ";
    $query .= "user_email = '{$user_email}' ";
    // $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE username = '{$username}' ";


    $update_user = mysqli_query($connect, $query);
    confirm($update_user);

}


if(isset($_POST['update_image'])){
    
    $user_image = escape($_FILES['image']['name']);
    $user_image_temp = escape($_FILES['image']['tmp_name']);
    move_uploaded_file($user_image_temp, "../images/$user_image");
    $query = "UPDATE users SET user_image = '{$user_image}' WHERE username = '{$username}' ";
    $update_image = mysqli_query($connect, $query);
    confirm($update_image);

}

if(isset($_POST['update_password'])){

$user_password = escape($_POST['user_password']);
    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

$query = "UPDATE users SET user_password = '{$hashed_password}' WHERE user_id = $user_id ";
$update_password = mysqli_query($connect, $query);
    confirm($update_password);

    
}


?>

<div id="wrapper">




    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
    Edit My Profile
    <small></small>
    </h1>

<form action="profile.php" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="profilepic">Profile Picture</label>
        <div><img width='250' src='../images/<?php echo $user_image;?>'></div>
        <input type="file" class="btn" name="image" value="<?php echo $user_image; ?>">
        <input type="submit" class="btn btn-primary" name="update_image" value="Update Image">
    </div>

</form>


<form action="profile.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="author">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>  

    <div class="form-group">
        <label for="post_status">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">
    </div>  
 


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
        <label for="post_tags">My Description</label>  

    </div>  
        <textarea class="form-control" name="user_description" rows="5"><?php echo $user_description; ?></textarea>

    <input style="margin-top: 15px;" type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">

</form>

<form method="POST" action="profile.php">
    
    <div style="margin-top: 40px;" class="form-group">
        <label for="post_content">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div> 
    <input type="submit" class="btn btn-primary" name="update_password" value="Update Password"> 
</form>





    </div>
    </div>
    <!-- /.row -->

    </div>
<!-- /.container-fluid -->

</div>


<?php include "includes/admin_footer.php" ?>