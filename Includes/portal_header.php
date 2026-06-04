<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }
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
    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- Modern Portal CSS -->
    <link rel="stylesheet" href="/Includes/portal_style.css">
    <link rel="shortcut icon" href="<?php echo htmlspecialchars(ACTIVE_ORG_LOGO); ?>"/>
    <style>
        :root {
            --primary-color: <?php echo htmlspecialchars(ACTIVE_ORG_PRIMARY_COLOR); ?>;
            --secondary-color: <?php echo htmlspecialchars(ACTIVE_ORG_SECONDARY_COLOR); ?>;
            /* Derive a darker variant for hover */
            --primary-hover: color-mix(in srgb, var(--primary-color) 85%, black);
            --bg-dark: var(--secondary-color);
        }
    </style>
    <link rel="manifest" href="/manifest.json">
    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          navigator.serviceWorker.register('/sw.js').then(function(registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
          }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
          });
        });
      }
    </script>
</head>
<body>
