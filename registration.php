<?php include "includes/header.php"; ?>

<?php require './vendor/autoload.php';

// SETTING LANGUAGES
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload();</script>";
    }
}
if (isset($_SESSION['lang'])) {
    include "includes/languages/" . $_SESSION['lang'] . ".php";
} else {
    include "includes/languages/en.php";
}


// PUSHER
$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
);
// setting up pusher credential Apps
$pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);    //('key', 'secret', 'app_id', 'cluster');

?>
<?php
// AUTHENTICATION
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);
    $email      = trim($_POST['email']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''

    ];

    if (strlen($username) < 4) {
        $error['username'] = 'At least 4 character of letter or number!';
    }

    if (strlen($username) == '') {
        $error['username'] = 'Username cannot be empty!!';
    }

    if (usernameExist($username)) {
        $error['username'] = 'Username already exist, use another username.';
    }

    if (strlen($email) == '') {
        $error['email'] = 'Email cannot be empty!!';
    }

    if (emailExist($email)) {
        $error['email'] = 'Email has been used, choose another email or try to <a href="index.php">Login</a>';
    }
    if (strlen($password) == '') {
        $error['password'] = 'Password cannot be empty!!';
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
            // login_user($username, $email, $password);
        }
    }
    if (empty($error)) {
        registerUser($username, $email, $password);
        $data['message'] = $username;
        $pusher->trigger('notifications', 'new_user', $data);
        loginUser($username, $password);
    }
}
?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <form method="get" action="" id="language_form" class="navbar-form navbar-right">
        <div class="form-group">
            <select name="lang" onchange="changeLanguage()" class="form-control">
                <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
                                        echo "selected";
                                    } ?>>English</option>
                <option value="id" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'id') {
                                        echo "selected";
                                    } ?>>Bahasa Indonesia</option>
            </select>
        </div>
    </form>

    <section id="login">
        <div class="container">
            <div class="position-relative col-sm-12  col-xs-mobile-fullwidth text-center margin-ten-bottom">
                <div class="wpd-innner-wrapper">
                    <h1><?php echo _REGISTER; ?></h1>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <form role="form" action="/cms/registration.php" method="post" id="login-form" autocomplete="off">

                            <!-- <div class="form-group">
                                <label for="username">Firstname</label>
                                <input type="text" name="user_firstname" id="" class="form-control" placeholder="Enter Your Firstname">
                            </div>
                            <div class="form-group">
                                <label for="username">Lastname</label>
                                <input type="text" name="user_lastname" id="" class="form-control" placeholder="Enter Your Lastname">
                            </div> -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                                <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <!-- <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div> -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
                                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                                <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                            </div>

                            <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="<?php echo _REGISTER; ?>">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
            <br>
            <br>
            <br>
        </div> <!-- /.container -->
        <hr>
    </section>

    <script>
        function changeLanguage() {
            document.getElementById('language_form').submit();
        }
    </script>

    <?php include "includes/footer.php"; ?>