<?php include "includes/db.php"; ?>
<?php include "admin/functions.php"; ?>

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
                $get_post_id = $_GET['p_id'];

                $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $get_post_id";
                $send_query = mysqli_query($connection, $view_query);
                confirmQuery($send_query);

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = "SELECT * FROM posts WHERE post_id = $get_post_id ";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $get_post_id AND post_status = 'published' ";
                }

                // $query = "SELECT * FROM posts WHERE post_id = $get_post_id ";
                $all_posts = mysqli_query($connection, $query);
                if (mysqli_num_rows($all_posts) < 1) {
                    echo "<h1 class='text-center'><br><br><br><br> NO POSTS AVAILABLE, <br> Sorry :(</h1>";
                } else {



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
                            by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                        </p>

                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <hr>
                    <?php }
                            ######################  Blog Comments  ########################
                            createComment();
                            ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="post" role="form">

                            <div class="form-group">
                                <label for="Author">Author</label>
                                <input type="text" class="form-control" name="comment_author">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" name="comment_email">
                            </div>
                            <div class="form-group">
                                <label for="Comment">Your Comment</label>
                                <textarea name="comment_content" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->

                    <?php

                            $query = "SELECT * FROM comments WHERE comment_post_id = {$get_post_id}";
                            $query .= " AND comment_status = 'approved' ";
                            $query .= "ORDER BY comment_id DESC ";
                            $select_comment_query = mysqli_query($connection, $query);
                            if (!$select_comment_query) {
                                die("QUERY FAILED" . mysqli_error($connection));
                            }
                            while ($row = mysqli_fetch_array($select_comment_query)) {
                                $comment_date = $row['comment_date'];
                                $comment_content = $row['comment_content'];
                                $comment_author = $row['comment_author'];
                                ?>

                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

            <?php }
                }
            } else {
                header("Location: index.php");
            } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>