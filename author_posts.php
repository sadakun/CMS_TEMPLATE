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
            }

            $query = "SELECT * FROM posts WHERE post_user = '{$get_post_author}' && post_status = 'published' ORDER BY post_id DESC";
            $all_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($all_posts)) {
                $post_title = $row['post_title'];
                $post_author = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                // $post_tag = $row['post_tag'];
                // $post_comment_count = $row['post_comment_count'];
                // $post_status = $row['post_status'];
                ?>



                <h1 class="page-header">
                    Samuel's CMS Site
                    <small>students only</small>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?></a>
                </h2>

                <p class="lead">
                    All post by <?php echo $post_author; ?>
                </p>

                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>


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