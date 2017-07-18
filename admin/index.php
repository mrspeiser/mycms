<?php include "includes/admin_header.php" ?>

    <div id="wrapper">


    <?php

    ?>

      <!-- <?php if($connect) echo "it is connected"; ?>   -->


        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <h1 class="page-header">
                            My Dashboard

                            <small>Signed in As: <?php echo $_SESSION['username']; ?></small>
                            
                        </h1>
                       
                    </div>
                      <div class="col-lg-12">

                      <?php if(isset($_POST['updatestatus'])){
                        $user_status = escape($_POST['status']);
                        $username = $_SESSION['username'];
                        $query = "UPDATE users SET user_status = '{$user_status}' WHERE username = '{$username}' ";
                        $update_status = mysqli_query($connect, $query);
                        if(!$update_status){
                              die('Query Failed' .mysqli_error($connect));
                          }
                        } 


                        $get_status_query = "SELECT user_status FROM users WHERE username = '{$username}' ";
                        $get_status = mysqli_query($connect, $get_status_query);
                        if(!$get_status){
                              die('Query Failed' .mysqli_error($connect));
                          }
                        while($row = mysqli_fetch_assoc($get_status)){
                          $status = $row['user_status'];
                        }
                        ?>

                        <form style="margin-bottom: 30px;" method="POST" action="index.php">
                        <h2 class="">Status: </h2>
                        <input class="form-control" type="text" name="status" value="<?php echo $status; ?>">
                        <input style="margin-top: 10px;" class="btn btn-primary" type="submit" name="updatestatus" value="Update">
                      </form>

                      </div>
                </div>
                <!-- /.row -->
       
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'>

                  <?php
                  $username = $_SESSION['username']; 
                  if($_SESSION['user_role'] == 'subscriber'){
                    $query = "SELECT * FROM posts WHERE post_user = '$username'"; 
                  } else {
                    $query = "SELECT * FROM posts"; 
                  }
                  $select_all_posts = mysqli_query($connect, $query);
                  $post_counts = mysqli_num_rows($select_all_posts);
                  echo "<div class='huge'>{$post_counts}</div>"
                  ?>

                  </div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="./posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'>
                     <?php 
                     $username = $_SESSION['username']; 
                      if($_SESSION['user_role'] == 'subscriber'){
                        $query = "SELECT * FROM comments WHERE comment_author = '$username'"; 
                      } else {
                        $query = "SELECT * FROM comments";
                      }
                      $select_all_comments = mysqli_query($connect, $query);
                      $comments_counts = mysqli_num_rows($select_all_comments);
                      echo "<div class='huge'>{$comments_counts}</div>"
                      ?>




                     </div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'>

                    <?php 
                      $username = $_SESSION['username']; 
                      if($_SESSION['user_role'] == 'subscriber'){
                        $query = "SELECT * FROM favorite_users WHERE username = '$username'"; 
                      } else {
                        $query = "SELECT * FROM users";
                      }
                      $select_all_users = mysqli_query($connect, $query);
                      $users_counts = mysqli_num_rows($select_all_users);
                      echo "<div class='huge'>{$users_counts}</div>"
                      ?>


                    </div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class='huge'>

                        <?php 
                          $username = $_SESSION['username']; 
                          if($_SESSION['user_role'] == 'subscriber'){
                            $query = "SELECT * FROM favorite_cat WHERE username = '$username'"; 
                          } else {
                            $query = "SELECT * FROM categories";
                          }

                          
                          $select_all_categories = mysqli_query($connect, $query);
                          $categories_counts = mysqli_num_rows($select_all_categories);
                          echo "<div class='huge'>{$categories_counts}</div>"
                          ?>


                        </div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->


            <?php 

        $query = "SELECT * FROM Posts WHERE post_status = 'published' ";
        $select_all_published_posts = mysqli_query($connect, $query);
        $post_published_count = mysqli_num_rows($select_all_published_posts);

        $query = "SELECT * FROM Posts WHERE post_status = 'draft' ";
        $select_all_draft_posts = mysqli_query($connect, $query);
        $post_draft_count = mysqli_num_rows($select_all_draft_posts);
        
        $query = "SELECT * FROM comments WHERE post_author = '$username'";
        $select_post_comments = mysqli_query($connect, $query);
        $post_comment_count = mysqli_num_rows($select_post_comments);
        
        $query = "SELECT * FROM favorite_users WHERE favorited_user = '$username'";
        $select_all_subscribers = mysqli_query($connect, $query);
        $subscriber_count = mysqli_num_rows($select_all_subscribers);

        $query = "SELECT * FROM starred_comments WHERE comment_author = '$username'";
        $select_all_comment_stars = mysqli_query($connect, $query);
        $starred_comments_count = mysqli_num_rows($select_all_comment_stars);

        $query = "SELECT * FROM favorite_posts WHERE post_author = '$username'";
        $select_all_post_stars = mysqli_query($connect, $query);
        $starred_posts_count = mysqli_num_rows($select_all_post_stars);





            ?>

<div class="row">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

          <?php 

          $element_text = ['Posts Created', 'Draft Posts', 'My Comments', 'Post Comments', 'Comment Stars', 'Profile Stars', 'Post Stars'];
          $element_count = [$post_counts, $post_draft_count, $comments_counts, $post_comment_count, $starred_comments_count, $subscriber_count, $starred_posts_count];
          for($i=0; $i<7; $i++){
            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
          }

          ?>

          // ['Posts', 1000]
          
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        

<?php include "includes/admin_footer.php" ?>