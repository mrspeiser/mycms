<?php 

	if(isset($_GET['c_id'])){  //fetches pre-fill data
		$the_comment_id = escape($_GET['c_id']);
	}

    $query = "SELECT * FROM comments WHERE comment_id = $the_comment_id";
    $select_comment = mysqli_query($connect, $query);

    while($row = mysqli_fetch_assoc($select_comment)) {
    $comment_id = $row['comment_id'];
    $comment_content = $row['comment_content'];

}

if(isset($_POST['update_comment'])){ //get fields from form and update
	$comment_content = escape($_POST['comment_content']);
	$query = "UPDATE comments SET comment_content = '{$comment_content}' WHERE comment_id = {$the_comment_id} ";


	$update_comment = mysqli_query($connect, $query);
	confirm($update_comment);

	echo "<p class='bg-success'>Comment Updated</p>";

	}
?>
<div class="well">
    <h4>Update Comment:</h4>
    <form action="" method="post" role="form">


        <div class="form-group">
            <label for="comment">Your Comment</label>
            <textarea class="form-control" rows="3" name="comment_content"><?php echo $comment_content; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="update_comment">Submit</button>
    </form>
</div>
<?php


?>

