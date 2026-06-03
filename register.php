<?php
// Include config file
require_once "Includes/config.php";

// Redirect if already logged in
if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
    header("location: index.php");
    exit;
}

$org_name = $org_address = $org_reg_code = $subdomain = "";
$username = $email = $password = $confirm_password = "";
$err_msg = $success_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $pdo = Database::getInstance()->getPDO();

    $org_name = trim($_POST["org_name"] ?? '');
    $org_address = trim($_POST["org_address"] ?? '');
    $org_reg_code = trim($_POST["org_reg_code"] ?? '');
    $subdomain = trim($_POST["subdomain"] ?? '');
    
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    // Basic Validation
    if(empty($org_name) || empty($org_reg_code) || empty($subdomain) || empty($username) || empty($email) || empty($password)){
        $err_msg = "Please fill all required fields.";
    } elseif(!preg_match('/^[a-z0-9]+$/', $subdomain)){
        $err_msg = "Subdomain can only contain lowercase letters and numbers.";
    } elseif($password !== $confirm_password){
        $err_msg = "Passwords do not match.";
    } elseif(strlen($password) < 6){
        $err_msg = "Password must have at least 6 characters.";
    } else {
        try {
            $pdo->beginTransaction();

            // Check if subdomain or reg code exists
            $stmt = $pdo->prepare("SELECT id FROM organizations WHERE subdomain = ? OR registration_code = ?");
            $stmt->execute([$subdomain, $org_reg_code]);
            if($stmt->fetch()){
                throw new Exception("Subdomain or Registration Code already exists.");
            }

            // Check if admin username or email exists
            $stmt = $pdo->prepare("SELECT id FROM admin WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if($stmt->fetch()){
                throw new Exception("Admin username or email already exists.");
            }

            // Insert Organization
            $stmt = $pdo->prepare("INSERT INTO organizations (name, address, registration_code, subdomain, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->execute([$org_name, $org_address, $org_reg_code, $subdomain]);
            $org_id = $pdo->lastInsertId();

            // Insert Admin
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (username, email, password, organization_id, role) VALUES (?, ?, ?, ?, 'admin')");
            $stmt->execute([$username, $email, $hashed_password, $org_id]);

            $pdo->commit();
            $success_msg = "Registration successful! Your organization is pending Super Admin approval.";
            
            // Clear form
            $org_name = $org_address = $org_reg_code = $subdomain = $username = $email = "";
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $err_msg = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | RCMS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login-theme.css">
    <link rel="shortcut icon" href="Logo3.jpg"/>
    <style>
        .login-glass-card {
            max-width: 600px; /* Make it wider for more fields */
            margin: 40px auto;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row .glass-input-group {
            flex: 1;
        }
        .section-title {
            margin-top: 20px;
            margin-bottom: 15px;
            font-size: 1.1em;
            color: #ffffff;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 5px;
        }
    </style>
</head>
<body class="theme-admin">
    <div class="login-glass-card">
        <h2>Register Organization</h2>
        <p class="subtitle">Set up your RWA / RCMS platform</p>

        <?php 
        if(!empty($err_msg)){
            echo '<div class="glass-alert" style="background: rgba(220, 53, 69, 0.2); border-color: rgba(220, 53, 69, 0.5); color: #fff;">' . htmlspecialchars($err_msg) . '</div>';
        }
        if(!empty($success_msg)){
            echo '<div class="glass-alert" style="background: rgba(40, 167, 69, 0.2); border-color: rgba(40, 167, 69, 0.5); color: #fff;">' . htmlspecialchars($success_msg) . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="section-title">Organization Details</div>
            
            <div class="glass-input-group">
                <input type="text" name="org_name" placeholder="Organization Name (e.g. Sunnyvale RWA)" class="glass-input" value="<?php echo htmlspecialchars($org_name); ?>" required>
            </div>
            
            <div class="glass-input-group">
                <input type="text" name="org_address" placeholder="Complete Address" class="glass-input" value="<?php echo htmlspecialchars($org_address); ?>" required>
            </div>

            <div class="form-row">
                <div class="glass-input-group">
                    <input type="text" name="org_reg_code" placeholder="RWA Registration Code" class="glass-input" value="<?php echo htmlspecialchars($org_reg_code); ?>" required>
                </div>
                <div class="glass-input-group">
                    <input type="text" name="subdomain" placeholder="Desired Subdomain (e.g. sunnyvale)" class="glass-input" value="<?php echo htmlspecialchars($subdomain); ?>" required>
                </div>
            </div>

            <div class="section-title">Admin Account Details</div>

            <div class="form-row">
                <div class="glass-input-group">
                    <input type="text" name="username" placeholder="Admin Username" class="glass-input" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="glass-input-group">
                    <input type="email" name="email" placeholder="Admin Email" class="glass-input" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="glass-input-group">
                    <input type="password" name="password" placeholder="Password" class="glass-input" required>
                </div>
                <div class="glass-input-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" class="glass-input" required>
                </div>
            </div>
            
            <button type="submit" class="glass-btn" style="margin-top: 20px;">Register</button>
            
            <div class="glass-links">
                <p>Already registered? <a href="login.php">Login here</a></p>
                <a href="home/home.php">← Back To Home</a>
            </div>
        </form>
    </div>
</body>
</html>