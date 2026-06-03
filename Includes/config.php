<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }

require_once(__DIR__ . "/Database.php");

// Backward compatibility: instantiate the singleton and expose $con
$db = Database::getInstance();
$con = $db->getConnection();
$pdo = $db->getPDO();

// Subdomain and Organization Resolution
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$subdomain = 'default';

// Basic subdomain extraction (e.g. org1.rcms.businzo.com -> org1)
$host_parts = explode('.', $host);
if (count($host_parts) >= 3 && $host_parts[0] !== 'www') {
    $subdomain = $host_parts[0];
}

// Override for local development testing via ?org=subdomain
if (isset($_GET['org'])) {
    $subdomain = $_GET['org'];
    $_SESSION['dev_org'] = $subdomain;
} elseif (isset($_SESSION['dev_org'])) {
    $subdomain = $_SESSION['dev_org'];
}

$org_stmt = $pdo->prepare("SELECT id, name, status FROM organizations WHERE subdomain = :subdomain LIMIT 1");
$org_stmt->execute([':subdomain' => $subdomain]);
$active_org = $org_stmt->fetch();

if (!$active_org) {
    // Fallback if not found (optional, could also show a 404 page)
    $active_org = ['id' => 1, 'name' => 'Default RWA', 'status' => 'approved'];
}

define('ACTIVE_ORG_ID', $active_org['id']);
define('ACTIVE_ORG_NAME', $active_org['name']);
define('ACTIVE_ORG_STATUS', $active_org['status']);
?>