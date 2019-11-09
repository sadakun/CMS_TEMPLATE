<?php include "includes/db.php"; ?>

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
            $per_page = 2;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }

            $post_query_count = "SELECT * FROM posts ";
            $find_count = mysqli_query($connection, $post_query_count);
            $count = mysqli_num_rows($find_count);

            $count = ceil($count / $per_page);


            $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, $per_page";
            $all_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($all_posts)) {
                $post_id        = $row['post_id'];
                $post_title     = $row['post_title'];
                $post_author    = $row['post_user'];
                $post_date      = $row['post_date'];
                $post_image     = $row['post_image'];
                $post_content   = substr($row['post_content'], 0, 100);
                $post_status    = $row['post_status'];
                $post_tag       = $row['post_tag'];

                if ($post_status !== 'published') {
                    echo "<h1 class='text-center'> NO POST </h1>";
                } else {
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

                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>

                    <p><?php echo $post_tag; ?></p>
                    <hr>

                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
            <?php }
            } ?>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>
    <ul class="pager">
        <?php
        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }
        ?>
    </ul>

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>