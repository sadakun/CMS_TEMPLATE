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
            // untuk mengecek apakah data ada atau tidak
            $post_query_count = " SELECT * FROM posts";
            $find_count = mysqli_query($connection, $post_query_count);
            $counts = mysqli_num_rows($find_count);
            $users = currentUser();
            if ($counts < 1) {
                echo "<h1 class='text-center'><br><br><br><br> NO POSTS AVAILABLE, <br> Sorry :(</h1>";
            } else {

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = " SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_status, posts.post_image, posts.post_tag, posts.post_date, posts.post_content, users.user_id, users.username  FROM posts JOIN users ON posts.post_user_id = users.user_id ORDER BY post_id DESC limit $page_1, $per_page";
                    $data_post = "SELECT * from posts ";
                    $find_count = mysqli_query($connection, $data_post);
                    $count = mysqli_num_rows($find_count);
                } elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'subscriber') {
                    $query = " SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_status, posts.post_image, posts.post_tag, posts.post_date, posts.post_content, users.user_id, users.username  FROM posts JOIN users ON posts.post_user_id = users.user_id WHERE post_user_id = $users ORDER BY post_id DESC limit $page_1, $per_page";
                    $data_post = "SELECT * from posts ";
                    $find_count = mysqli_query($connection, $data_post);
                    $count = mysqli_num_rows($find_count);
                } else {
                    $query = " SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_status, posts.post_image, posts.post_tag, posts.post_date, posts.post_content, users.user_id, users.username  FROM posts JOIN users ON posts.post_user_id = users.user_id where post_status = 'published' ORDER BY post_id DESC limit $page_1, $per_page ";
                    $data_post = "SELECT * from posts where post_status = 'published' ";
                    $find_count = mysqli_query($connection, $data_post);
                    $count = mysqli_num_rows($find_count);
                }
                // Digunakan untuk menentukan banyak halaman dari jumlah data yang ada
                $count = ceil($count / $per_page);

                $select_all_posts_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id        = $row['post_id'];
                    $post_user_id   = $row['post_user_id'];
                    $post_title     = $row['post_title'];
                    $post_status    = $row['post_status'];
                    $post_image     = $row['post_image'];
                    $post_tag       = $row['post_tag'];
                    $post_date      = $row['post_date'];
                    $post_content   = substr($row['post_content'], 60, 200);  // memnuat jumlah karakter content
                    $username       = $row['username'];
                    ?>
                    <h1 class="page-header">
                        Samuel's CMS Site
                        <small>students only</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post/<?php echo $post_id; ?>"> <?php echo $post_title; ?></a>
                    </h2>

                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_user_id; ?>&p_id=<?php echo $post_id; ?>">
                            <?php echo $username; ?>
                        </a>
                    </p>

                    <p>
                        <span class="glyphicon glyphicon-time"></span>
                        Posted on <?php echo $post_date; ?>
                    </p>
                    <hr>

                    <a href="post/<?php echo $post_id ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>

                    <p>
                        Tags: <?php echo $post_tag; ?>
                    </p>
                    <hr>

                    <p>
                        <?php echo $post_content; ?>
                    </p>

                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">
                        Read More
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                    <hr>
            <?php
                }
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