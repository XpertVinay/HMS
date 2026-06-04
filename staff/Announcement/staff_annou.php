<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");
?>

<div class="box-title" style="margin-bottom: 20px;">
    <h2>Announcements</h2>
</div>

<div class="sales-boxes" style="flex-direction: column;">
    <?php 
    $result = mysqli_query($con, "SELECT * FROM announcement ORDER BY created_at DESC");
    if($result && mysqli_num_rows($result) > 0): 
        while($announcement = mysqli_fetch_assoc($result)): 
    ?>
    <div class="box" style="flex-direction: column; align-items: flex-start; gap: 10px;">
        <div style="display: flex; justify-content: space-between; width: 100%;">
            <h3 style="margin: 0; color: var(--primary-color);"><?php echo htmlspecialchars($announcement['announcement_subject'])?></h3>
            <span style="font-size: 12px; color: var(--text-muted);"><?php echo htmlspecialchars($announcement['created_at'])?></span>
        </div>
        <p style="margin: 0; white-space: pre-wrap;"><?php echo htmlspecialchars($announcement['announcement_text'])?></p>
    </div>
    <?php 
        endwhile; 
    else: 
    ?>
        <div class="box"><p>No announcements found.</p></div>
    <?php endif; ?>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>