<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php

            if (isset($_GET['p_id'])) {
                $get_post_id = escape($_GET['p_id']);
                $get_post_author = escape($_GET['author']);


                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = "SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_image, posts.post_date, posts.post_tag, posts.post_content, users.user_id, users.username  FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_user_id = '{$get_post_author}' ";
                    $all_posts = mysqli_query($connection, $query);
                } else {
                    $query = "SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_image, posts.post_date, posts.post_tag, posts.post_content, users.user_id, users.username  FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_user_id = '{$get_post_author}' AND post_status = 'published'";
                    $all_posts = mysqli_query($connection, $query);
                }
            }

            while ($row = mysqli_fetch_assoc($all_posts)) {
                $post_id = $row['post_id'];
                $post_user_id = $row['post_user_id'];
                $post_title = $row['post_title'];
                $post_image = $row['post_image'];
                $post_date = $row['post_date'];
                $post_tag = $row['post_tag'];
                $post_content   = substr($row['post_content'], 60, 200);
                $post_author = $row['username'];

                // $post_comment_count = $row['post_comment_count'];
                // $post_status = $row['post_status'];
                ?>



                <h1 class="page-header">
                    Samuel's CMS Site
                    <small>students only</small>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post/<?php echo $post_id; ?>">
                        <?php echo $post_title; ?>
                    </a>
                </h2>

                <p class="lead">
                    All post by <?php echo $post_author; ?>
                </p>

                <p>
                    <span class="glyphicon glyphicon-time"></span>
                    Posted on <?php echo $post_date; ?>
                </p>
                <hr>

                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">

                <p>
                    Tags: <?php echo $post_tag; ?>
                </p>
                <hr>

                <p>
                    <?php echo $post_content; ?>
                </p>

                <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">
                    Read More
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

                <hr>
            <?php } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>