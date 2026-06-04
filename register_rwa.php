<?php
session_start();
require_once("Includes/config.php");

// If already logged in, redirect
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    header("Location: /");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register RWA | Businzo RCMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login-theme.css">
    <link rel="shortcut icon" href="businzo_logo.png"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .register-container {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
        }
        .color-pickers {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .color-picker-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .color-picker-group input[type="color"] {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            padding: 0;
            background: none;
        }
        .section-title {
            text-align: left;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 5px;
        }
    </style>
</head>
<body class="theme-admin">
    <div class="register-container">
        <div class="login-glass-card" style="max-width: 100%; text-align: left;">
            <div style="text-align: center; margin-bottom: 1rem;">
                <img src="businzo_logo.png" alt="Businzo Logo" style="height: 50px; object-fit: contain; background: rgba(255, 255, 255, 0.95); padding: 8px 16px; border-radius: 8px;">
            </div>
            <h2 style="text-align: center;">RWA Registration</h2>
            <p class="subtitle" style="text-align: center;">Create your own community portal</p>

            <div id="register_msg"></div>

            <form id="register-rwa-form" enctype="multipart/form-data">
                
                <div class="section-title">Organization Details</div>
                
                <div class="glass-input-group">
                    <input type="text" name="rwa_name" placeholder="RWA / Society Name" class="glass-input" required>
                </div>
                <div class="glass-input-group">
                    <input type="text" name="address" placeholder="Society Address" class="glass-input" required>
                </div>
                <div class="glass-input-group">
                    <input type="text" name="subdomain" placeholder="Desired Subdomain (e.g., 'greenvalley')" class="glass-input" required pattern="[a-zA-Z0-9]+">
                    <small style="color: rgba(255,255,255,0.7); display:block; margin-top:5px;">Your portal will be available at subdomain.businzo.com (or ?org=subdomain)</small>
                </div>

                <div class="section-title">Branding (White-Labeling)</div>
                
                <div class="glass-input-group">
                    <label style="display:block; margin-bottom: 5px;">Logo Upload</label>
                    <input type="file" name="logo_file" class="glass-input" accept="image/*" style="padding: 10px;">
                </div>
                <div class="glass-input-group">
                    <label style="display:block; margin-bottom: 5px;">Or Provide Logo URL</label>
                    <input type="url" name="logo_url_input" placeholder="https://example.com/logo.png" class="glass-input">
                </div>

                <div class="color-pickers">
                    <div class="color-picker-group">
                        <label>Primary Theme Color</label>
                        <input type="color" name="primary_color" value="#4f46e5">
                    </div>
                    <div class="color-picker-group">
                        <label>Secondary Theme Color</label>
                        <input type="color" name="secondary_color" value="#1d1b31">
                    </div>
                </div>

                <div class="section-title">Initial Admin Account</div>

                <div class="glass-input-group">
                    <input type="email" name="admin_email" placeholder="Admin Email" class="glass-input" required>
                </div>
                <div class="glass-input-group">
                    <input type="text" name="admin_username" placeholder="Admin Username" class="glass-input" required>
                </div>
                <div class="glass-input-group">
                    <input type="password" name="admin_password" placeholder="Admin Password" class="glass-input" required minlength="6">
                </div>
                
                <button type="submit" class="glass-btn">Register RWA</button>
                
                <div class="glass-links" style="text-align: center;">
                    <a href="login.php">Already have a portal? Log In</a> | 
                    <a href="home/home.php">Back to Home</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('#register-rwa-form').submit(function(e){
            e.preventDefault();
            var submitBtn = $(this).find('button[type="submit"]');
            submitBtn.text('Registering...').prop('disabled', true);
            $('#register_msg').html('');

            var formData = new FormData(this);

            $.ajax({
                url: 'ajax_register_rwa.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(resp){
                    if(resp.status == 'success'){
                        $('#register_msg').html('<div class="glass-alert" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">' + resp.message + '</div>');
                        setTimeout(function(){
                            window.location.href = 'login.php?org=' + resp.subdomain;
                        }, 2000);
                    } else {
                        $('#register_msg').html('<div class="glass-alert">' + resp.message + '</div>');
                        submitBtn.text('Register RWA').prop('disabled', false);
                    }
                },
                error: function(){
                    $('#register_msg').html('<div class="glass-alert">An error occurred during registration. Please try again.</div>');
                    submitBtn.text('Register RWA').prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>
