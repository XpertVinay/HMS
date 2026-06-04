<?php
require_once("Includes/Database.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$db = Database::getInstance();
$con = $db->getPDO();

// Organization Data
$rwa_name = trim($_POST['rwa_name'] ?? '');
$address = trim($_POST['address'] ?? '');
$subdomain = strtolower(trim($_POST['subdomain'] ?? ''));
$primary_color = $_POST['primary_color'] ?? '#4f46e5';
$secondary_color = $_POST['secondary_color'] ?? '#1d1b31';
$logo_url_input = trim($_POST['logo_url_input'] ?? '');

// Admin Data
$admin_email = trim($_POST['admin_email'] ?? '');
$admin_username = trim($_POST['admin_username'] ?? '');
$admin_password = $_POST['admin_password'] ?? '';

// Validation
if (empty($rwa_name) || empty($address) || empty($subdomain) || empty($admin_email) || empty($admin_username) || empty($admin_password)) {
    echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled.']);
    exit;
}

if (!preg_match('/^[a-z0-9]+$/', $subdomain)) {
    echo json_encode(['status' => 'error', 'message' => 'Subdomain must contain only lowercase letters and numbers.']);
    exit;
}

try {
    // Check if subdomain exists
    $stmt = $con->prepare("SELECT COUNT(*) FROM organizations WHERE subdomain = ?");
    $stmt->execute([$subdomain]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Subdomain is already taken. Please choose another.']);
        exit;
    }

    // Check if admin username exists (across all orgs to keep logins unique)
    $stmt = $con->prepare("SELECT COUNT(*) FROM admin WHERE username = ?");
    $stmt->execute([$admin_username]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Admin username is already taken.']);
        exit;
    }

    // Handle Logo Upload vs URL
    $final_logo = null;
    
    if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] == UPLOAD_ERR_OK) {
        // Handle File Upload
        $upload_dir = __DIR__ . '/uploads/logos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $ext = pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION);
        $filename = $subdomain . '_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $upload_dir . $filename)) {
            $final_logo = $filename;
        }
    } elseif (!empty($logo_url_input)) {
        // User provided a URL instead
        $final_logo = $logo_url_input;
        // If they provided a full URL, we need to ensure the config file handles absolute URLs
        // Wait, config says '/uploads/logos/' . ACTIVE_ORG_LOGO if it's not empty. 
        // We will store just the URL. Config will need to know if it's HTTP.
        // I will fix config to check if it starts with http.
    }

    // Generate random registration code
    $registration_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

    // Transaction to insert org and admin
    $con->beginTransaction();

    // 1. Insert Organization (Auto-approved as per requirement)
    $stmt = $con->prepare("INSERT INTO organizations (name, address, registration_code, subdomain, status, logo_url, primary_color, secondary_color) VALUES (?, ?, ?, ?, 'approved', ?, ?, ?)");
    $stmt->execute([
        $rwa_name,
        $address,
        $registration_code,
        $subdomain,
        $final_logo,
        $primary_color,
        $secondary_color
    ]);
    
    $org_id = $con->lastInsertId();

    // 2. Insert Initial Admin
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $stmt = $con->prepare("INSERT INTO admin (email, username, password, organization_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $admin_email,
        $admin_username,
        $hashed_password,
        $org_id
    ]);

    $con->commit();

    echo json_encode([
        'status' => 'success', 
        'message' => 'RWA Registered Successfully! Redirecting to your portal...',
        'subdomain' => $subdomain
    ]);

} catch (PDOException $e) {
    $con->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
