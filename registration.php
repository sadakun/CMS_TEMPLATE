<?php include "includes/header.php"; ?>


<?php
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
        loginUser($username, $password);
    }
}
?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="position-relative col-sm-12  col-xs-mobile-fullwidth text-center margin-ten-bottom">
                <div class="wpd-innner-wrapper">
                    <h1>Register</h1><img class="wow fadeInUp" src="https://goldencupseafood.com/assets/images/separator.png" width="300" height="20">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

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
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                                <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <!-- <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div> -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
                                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                            </div>

                            <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>