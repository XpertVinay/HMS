<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }
// Include configuration if not already included
if (!isset($con)) {
    require_once("../Includes/config.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Society Management System</title>
    <!-- Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="shortcut icon" href="../Logo3.jpg">
</head>
<body>
    <header class="main-header">
        <div class="nav-container">
            <a href="home.php" class="logo-link">HMS System</a>
            <ul class="nav-menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="members.php">Members</a></li>
                <li><a href="donors.php">Donors</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="notices.php">Notices</a></li>
                <li><a href="sponsors.php">Sponsors</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="../login.php" class="btn-login">Login</a></li>
            </ul>
        </div>
    </header>
    
    <!-- Main content area starts here -->
    <main>
