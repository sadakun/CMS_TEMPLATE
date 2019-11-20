<?php

function redirect($location)
{
    header("Location: " . $location);
    exit;
}
##########################################################################################
function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}
##########################################################################################
//----------------------------------------------------------------------------
function ifItIsMethod($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function checkIfUserIsLoginAndRedirect($redirectLocation = null)
{
    if (isLogin()) {
        redirect($redirectLocation);
    }
}

function isLogin()
{
    if (isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

function confirmQuery($result)
{
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
    return $result;
}
##########################################################################################
//----------------------------------------------------------------------------
function createComment()
{
    global $connection;
    if (isset($_POST['create_comment'])) {
        $get_post_id = $_GET['p_id'];
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);

        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
            $query .= "VALUES ($get_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";
            $create_comment_query = mysqli_query($connection, $query);

            if (!$create_comment_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
        } else {
            echo "<script>alert('Field cannot be empty')</script>";
        }
    }
}
###############################   CRUD CATEGORIES   #########################
//--------------------------------Insert Query-----------------------------//
function insertCategories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $statement = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUE(?) ");
            mysqli_stmt_bind_param($statement, 's', $cat_title);
            mysqli_stmt_execute($statement);


            if (!$statement) {
                die("Query Failed" . mysqli_error($connection));
            }
        }
        mysqli_stmt_close($statement);
    }
}
##########################################################################################
//---------------------------------Search Query------------------------------//
function findAllCategories()
{
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "</tr>";
    }
}
##########################################################################################
//----------------------------------Delete Query-----------------------------------------
function deleteCategories()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $get_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$get_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}
##########################################################################################
//----------------------------------Dashboard Count Data-------------------------------
function recordCount($table)
{
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_all_post = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_all_post);
    confirmQuery($result);
    return $result;
}
##########################################################################################
//---------------------------------------------------------------------------------------
function approve()
{
    global $connection;
    if (isset($_GET['approve'])) {
        $get_comment_id = escape($_GET['approve']);
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $get_comment_id ";
        $approve_comment_query = mysqli_query($connection, $query);
        header("Location: post_comments.php?id=" . $_GET['id'] . "");
    }
}
//---------------------------------------------------------------------------------------
function unApprove()
{
    global $connection;
    if (isset($_GET['unapprove'])) {
        $get_comment_id = escape($_GET['unapprove']);
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $get_comment_id ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: post_comments.php?id=" . $_GET['id'] . "");
    }
}
##########################################################################################
//----------------------------------------------------------------------------
function deleteComment()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $get_comment_id = escape($_GET['delete']);
        $query = "DELETE FROM comments WHERE comment_id = {$get_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: post_comments.php?id=" . $_GET['id'] . "");
    }
}
##########################################################################################
function userOnline()
{

    if (isset($_GET['onlineusers'])) {
        global $connection;
        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 30;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}
userOnline();
##########################################################################################
//----------------------------------------------------------------------------
function checkStatus($table, $column, $status)
{
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);

    return mysqli_num_rows($result);
}
##########################################################################################
function isAdmin($username)
{
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}
##########################################################################################
function usernameExist($username)
{
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
##########################################################################################
function emailExist($email)
{
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
##########################################################################################
function registerUser($username, $email, $password)
{
    global $connection;

    $username =  mysqli_escape_string($connection, $username);
    $password =  mysqli_escape_string($connection, $password);
    $email    =  mysqli_escape_string($connection, $email);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));     /// NEW WAY ENCRYPT PASSWORD

    $query = "INSERT INTO users(username, user_email,  user_password, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber' ) ";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);
}
##########################################################################################
function loginUser($username, $password)
{
    global $connection;
    $username = trim($username);
    $password = trim($password);

    $username = mysqli_escape_string($connection, $username);
    $password = mysqli_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    confirmQuery($select_user_query);


    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];


        if (password_verify($password, $db_user_password)) {

            $_SESSION['username']   = $db_username;
            $_SESSION['firstname']  = $db_user_firstname;
            $_SESSION['lastname']   = $db_user_lastname;
            $_SESSION['user_role']  = $db_user_role;

            redirect("/cms/admin");
        } else {

            return false;
        }
    }

    return true;
}

######################--old encrypt password--##########################
// $password = crypt($password, $db_user_password);

// if ($username !== $db_username && $password !== $db_user_password) {
//     header("Location: ../index.php");
// } else if ($username == $db_username && $password == $db_user_password) {
########################################################################
