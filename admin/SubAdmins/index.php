<?php
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");

$msg = "";
$err = "";

// Handle sub-admin creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_subadmin'])) {
    $sub_username = trim($_POST['username'] ?? '');
    $sub_email = trim($_POST['email'] ?? '');
    $sub_password = $_POST['password'] ?? '';

    if (empty($sub_username) || empty($sub_email) || empty($sub_password)) {
        $err = "All fields are required.";
    } elseif (strlen($sub_password) < 6) {
        $err = "Password must be at least 6 characters.";
    } else {
        try {
            // Check if username/email already exists
            $check = $pdo->prepare("SELECT id FROM admin WHERE username = ? OR email = ?");
            $check->execute([$sub_username, $sub_email]);
            if ($check->fetch()) {
                $err = "Username or Email already exists.";
            } else {
                $hashed = password_hash($sub_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO admin (username, email, password, organization_id, role) VALUES (?, ?, ?, ?, 'sub-admin')");
                if ($stmt->execute([$sub_username, $sub_email, $hashed, ACTIVE_ORG_ID])) {
                    $msg = "Sub-Admin successfully added.";
                } else {
                    $err = "Failed to add sub-admin.";
                }
            }
        } catch (PDOException $e) {
            $err = "Database error: " . $e->getMessage();
        }
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    // Prevent deleting the main admin or users from other orgs
    $stmt = $pdo->prepare("DELETE FROM admin WHERE id = ? AND organization_id = ? AND role = 'sub-admin'");
    if ($stmt->execute([$del_id, ACTIVE_ORG_ID])) {
        $msg = "Sub-admin deleted.";
    }
}

// Fetch sub-admins
$stmt = $pdo->prepare("SELECT * FROM admin WHERE organization_id = ? AND role = 'sub-admin' ORDER BY created_at DESC");
$stmt->execute([ACTIVE_ORG_ID]);
$subadmins = $stmt->fetchAll();
?>

<div class="sales-boxes" style="flex-direction: column; padding: 20px;">
    
    <?php if(!empty($msg)): ?>
        <div style="padding: 15px; margin-bottom: 20px; background: rgba(40,167,69,0.2); border: 1px solid rgba(40,167,69,0.5); color: #fff; border-radius: 8px;">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($err)): ?>
        <div style="padding: 15px; margin-bottom: 20px; background: rgba(220,53,69,0.2); border: 1px solid rgba(220,53,69,0.5); color: #fff; border-radius: 8px;">
            <?php echo htmlspecialchars($err); ?>
        </div>
    <?php endif; ?>

    <div class="box" style="margin-bottom: 20px;">
        <div class="box-title" style="margin-bottom: 15px;">Add New Sub-Admin</div>
        <form method="post" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="username" placeholder="Username" required style="width:100%; padding: 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: transparent; color: #fff;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <input type="email" name="email" placeholder="Email" required style="width:100%; padding: 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: transparent; color: #fff;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <input type="password" name="password" placeholder="Password" required style="width:100%; padding: 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: transparent; color: #fff;">
            </div>
            <div>
                <button type="submit" name="add_subadmin" style="padding: 10px 20px; background: var(--primary-color, #4361ee); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">Add Sub-Admin</button>
            </div>
        </form>
    </div>

    <div class="box">
        <div class="box-title">Manage Sub-Admins</div>
        <table class="table-striped table-bordered col-md-12" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="text-align:left; padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);">#</th>
                    <th style="text-align:left; padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Username</th>
                    <th style="text-align:left; padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Email</th>
                    <th style="text-align:left; padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Created At</th>
                    <th style="text-align:left; padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($subadmins) > 0): ?>
                    <?php $i = 1; foreach ($subadmins as $sub): ?>
                    <tr>
                        <td style="padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo $i++; ?></td>
                        <td style="padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($sub['username']); ?></td>
                        <td style="padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($sub['email']); ?></td>
                        <td style="padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo date('M d, Y', strtotime($sub['created_at'])); ?></td>
                        <td style="padding:12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <a href="?delete=<?php echo $sub['id']; ?>" onclick="return confirm('Are you sure you want to delete this sub-admin?');" style="color: #ff4757; text-decoration: none;">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 20px;">No sub-admins found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once("../../Includes/portal_footer.php"); ?>
