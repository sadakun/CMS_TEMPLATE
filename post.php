<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php
if (isset($_POST['liked'])) {

    $post_id = $_POST['like_post_id'];
    $user_id = $_POST['like_user_id'];

    // 1 =  FETCHING - THE RIGHT POST
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    // 2 = UPDATE - INCREMENT WITH LIKES
    mysqli_query($connection, "UPDATE posts SET likes = $likes+1 WHERE post_id = $post_id");

    // 3 = CREATE - LIKE FOR POST 
    mysqli_query($connection, "INSERT INTO likes(like_user_id, like_post_id) VALUES($user_id,$post_id)");
    exit();
}

if (isset($_POST['unliked'])) {

    $post_id = $_POST['like_post_id'];
    $user_id = $_POST['like_user_id'];

    // 1 =  FETCHING - THE RIGHT POST
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    // 3 = DELETE LIKE FOR POST 
    mysqli_query($connection, "DELETE FROM likes WHERE like_user_id=$user_id AND like_post_id=$post_id");

    // 2 = UPDATE - DECREMENT WITH LIKES
    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
    exit();
}
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php

            if (isset($_GET['p_id'])) {
                $get_post_id = $_GET['p_id'];

                $update_statement = mysqli_prepare($connection, "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = ?");

                mysqli_stmt_bind_param($update_statement, "i", $get_post_id);

                mysqli_stmt_execute($update_statement);
                // mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                confirmQuery($update_statement);

                if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {

                    $stmtAdmin = mysqli_prepare($connection, "SELECT posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, posts.post_content, users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_id = ?");
                } elseif (isset($_SESSION['username'])) {

                    $stmtSubscriber = mysqli_prepare($connection, "SELECT posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, posts.post_content, users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_id = ? AND post_user_id = ?");
                    $users = $_SESSION['user_id'];
                } else {

                    $stmtNonUser = mysqli_prepare($connection, "SELECT posts.post_title, posts.post_user_id, posts.post_date, posts.post_image, posts.post_tag, posts.post_content, users.user_id, users.username FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_id = ? AND post_status = ? ");
                    $published = 'published';
                }



                if (isset($stmtAdmin)) {
                    mysqli_stmt_bind_param($stmtAdmin, "i", $get_post_id);

                    mysqli_stmt_execute($stmtAdmin);

                    mysqli_stmt_bind_result($stmtAdmin, $post_title, $post_user_id, $post_date, $post_image, $post_tag, $post_content, $user_id, $username);

                    mysqli_stmt_store_result($stmtAdmin);

                    $stmt = $stmtAdmin;
                } elseif (isset($stmtSubscriber)) {

                    mysqli_stmt_bind_param($stmtSubscriber, "ii", $get_post_id, $users);

                    mysqli_stmt_execute($stmtSubscriber);

                    mysqli_stmt_bind_result($stmtSubscriber, $post_title, $post_user_id, $post_date, $post_image, $post_tag, $post_content, $user_id, $username);

                    mysqli_stmt_store_result($stmtSubscriber);

                    $stmt = $stmtSubscriber;
                } else {

                    mysqli_stmt_bind_param($stmtNonUser, "is", $get_post_id, $published);

                    mysqli_stmt_execute($stmtNonUser);

                    mysqli_stmt_bind_result($stmtNonUser, $post_title, $post_user_id, $post_date, $post_image, $post_tag, $post_content, $user_id, $username);

                    mysqli_stmt_store_result($stmtNonUser);

                    $stmt = $stmtNonUser;
                }




                while (mysqli_stmt_fetch($stmt)) {

                    // $post_comment_count = $row['post_comment_count'];
                    // $post_status = $row['post_status'];
                    ?>


                    <h1 class="page-header">
                        Samuel's CMS Site
                        <small>students only</small>
                    </h1>
                    <!-- First Blog Post -->
                    <h2>
                        <a href="../index"> <?php echo $post_title; ?></a>
                    </h2>

                    <p class="lead">
                        by <a href="/cms/author_posts.php?author=<?php echo $post_user_id; ?>&p_id=<?php echo $get_post_id; ?>">
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
                    <hr>

                    <!-- FREEING Result -->
                    <?php

                            mysqli_stmt_free_result($stmt);

                            ?>
                    <?php
                            if (isLogin()) { ?>
                        <div class="row">
                            <p class="pull-right">
                                <a class="<?php echo userLikeThisPost($get_post_id) ? 'unlike' : 'like'; ?>" href="">
                                    <span class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" title="<?php echo userLikeThisPost($get_post_id) ? ' I liked it before' : ' Want to like it?'; ?>"></span>
                                    <?php echo userLikeThisPost($get_post_id) ? ' Unlike' : ' Like'; ?>
                                </a>
                            </p>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <p class="pull-right login-to-post">

                                <a href="/cms/login.php">Login</a> to <span class="glyphicon glyphicon-thumbs-up"></span> like
                            </p>
                        </div>
                    <?php }
                            ?>


                    <div class="row">
                        <p class="pull-right likes">
                            Like: <?php getPostlikes($get_post_id); ?>
                        </p>
                    </div>

                    <div class="clearfix"></div>
                    <br><br>

                <?php

                    }
                    ?>

                <?php
                    // blog comment
                    if (isset($_POST['create_comment'])) {
                        $get_post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES ($get_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";
                            $create_comment_query = mysqli_query($connection, $query);

                            confirmQuery($create_comment_query);
                        } else {
                            echo "<script>alert('Field cannot be empty')</script>";
                        }
                    }
                    ######################  Blog Comments  ########################
                    // createComment();
                    ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="#" method="post" role="form">

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
            } else {
                redirect('index');
                // header("Location: index.php");
            } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>

    <script>
        $(document).ready(function() {
            $("[data-toggle='tooltip']").tooltip();
            var post_id = <?php echo $get_post_id; ?>;
            var user_id = <?php echo loginUserId(); ?>;

            // Likes
            $('.like').click(function() {
                $.ajax({
                    url: "/cms/post.php?p_id=<?php echo $get_post_id; ?>",
                    type: 'post',
                    data: {
                        'liked': 1,
                        'like_post_id': post_id,
                        'like_user_id': user_id

                    }
                });
            });

            // unLikes
            $('.unlike').click(function() {
                $.ajax({
                    url: "/cms/post.php?p_id=<?php echo $get_post_id; ?>",
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'like_post_id': post_id,
                        'like_user_id': user_id

                    }
                });
            });
        });
    </script>