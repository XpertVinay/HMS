<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");
?>

<div class="box-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Society Events</h2>
    <button onclick="document.getElementById('addEventModal').style.display='flex'" class="btn-modern">Add Event</button>
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

<!-- Modal -->
<div id="addEventModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:12px; width:100%; max-width:500px; position:relative; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <span onclick="document.getElementById('addEventModal').style.display='none'" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer; color: #9ca3af;">&times;</span>
        <h3 style="margin-bottom:20px;">New Event</h3>
        <form method="post" action="create_event.php" style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Title</label>
                <input type="text" name="title" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Date</label>
                    <input type="date" name="event_date" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Time</label>
                    <input type="time" name="event_time" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
                </div>
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);"></textarea>
            </div>
            <button type="submit" name="submit" class="btn-modern" style="width:100%; font-size: 16px;">Add Event</button>
        </form>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>