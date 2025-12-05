<?php
session_start();

// Unset all admin-related session variables
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_username']);

// Destroy the session completely
session_destroy();

// Redirect to admin login page
header("Location: admin_login.php");
exit();
