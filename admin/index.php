<?php include "includes/admin_header.php"; ?>

<div id="wrapper">


    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin

                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    <!-- <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Blank Page
                        </li>
                    </ol> -->
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

                                    <?php
                                    $query = "SELECT * FROM posts";
                                    $select_all_post = mysqli_query($connection, $query);
                                    $post_count = mysqli_num_rows($select_all_post);
                                    echo "<div class='huge'>$post_count</div>";
                                    ?>

                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
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

                                    <?php
                                    $query = "SELECT * FROM comments";
                                    $select_all_comment = mysqli_query($connection, $query);
                                    $comment_count = mysqli_num_rows($select_all_comment);
                                    echo "<div class='huge'>$comment_count</div>";
                                    ?>
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
                                    <?php
                                    $query = "SELECT * FROM users";
                                    $select_all_user = mysqli_query($connection, $query);
                                    $user_count = mysqli_num_rows($select_all_user);
                                    echo "<div class='huge'>$user_count</div>";
                                    ?>
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
                                    <?php
                                    $query = "SELECT * FROM categories";
                                    $select_all_category = mysqli_query($connection, $query);
                                    $category_count = mysqli_num_rows($select_all_category);
                                    echo "<div class='huge'>$category_count</div>";
                                    ?>
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
            $query = "SELECT * FROM posts WHERE post_status = 'published' ";
            $select_all_publish_post = mysqli_query($connection, $query);
            $post_publish_count = mysqli_num_rows($select_all_publish_post);

            $query = "SELECT * FROM posts WHERE post_status = 'draft' ";
            $select_all_draft_post = mysqli_query($connection, $query);
            $post_draft_count = mysqli_num_rows($select_all_draft_post);

            $query = "SELECT * FROM comments WHERE comment_status = 'unapproved' ";
            $select_all_unapprove_comment = mysqli_query($connection, $query);
            $comment_unapprove_count = mysqli_num_rows($select_all_unapprove_comment);

            $query = "SELECT * FROM users WHERE user_role = 'subscriber' ";
            $select_all_user_subscriber = mysqli_query($connection, $query);
            $user_subscriber_count = mysqli_num_rows($select_all_user_subscriber);

            ?>



            <div class="row">
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawStuff);

                    function drawStuff() {
                        var data = new google.visualization.arrayToDataTable([
                            ['Move', 'Percentage'],
                            <?php
                            $element_text = ['All Post', 'Active Post', 'Draft Post', 'Comments', 'Pending Comment', 'Users', 'Subscribers', 'Categories'];
                            $element_count = [$post_count, $post_publish_count, $post_draft_count, $comment_count, $comment_unapprove_count, $user_count, $user_subscriber_count, $category_count];

                            for ($i = 0; $i < 8; $i++) {
                                echo "['{$element_text[$i]}'" . "," . " {$element_count[$i]}],";
                            }

                            ?>

                        ]);

                        var options = {
                            width: 1110,
                            legend: {
                                position: 'none'
                            },
                            chart: {
                                title: '',
                                subtitle: ''
                            },
                            axes: {
                                x: {
                                    0: {
                                        side: 'top',
                                        label: ''
                                    } // Top x-axis.
                                }
                            },
                            bar: {
                                groupWidth: "75%"
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                        // Convert the Classic options to Material options.
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    };
                </script>
                <div id="top_x_div" style="width: 'auto'; height: 300px;"></div>

            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>