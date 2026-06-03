<?php require_once("header.php"); ?>
<div class="page-header">
    <h2>Notice Board</h2>
    <p class="card-meta">Important announcements and circulars for society members.</p>
</div>
<div style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 800px; margin: 0 auto;">
    <?php
    $result = mysqli_query($con, "SELECT announcement_subject, announcement_text, created_at FROM announcement ORDER BY created_at DESC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="modern-card" style="border-left: 4px solid var(--primary-color);">';
            echo '<h3 class="card-title">' . htmlspecialchars($row['announcement_subject']) . '</h3>';
            echo '<p class="card-meta">Posted on ' . date('F j, Y', strtotime($row['created_at'])) . '</p>';
            echo '<p style="margin-top: 1rem; white-space: pre-wrap;">' . htmlspecialchars($row['announcement_text']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<div class="modern-card" style="text-align: center;"><p>No active notices.</p></div>';
    }
    ?>
</div>
<?php require_once("footer.php"); ?>
