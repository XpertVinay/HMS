<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }
require_once(__DIR__ . "/config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logged = false;

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    $logged = true;
    $username = $_SESSION['username'];
}


if(!$logged && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $pdo = Database::getInstance()->getPDO();

    $tables = ['member', 'admin', 'staff'];

    foreach ($tables as $table) {
        if ($table === 'admin') {
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :uname OR username = :uname LIMIT 1");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM $table WHERE username = :uname OR email = :uname LIMIT 1");
        }
        
        $stmt->execute([':uname' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            $db_pass = $user['password'];
            $is_valid = false;
            $needs_rehash = false;

            // Check if stored password is a hash (starts with $2y$ for BCRYPT)
            if (strpos($db_pass, '$2y$') === 0) {
                $is_valid = password_verify($password, $db_pass);
            } else {
                // Fallback for legacy plaintext passwords
                if ($password === $db_pass) {
                    $is_valid = true;
                    $needs_rehash = true;
                }
            }

            if ($is_valid) {
                // Seamless migration to hashed password
                if ($needs_rehash) {
                    $new_hash = password_hash($password, PASSWORD_DEFAULT);
                    $update_stmt = $pdo->prepare("UPDATE $table SET password = :hash WHERE id = :id");
                    $update_stmt->execute([':hash' => $new_hash, ':id' => $user['id']]);
                }

                $_SESSION['logged'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['account'] = $table;
                
                if ($table === 'member') {
                    $_SESSION['member'] = $user['name'] ?? 'Member';
                    $_SESSION['uid'] = $user['id'];
                    header("Location:members/Dashboard/member.php");
                } elseif ($table === 'admin') {
                    $_SESSION['aid'] = $user['id'];
                    header("Location:admin/Dashboard/admin.php");
                } elseif ($table === 'staff') {
                    $_SESSION['aid'] = $user['id'];
                    header("Location:staff/Dashboard/staff.php");
                }
                exit();
            }
        }
    }
}
?>