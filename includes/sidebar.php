<?php
if (ifItIsMethod('post')) {


    if (isset($_POST['login'])) {


        if (isset($_POST['username']) && isset($_POST['password'])) {

            loginUser($_POST['username'], $_POST['password']);
        } else {
            redirect('index');
        }
    }
}

?>

<!-- Blog sidebar widget coloumn-->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <!-- search form -->
        <form action="/cms/search.php" method="post">

            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login Form -->
    <div class="well">
        <?php if (isset($_SESSION['user_role'])) : ?>
            <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>

            <a href="/cms/includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else : ?>
            <h4>Login</h4>
            <!-- search form -->
            <form method="post">

                <div class="form-group">
                    <input autocomplete="off" name="username" type="text" class="form-control" placeholder="Enter Username">
                    <span class="input-group-btn">
                    </span>
                </div>

                <div class="input-group">
                    <input autocomplete="off" name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
                <div class="form-group">
                    <a href="/cms/forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                </div>
            </form>
        <?php endif; ?>
        <!-- /.input-group -->
    </div>


    <!-- Blog Categories Well -->
    <div class="well">

        <?php
        $query = "SELECT * FROM categories";
        $select_categories_sidebar = mysqli_query($connection, $query);
        ?>

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>

                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>