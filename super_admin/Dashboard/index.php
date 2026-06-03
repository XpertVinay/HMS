<?php
require_once("../../Includes/config.php");

// Protect this page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged']) || $_SESSION['account'] !== 'super_admin') {
    header("Location: ../../login.php");
    exit;
}

$pdo = Database::getInstance()->getPDO();

// Handle status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['org_id'])) {
    $action = $_POST['action'];
    $org_id = (int)$_POST['org_id'];
    
    $new_status = null;
    if ($action === 'approve') $new_status = 'approved';
    elseif ($action === 'reject') $new_status = 'rejected';
    elseif ($action === 'suspend') $new_status = 'pending'; // or 'suspended' if added to enum
    
    if ($new_status) {
        $stmt = $pdo->prepare("UPDATE organizations SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $org_id]);
    }
}

// Fetch all organizations
$stmt = $pdo->query("SELECT * FROM organizations ORDER BY created_at DESC");
$organizations = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Dashboard | RCMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../login-theme.css">
    <style>
        body {
            background-color: #0f172a;
            color: #fff;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0; font-size: 1.8em; }
        .btn-logout {
            background: rgba(220, 53, 69, 0.8);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-logout:hover { background: rgba(220, 53, 69, 1); }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        th {
            background: rgba(255,255,255,0.05);
            font-weight: 600;
        }
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
            text-transform: uppercase;
        }
        .status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.4); }
        .status-approved { background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.4); }
        .status-rejected { background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.4); }
        
        .action-form { display: inline; }
        .btn-action {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 0.9em;
            transition: 0.2s;
        }
        .btn-action:hover { background: rgba(255,255,255,0.2); }
        .btn-approve { background: rgba(40, 167, 69, 0.8); border-color: rgba(40, 167, 69, 1); }
        .btn-approve:hover { background: rgba(40, 167, 69, 1); }
        .btn-reject { background: rgba(220, 53, 69, 0.8); border-color: rgba(220, 53, 69, 1); }
        .btn-reject:hover { background: rgba(220, 53, 69, 1); }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Super Admin Dashboard</h1>
            <a href="../../logout.php" class="btn-logout">Logout</a>
        </div>
        
        <h2>Registered Organizations (RWAs)</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Subdomain</th>
                    <th>Registration Code</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($organizations as $org): ?>
                <tr>
                    <td><?php echo htmlspecialchars($org['id']); ?></td>
                    <td><?php echo htmlspecialchars($org['name']); ?></td>
                    <td><?php echo htmlspecialchars($org['subdomain']); ?>.rcms.businzo.com</td>
                    <td><?php echo htmlspecialchars($org['registration_code']); ?></td>
                    <td>
                        <span class="status-badge status-<?php echo htmlspecialchars($org['status']); ?>">
                            <?php echo htmlspecialchars($org['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($org['created_at'])); ?></td>
                    <td>
                        <?php if ($org['status'] !== 'approved'): ?>
                        <form class="action-form" method="post">
                            <input type="hidden" name="action" value="approve">
                            <input type="hidden" name="org_id" value="<?php echo $org['id']; ?>">
                            <button type="submit" class="btn-action btn-approve">Approve</button>
                        </form>
                        <?php endif; ?>
                        
                        <?php if ($org['status'] !== 'rejected'): ?>
                        <form class="action-form" method="post">
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="org_id" value="<?php echo $org['id']; ?>">
                            <button type="submit" class="btn-action btn-reject">Reject</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($organizations)): ?>
                <tr><td colspan="7" style="text-align: center;">No organizations found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
