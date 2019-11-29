<?php include "includes/admin_header.php"; ?>
<?php

$post_count                 = countRecords(adminGetAllUserPosts());

$comment_count              = countRecords(adminGetAllPostUserComments());

$user_count                 = countRecords(adminGetAllUser());

$category_count             = countRecords(adminGetAllUserCategories());

$post_published_count       = countRecords(adminGetAllUserPublishPosts());

$post_draft_count           = countRecords(adminGetAllUserDraftPosts());

$approved_comment_count     = countRecords(adminGetAllUserApprovedPostsComments());

$unapproved_comment_count   = countRecords(adminGetAllUserUnapprovedPostsComments());

?>
<div id="wrapper">


    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo strtoupper(getGeneralUserName()); ?>
                        DASHBOARD
                        <small><br>(Admin)</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Blank Page
                        </li>
                    </ol>
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
                                    <?php echo "<div class='huge'>" . $post_count . "</div> " ?>
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

                                    <?php echo "<div class='huge'>{$comment_count}</div> " ?>
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
                                    <?php echo "<div class='huge'>" . $user_count . "</div> " ?>
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
                                    <?php echo "<div class='huge'>{$category_count}</div> " ?>
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
                            $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Users', 'Comments', 'Approved Comments', 'Pending Comments', 'Categories'];
                            $element_count = [$post_count, $post_published_count, $post_draft_count, $user_count, $comment_count, $approved_comment_count, $unapproved_comment_count, $category_count];

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

    <script>
        $(document).ready(function() {
            var pusher = new Pusher('2b7f8377af9a3ab7071f', {
                cluster: 'ap1',
                forceTLS: true
            });
            var notificationChannel = pusher.subscribe('notifications');

            notificationChannel.bind('new_user', function(notification) {

                var message = notification.message;

                toastr.success(`${message} just registered`);
                // console.log(message);
            });
        });
    </script>