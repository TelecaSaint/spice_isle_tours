<?php
include 'includes/auth.php';
include 'includes/db_connect.php';

// Your page code here
?>

<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
