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

            if (isset($_GET['category'])) {
                $post_category_id = $_GET['category'];

                if (isAdmin($_SESSION['username'])) {
                    $first_statement = mysqli_prepare($connection, "SELECT posts.post_id, posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, substr(posts.post_content, 60, 200), users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_category_id = ? ");
                    confirmQuery($first_statement);
                } else {
                    $second_statement = mysqli_prepare($connection, "SELECT posts.post_id, posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, substr(posts.post_content, 60, 200), users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_category_id = ? AND post_status = ? ");
                    confirmQuery($second_statement);
                    $published = 'published';
                }

                if (isset($first_statement)) {
                    mysqli_stmt_bind_param($first_statement, "i", $post_category_id);
                    mysqli_stmt_execute($first_statement);
                    mysqli_stmt_bind_result($first_statement, $post_id, $post_title, $post_user_id, $post_date, $post_image, $post_tag, $post_content, $user_id, $username);
                    mysqli_stmt_store_result($first_statement);
                    $stmt = $first_statement;
                } else {
                    mysqli_stmt_bind_param($second_statement, "is", $post_category_id, $published);
                    mysqli_stmt_execute($second_statement);
                    mysqli_stmt_bind_result($second_statement, $post_id, $post_title, $post_user_id, $post_date, $post_image, $post_tag, $post_content, $user_id, $username);
                    mysqli_stmt_store_result($second_statement);
                    $stmt = $second_statement;
                }

                if (mysqli_stmt_num_rows($stmt) === 0) {
                    echo "<h1 class='text-center'><br><br><br><br> NO POSTS AVAILABLE, <br> Sorry :(</h1>";
                }


                while (mysqli_stmt_fetch($stmt)) :

                    ?>

                    <h1 class="page-header">
                        Learning Vue.js
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="/cms/post/<?php echo $post_id; ?>">
                            <?php echo $post_title; ?>
                        </a>
                    </h2>

                    <p class="lead">
                        by <a href="../author_posts.php?author=<?php echo $post_user_id; ?>&p_id=<?php echo $post_id; ?>">
                            <?php echo $username; ?>
                        </a>
                    </p>

                    <p>
                        <span class="glyphicon glyphicon-time"></span>
                        Posted on <?php echo $post_date; ?>
                    </p>
                    <hr>

                    <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">

                    <p>
                        Tags: <?php echo $post_tag; ?>
                    </p>
                    <hr>

                    <p>
                        <?php echo $post_content; ?>
                    </p>

                    <a class="btn btn-primary" href="../post/<?php echo $post_id; ?>">
                        Read More
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                    <hr>

            <?php endwhile;
                mysqli_stmt_close($stmt);
            } else {
                header("Location: /cms");
            } ?>

            <!-- Pager -->
            <!-- <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul> -->

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>