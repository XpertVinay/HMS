<?php
if (!isset($con)) {
    require_once(__DIR__ . "/config.php");
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    header("Location: /login.php");
    exit();
}
$role = $_SESSION['account']; // 'admin', 'member', or 'staff'
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Portal</title>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- Modern Portal CSS -->
    <link rel="stylesheet" href="/Includes/portal_style.css">
    <link rel="shortcut icon" href="/Logo3.jpg">
</head>
<body>
