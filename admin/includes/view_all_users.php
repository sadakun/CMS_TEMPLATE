<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $usersValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'admin':
                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id={$usersValueId} ";
                $update_to_admin = mysqli_query($connection, $query);
                confirmQuery($update_to_admin);
                break;

            case 'subscriber':
                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id={$usersValueId} ";
                $update_to_subscriber = mysqli_query($connection, $query);
                confirmQuery($update_to_subscriber);
                break;

            case 'delete':
                $query = "DELETE FROM users WHERE user_id={$usersValueId} ";
                $update_delete_post = mysqli_query($connection, $query);
                confirmQuery($update_delete_post);
                break;
        }
    }
}
?>
    <form action="" method="post">
        <table class="table table-bordered table-hover">
            <div id="bulkOptionContainer" class="col-xs-2">
                <select class="form-control" name="bulk_options" id="">
                    <option value="">Select Option</option>
                    <option value="admin">Change to Admin</option>
                    <option value="subscriber">Change to Subscriber</option>
                    <option value="delete">Delete</option>
                </select>
            </div>

            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                <a class="btn btn-primary" href="users.php?source=add_user">Add new</a>
            </div>
            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Change Role</th>
                    <th>Change Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id        = $row['user_id'];
                    $username       = $row['username'];
                    $user_password  = $row['user_password'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname  = $row['user_lastname'];
                    $user_email     = $row['user_email'];
                    $user_image     = $row['user_image'];
                    $user_role      = $row['user_role'];


                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $user_id ?>'></td>
                <?php
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td>{$user_firstname}</td>";
                    echo "<td>{$user_lastname}</td>";
                    echo "<td>{$user_email}</td>";
                    echo "<td>{$user_role}</td>";

                    echo "<td><a href='users.php?change_to_admin={$user_id}'>Change to Admin</a></td>";
                    echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Change to Subscriber</a></td>";
                    echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'><i class='fa fa-edit'>edit</i></a></td>";
                    echo "<td><a rel='$user_id' href='javascript:void(0)' data-toggle='modal' class='delete_link'><i class='fa fa-trash'>delete</i></a></td>";

                    // echo "<td><a onClick=\"javascript: return confirm('Are you sure want to delete this user?'); \" href='users.php?delete={$user_id}'>Delete</a></td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </form>
    <?php
    if (isset($_GET['change_to_admin'])) {
        $get_user_id = escape($_GET['change_to_admin']);
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $get_user_id ";
        $change_to_admin_query = mysqli_query($connection, $query);
        header("Location: users.php");
    }

    if (isset($_GET['change_to_subscriber'])) {
        $get_user_id = escape($_GET['change_to_subscriber']);
        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $get_user_id ";
        $change_to_subscriber_query = mysqli_query($connection, $query);
        header("Location: users.php");
    }

    if (isset($_GET['delete'])) {
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 'admin') {

                $get_user_id = escape($_GET['delete']);
                $query = "DELETE FROM users WHERE user_id = {$get_user_id}";
                $delete_user_query = mysqli_query($connection, $query);
                header("Location: users.php");
            }
        }
    }
    ?>

    <script>
        $(document).ready(function() {
            $(".delete_link").on('click', function() {
                // $(".delete_link").on('click', function() {
                var id = $(this).attr("rel");
                var delete_url = "users.php?delete=" + id + " ";
                // alert(delete_url);

                $(".modal_delete_link").attr("href", delete_url);
                $("#myModal").modal('show');
            });

        });
    </script>