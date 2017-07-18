<?php session_start();?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">FEED</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">



<?php if(isset($_SESSION['username'])){ 

$current_user = $_SESSION['username'];
?>
               <li>
                <a href="admin">My Admin</a>
                </li> 

                <li>
                <a href="profile.php?profile=<?php echo $current_user?>">My Profile</a>
                </li>
                <li>
                <a href="admin/inbox.php">My Inbox</a>
                </li>

                <li>
                    <a class="" href="includes/logout.php"><i class="fa fa-fw fa-power-off "></i>Log Out</a>
                </li>

                <?php } else { ?>

                    <li>
                <a href="registration.php">Register</a>
            </li>


                    <?php } ?>
           
      




        </ul>
    </div>
    <!-- /.navbar-collapse -->
</div>
<!-- /.container -->
</nav>