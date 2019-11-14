<?php
global $connection;
if (isset($_POST['create_user'])) {

    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname  = escape($_POST['user_lastname']);
    $user_role      = escape($_POST['user_role']);
    $username       = escape($_POST['username']);
    $user_email     = escape($_POST['user_email']);
    $user_password  = escape($_POST['user_password']);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));     /// NEW WAY ENCRYPT PASSWORD

    $query  = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password)";
    $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}' ) ";

    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);

    echo "User Created:" . " " . "<a href='users.php'>View Users</a>";
}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>


    <div class="form-group">
        <label for="role">Role:</label>
        <select name="user_role" id="">
            <option value="subscriber">Select Option</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>


    <!-- <div class="class form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <a href="users.php" class="btn btn-warning">Back</a>
        <input type="submit" class="btn btn-success" name="create_user" value="Create User">
    </div>

</form>