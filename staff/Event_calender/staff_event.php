<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");
?>

<div class="box-title" style="margin-bottom: 20px;">
    <h2>Society Events</h2>
</div>

<div class="sales-boxes" style="flex-direction: column;">
    <?php
    $result = mysqli_query($con, "SELECT id, title, description, event_date, event_time FROM events ORDER BY event_date ASC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="box" style="align-items: flex-start; gap: 20px;">';
            echo '<div style="background: var(--bg-light); padding: 10px 20px; border-radius: 8px; text-align: center; min-width: 80px;">';
            echo '<div style="font-size: 24px; font-weight: 800; color: var(--primary-color);">' . date('d', strtotime($row['event_date'])) . '</div>';
            echo '<div style="font-size: 14px; color: var(--text-muted); text-transform: uppercase;">' . date('M', strtotime($row['event_date'])) . '</div>';
            echo '</div>';
            echo '<div style="flex: 1;">';
            echo '<h3 style="margin: 0 0 5px 0; color: #111827;">' . htmlspecialchars($row['title']) . '</h3>';
            $time = $row['event_time'] ? date('h:i A', strtotime($row['event_time'])) : 'All Day';
            echo '<p style="color: var(--primary-color); font-weight: 500; margin: 0 0 10px 0;">⏱ ' . $time . '</p>';
            echo '<p style="margin: 0; color: var(--text-muted);">' . htmlspecialchars($row['description']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="box"><p>No upcoming events.</p></div>';
    }
    ?>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>