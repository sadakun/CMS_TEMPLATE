<?php
// Get request user id and database data extraction
if (isset($_GET['edit_user'])) {
    $get_user_id = escape($_GET['edit_user']);

    $query = "SELECT * FROM users WHERE user_id = $get_user_id";
    $select_users_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_users_query)) {
        $user_id        = $row['user_id'];
        $username       = $row['username'];
        $user_password  = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname  = $row['user_lastname'];
        $user_email     = $row['user_email'];
        $user_image     = $row['user_image'];
        $user_role      = $row['user_role'];
    }
    ?>

<?php

    if (isset($_POST['edit_user'])) {
        $user_firstname1 = escape($_POST['user_firstname']);
        $user_lastname1  = escape($_POST['user_lastname']);
        $user_role      = escape($_POST['user_role']);
        $username1       = escape($_POST['username']);
        $user_email     = escape($_POST['user_email']);
        $user_password  = escape($_POST['user_password']);
        $post_date      = date('d-m-y');

        $query_password = "SELECT user_password from users where user_id = '{$get_user_id}'";
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
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username1}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$user_password}' ";
        $query .= "WHERE user_id = {$user_id} ";

        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);
        $_SESSION['username'] = $username1;
        $_SESSION['firstname'] = $user_firstname1;
        $_SESSION['lastname'] = $user_lastname1;
        echo "User Updated:" . " " . "<a href='users.php'>View Users</a>";
    }
} else {
    header("Location: index.php");
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
        <label for="role">Role:</label>
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

    <!-- <div class="class form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->

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