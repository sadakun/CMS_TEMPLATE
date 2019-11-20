<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">Sadakun CMS</a>
        </div>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">


                <li>
                    <a href="/cms">Home</a>
                </li>

                <?php
                $query = "SELECT * FROM categories LIMIT 3";
                $all_categories = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($all_categories)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];

                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $login_class = '';

                    $page_name = basename($_SERVER['PHP_SELF']);
                    $registration = 'registration.php';
                    $contact = 'contact.php';
                    $login = 'login.php';

                    if (isset($_GET['category']) &&  $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } else if ($page_name == $registration) {
                        $registration_class = 'active';
                    } else if ($page_name == $contact) {
                        $contact_class = 'active';
                    } else if ($page_name == $login) {
                        $login_class = 'active';
                    }
                    echo "<li class='$category_class'><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                }
                ?>



                </li>
                <li class="<?php echo $registration_class; ?>">
                    <a href="/cms/registration">Registration</a>
                </li>
                <li class="<?php echo $contact_class; ?>">
                    <a href="/cms/contact">Contact</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>

                <?php
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $get_post_id = $_GET['p_id'];
                        echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$get_post_id}'>Edit Post</a></li>";
                    }
                }
                ?>
                <?php if (isLogin()) : ?>

                    <li>
                        <a href="/cms/admin">Admin</a>
                    </li>

                    <li>
                        <a href="/cms/includes/logout.php">Logout</a>
                    </li>

                <?php else : ?>

                    <li class="<?php echo $login_class; ?>">
                        <a href="/cms/login.php">Login</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>