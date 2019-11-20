<?php ob_start(); ?>
<?php session_start(); ?>

<?php
$_SESSION['username'] = $db_username;
$_SESSION['user_firstname'] = $db_user_firstname;
$_SESSION['user_lastname'] = $db_user_lastname;
$_SESSION['user_role'] = $db_user_role;

header("Location: /cms");
?>