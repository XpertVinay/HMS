<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../config.php");

$pdo = Database::getInstance()->getPDO();
$role = $_POST['role'];
$id = $_POST['id'];

// Prevent users from updating other roles or IDs unless they are admin managing them
// For now, this handles their own profile submission.
if ($_SESSION['account'] != $role && $_SESSION['account'] != 'admin' && $_SESSION['account'] != 'super_admin') {
    echo 0;
    exit;
}

$updates = [];
$params = [':id' => $id];

$fields = [
    'username', 'email', 'mobile_number', 'address', 'business_name', 
    'social_registration_number', 'bank_account_details'
];

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $updates[] = "$field = :$field";
        $params[":$field"] = $_POST[$field];
    }
}

if (!empty($_POST['password'])) {
    $updates[] = "password = :password";
    $params[':password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
}

// File Uploads
$file_fields = ['rwa_election_copy', 'share_certificate', 'owner_noc', 'employment_contract', 'business_registration'];

$upload_dir = __DIR__ . '/../../uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

foreach ($file_fields as $ff) {
    if (isset($_FILES[$ff]) && $_FILES[$ff]['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES[$ff]['name'], PATHINFO_EXTENSION);
        $filename = $ff . '_' . $role . '_' . $id . '_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES[$ff]['tmp_name'], $upload_dir . $filename)) {
            $updates[] = "$ff = :$ff";
            $params[":$ff"] = $filename;
        }
    }
}

if (!empty($updates)) {
    $sql = "UPDATE $role SET " . implode(", ", $updates) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
        // Update session username if changed
        if (isset($_POST['username']) && $role == $_SESSION['account'] && $id == ($_SESSION['uid'] ?? $_SESSION['aid'] ?? $_SESSION['rid'] ?? $_SESSION['vid'])) {
            $_SESSION['username'] = $_POST['username'];
        }
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 1; // Nothing to update
}
?>
