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
            if (isset($_POST['submit'])) {
                $search = $_POST['search'];

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = "SELECT posts.post_id, posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, posts.post_content, users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_tag LIKE '%$search%' ";
                    $search_query = mysqli_query($connection, $query);
                } else {
                    $query = "SELECT posts.post_id, posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, posts.post_content, users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_tag LIKE '%$search%' AND post_status = 'published'";
                    $search_query = mysqli_query($connection, $query);
                }

                $count = mysqli_num_rows($search_query);
                if ($count == 0) {
                    echo "<h1>No Result</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($search_query)) {
                        $post_id = $row['post_id'];
                        $post_user_id = $row['post_user_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['username'];
                        $post_date = $row['post_date'];
                        $post_tag       = $row['post_tag'];
                        $post_image = $row['post_image'];
                        $post_content   = substr($row['post_content'], 60, 200);

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
                            by <a href="/cms/author_posts.php?author=<?php echo $post_user_id; ?>&p_id=<?php echo $post_id; ?>">
                                <?php echo $post_author; ?>
                            </a>
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

            <?php   }
                }
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>