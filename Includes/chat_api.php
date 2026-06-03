<?php
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/session.php");

if (!$logged) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$my_role = $_SESSION['account'];
$my_id = $_SESSION['uid'] ?? $_SESSION['aid'] ?? 0;

$pdo = Database::getInstance()->getPDO();

if ($action === 'get_contacts') {
    $contacts = [];

    // All roles can chat with admins
    $stmt = $pdo->query("SELECT id, username FROM admin");
    while ($row = $stmt->fetch()) {
        if ($my_role !== 'admin' || $my_id != $row['id']) {
            $contacts[] = ['id' => $row['id'], 'type' => 'admin', 'name' => $row['username'] . ' (Admin)'];
        }
    }

    // Admins and Staff can chat with members
    if ($my_role === 'admin' || $my_role === 'staff') {
        $stmt = $pdo->query("SELECT id, username FROM member");
        while ($row = $stmt->fetch()) {
            if ($my_role !== 'member' || $my_id != $row['id']) {
                $contacts[] = ['id' => $row['id'], 'type' => 'member', 'name' => $row['username'] . ' (Member)'];
            }
        }
    }

    // Admins and Members can chat with Staff
    if ($my_role === 'admin' || $my_role === 'member') {
        $stmt = $pdo->query("SELECT id, username FROM staff");
        while ($row = $stmt->fetch()) {
            if ($my_role !== 'staff' || $my_id != $row['id']) {
                $contacts[] = ['id' => $row['id'], 'type' => 'staff', 'name' => $row['username'] . ' (Staff)'];
            }
        }
    }

    // Hardcoded Service Providers
    $contacts[] = ['id' => 'sp_1', 'type' => 'provider', 'name' => 'Bahadur (Security)'];
    $contacts[] = ['id' => 'sp_2', 'type' => 'provider', 'name' => 'Rajesh (Plumber)'];

    echo json_encode(['contacts' => $contacts]);
    exit();
}

if ($action === 'get_messages') {
    $target_id = $_POST['target_id'] ?? '';
    $target_type = $_POST['target_type'] ?? '';

    $stmt = $pdo->prepare("
        SELECT * FROM messages 
        WHERE (sender_type = :my_role AND sender_id = :my_id AND receiver_type = :target_type AND receiver_id = :target_id)
           OR (sender_type = :target_type AND sender_id = :target_id AND receiver_type = :my_role AND receiver_id = :my_id)
        ORDER BY created_at ASC
    ");
    $stmt->execute([
        ':my_role' => $my_role,
        ':my_id' => $my_id,
        ':target_type' => $target_type,
        ':target_id' => $target_id
    ]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Also attach my_id and my_role for UI mapping
    echo json_encode([
        'messages' => $messages,
        'my_role' => $my_role,
        'my_id' => $my_id
    ]);
    exit();
}

if ($action === 'send_message') {
    $target_id = $_POST['target_id'] ?? '';
    $target_type = $_POST['target_type'] ?? '';
    $message = trim($_POST['message'] ?? '');

    if (!empty($message) && !empty($target_id) && !empty($target_type)) {
        $stmt = $pdo->prepare("
            INSERT INTO messages (sender_type, sender_id, receiver_type, receiver_id, message)
            VALUES (:my_role, :my_id, :target_type, :target_id, :message)
        ");
        $stmt->execute([
            ':my_role' => $my_role,
            ':my_id' => $my_id,
            ':target_type' => $target_type,
            ':target_id' => $target_id,
            ':message' => $message
        ]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
    }
    exit();
}

echo json_encode(['error' => 'Invalid action']);
