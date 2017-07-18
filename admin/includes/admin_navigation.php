<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="">Users Online: <span class="usersonline"></span></a></li>
        <!-- <li><a href="">Users Online: <?php //echo users_online(); ?> </a></li> -->
        <li><a href="../index.php">Home Site</a></li>


<?php if(isset($_SESSION['username'])){
$current_user = $_SESSION['username'];
} ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="../profile.php?profile=<?php echo $current_user?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="inbox.php"><i class="fa fa-fw fa-user"></i> Inbox</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                </li>
            </ul>
        </li>
    </ul>



    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php
    $username = $_SESSION['username'];
     $query = "SELECT * FROM comments WHERE post_author = '{$username}' AND viewed = 'no' ";
        
        $result = mysqli_query($connect, $query);
        $notifications = mysqli_num_rows($result);
    ?>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <!-- <li>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li> -->
            <li>
                <a href="notifications.php"><i class="fa fa-fw fa-dashboard"></i> Notifications</a>
            </li>
           
           
           
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="./posts.php">View All</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=starred_posts">Starred Posts</a>
                    </li>
                </ul>
            </li>

                        <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#comments_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Comments <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="comments_dropdown" class="collapse">
                    <li class="">
                <a href="./comments.php"><span style="color: red;"><?php echo $notifications; ?></span><i class="fa fa-fw fa-file"></i>Post Comments</a>
                    </li>

                    <li>
                        <a href="comments.php?source=my_comments"><i class="fa fa-fw fa-file"></i>My Comments</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="./favorite_users.php"><i class="fa fa-fw fa-wrench"></i>Favorite Users</a>
            </li>
            <?php if($_SESSION['user_role'] == 'subscriber'){


                } else { ?>

            <li>
                <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i>Categories</a>
            </li>

            <?php } ?>
            <li>
                <a href="./my_categories.php"><i class="fa fa-fw fa-wrench"></i>My Categories</a>
            </li>







            
            

            <?php if($_SESSION['user_role'] == 'subscriber'){


                } else { ?>

                    <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="users.php">View All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>


                <?php } ?>

            



            <li>
                <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i>Profile Settings</a>
            </li>
        </ul>
    </div>


    <!-- /.navbar-collapse -->
</nav>