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
    Comments
    <small></small>
    </h1>

<?php 

if(isset($_GET['source'])){
    $source = escape($_GET['source']);
} else {
    $source = '';
}

switch($source){
    case 'my_comments';
    include "includes/my_comments.php";
    echo "NICE";
    break;
    case 'edit_comment';
    include "includes/edit_comment.php";
    echo "NICE";
    break;

    default:
    include "includes/view_all_comments.php";


}
?>



    </div>
    </div>
    <!-- /.row -->

    </div>
<!-- /.container-fluid -->

</div>


<?php include "includes/admin_footer.php" ?>