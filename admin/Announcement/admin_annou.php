<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");
require_once("Connection.php");
$connection = new Connection();
$announcements = $connection->getannouncements();
?>

<div class="box-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Announcements</h2>
    <button onclick="document.getElementById('addModal').style.display='flex'" class="btn-modern">Add Announcement</button>
</div>

<div class="sales-boxes" style="flex-direction: column;">
    <?php if(!empty($announcements)): foreach ($announcements as $announcement): ?>
    <div class="box" style="flex-direction: column; align-items: flex-start; gap: 10px;">
        <div style="display: flex; justify-content: space-between; width: 100%;">
            <h3 style="margin: 0; color: var(--primary-color);"><?php echo htmlspecialchars($announcement['announcement_subject'])?></h3>
            <span style="font-size: 12px; color: var(--text-muted);"><?php echo htmlspecialchars($announcement['created_at'])?></span>
        </div>
        <p style="margin: 0; white-space: pre-wrap;"><?php echo htmlspecialchars($announcement['announcement_text'])?></p>
    </div>
    <?php endforeach; else: ?>
        <div class="box"><p>No announcements found.</p></div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:12px; width:100%; max-width:500px; position:relative; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <span onclick="document.getElementById('addModal').style.display='none'" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer; color: #9ca3af;">&times;</span>
        <h3 style="margin-bottom:20px;">New Announcement</h3>
        <form method="post" action="create.php" style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Title</label>
                <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Message</label>
                <textarea name="message" required rows="5" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);"></textarea>
            </div>
            <button type="submit" name="submit" class="btn-modern" style="width:100%; font-size: 16px;">Submit Announcement</button>
        </form>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>