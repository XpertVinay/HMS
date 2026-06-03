<?php
// Initialize the session
session_start();

// Capture the role before destroying the session
if (isset($_SESSION['account'])) {
    // Set a cookie for 30 days to remember the theme
    setcookie('last_login_role', $_SESSION['account'], time() + (86400 * 30), "/");
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>