<?php include "includes/admin_header.php"; ?>


<div id="wrapper">
    <?php include "includes/admin_navigation.php"; ?>
    <!-- Navigation -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    <?php
                    if (isset($_SESSION['username'])) {
                        $get_user_name = $_SESSION['username'];
                        $get_firstname = $_SESSION['firstname'];
                        $get_lastname = $_SESSION['lastname'];

                        $query = "SELECT * FROM users WHERE username = '{$get_user_name}' ";
                        $select_user_profile_query = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($select_user_profile_query)) {
                            $user_id        = $row['user_id'];
                            $username       = $row['username'];
                            $user_password  = $row['user_password'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname  = $row['user_lastname'];
                            $user_email     = $row['user_email'];
                            $user_image     = $row['user_image'];
                        }

                        ?>

                    <?php
                        if (isset($_POST['edit_user'])) {
                            $user_firstname1 = escape($_POST['user_firstname']);
                            $user_lastname1  = escape($_POST['user_lastname']);
                            $username1       = escape($_POST['username']);
                            $user_email     = escape($_POST['user_email']);
                            $user_password  = escape($_POST['user_password']);

                            $query_password = "SELECT user_password from users where username = '{$get_user_name}'";
                            $get_user_query = mysqli_query($connection, $query_password);
                            confirmQuery($get_user_query);

                            $row = mysqli_fetch_array($get_user_query);
                            $db_user_password = $row['user_password'];


                            if (!empty($user_password)) {
                                if ($db_user_password != $user_password) {
                                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
                                    $user_password = $hashed_password;
                                }
                            } else {
                                $db = $db_user_password;
                                $hashed_password = password_hash($db, PASSWORD_BCRYPT, array('cost' => 12));
                                $user_password = $db_user_password;
                            }
                            $query  = "UPDATE users SET ";
                            $query .= "user_firstname = '{$user_firstname1}', ";
                            $query .= "user_lastname = '{$user_lastname1}', ";

                            $query .= "username = '{$username1}', ";
                            $query .= "user_email = '{$user_email}', ";
                            $query .= "user_password = '{$user_password}' ";
                            $query .= "WHERE username = '{$username}' ";

                            $edit_user_query = mysqli_query($connection, $query);
                            confirmQuery($edit_user_query);
                            echo "User Updated:" . " " . "<a href='users.php'>View Users</a>";
                            $_SESSION['username'] = $username1;
                            $_SESSION['firstname'] = $user_firstname1;
                            $_SESSION['lastname'] = $user_lastname1;
                        }
                    }

                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input autocomplete="off" type="password" class="form-control" name="user_password">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>