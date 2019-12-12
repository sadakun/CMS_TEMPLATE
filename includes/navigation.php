<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/cms">Sadakun CMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="/cms" class="nav-link">Home</a>
                </li>

                <li class="nav-item">
                    <a href="/cms/about" class="nav-link">About</a>
                </li>

                <li class="nav-item <?php echo $contact_class; ?>">
                    <a href="/cms/contact" class="nav-link">Contact</a>
                </li>

                <li class="nav-item <?php echo $registration_class; ?>">
                    <a href="/cms/registration" class="nav-link">Registration</a>
                </li>
                <?php
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $get_post_id = $_GET['p_id'];
                        echo "<li class='nav-item'>
                                <a href='/cms/admin/posts.php?source=edit_post&p_id={$get_post_id}' class='nav-link'>Edit Post</a>
                              </li>";
                    }
                }
                ?>
                <?php if (isLogin()) : ?>

                    <li class="nav-item">
                        <a href="/cms/admin" class="nav-link">Admin</a>
                    </li>

                    <li class="nav-item">
                        <a href="/cms/includes/logout.php" class="nav-link">Logout</a>
                    </li>

                <?php else : ?>

                    <li class="nav-item <?php echo $login_class; ?>">
                        <a href="/cms/login.php" class="nav-link">Login</a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>