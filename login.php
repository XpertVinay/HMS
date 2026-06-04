<?php 
require_once("Includes/config.php");
require_once("Includes/session.php");

if(isset($_SESSION['logged']))
{
    if ($_SESSION['logged'] == true)
    {
        if ($_SESSION['account']=="admin") {
                header("Location:admin/Dashboard/admin.php");
            }
        elseif ($_SESSION['account']=="member") {
                header("Location:members/Dashboard/member.php");
            }
        elseif ($_SESSION['account']=="staff") {
                header("Location:staff/Dashboard/staff.php");
            }
        exit;
    }  
}

// Determine Theme
$theme_class = 'theme-member'; // default
if (isset($_COOKIE['last_login_role'])) {
    if ($_COOKIE['last_login_role'] === 'admin') {
        $theme_class = 'theme-admin';
    } elseif ($_COOKIE['last_login_role'] === 'staff') {
        $theme_class = 'theme-staff';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Businzo RCMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login-theme.css">
    <link rel="shortcut icon" href="<?php echo htmlspecialchars(ACTIVE_ORG_LOGO); ?>"/>
    <style>
        :root {
            --primary-color: <?php echo htmlspecialchars(ACTIVE_ORG_PRIMARY_COLOR); ?>;
            --secondary-color: <?php echo htmlspecialchars(ACTIVE_ORG_SECONDARY_COLOR); ?>;
        }
    </style>
</head>
<body class="<?php echo htmlspecialchars($theme_class); ?>">
    
    <div class="login-glass-card">
        <div style="text-align: center; margin-bottom: 1rem;">
            <img src="<?php echo htmlspecialchars(ACTIVE_ORG_LOGO); ?>" alt="Organization Logo" style="max-height: 80px; width: auto; object-fit: contain; background: rgba(255, 255, 255, 0.95); padding: 8px 16px; border-radius: 8px;">
        </div>
        <p class="subtitle">Log in to the Communit Management Portal</p>

        <?php
        // Basic error display for invalid login or organization status
        if(isset($_POST['login']) && !$logged) {
            if (!empty($login_error)) {
                echo '<div class="glass-alert">' . htmlspecialchars($login_error) . '</div>';
            } else {
                echo '<div class="glass-alert">Invalid username or password.</div>';
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="glass-input-group">
                <input type="text" name="username" placeholder="Username" class="glass-input" required autocomplete="username">
            </div>    
            <div class="glass-input-group">
                <input type="password" name="password" placeholder="Password" class="glass-input" required autocomplete="current-password">
            </div>
            
            <button type="submit" name="login" class="glass-btn">Log In</button>
            
            <div class="glass-links">
                <a href="home/home.php">← Back To Home</a>
            </div>
        </form>
    </div>

</body>
</html>