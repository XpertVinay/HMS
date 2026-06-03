<?php require_once("header.php"); ?>
<div class="page-header">
    <h2>Upcoming Events</h2>
    <p class="card-meta">Join us in our community celebrations and meetings.</p>
</div>
<div class="card-grid">
    <?php
    $result = mysqli_query($con, "SELECT title, description, event_date, event_time FROM events ORDER BY event_date ASC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="modern-card">';
            echo '<div style="display: flex; gap: 1rem; align-items: flex-start;">';
            echo '<div style="background: var(--bg-light); padding: 0.5rem 1rem; border-radius: 8px; text-align: center; min-width: 80px;">';
            echo '<div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-color);">' . date('d', strtotime($row['event_date'])) . '</div>';
            echo '<div style="font-size: 0.875rem; color: var(--text-muted); text-transform: uppercase;">' . date('M', strtotime($row['event_date'])) . '</div>';
            echo '</div>';
            echo '<div>';
            echo '<h3 class="card-title" style="margin-bottom: 0.25rem;">' . htmlspecialchars($row['title']) . '</h3>';
            $time = $row['event_time'] ? date('h:i A', strtotime($row['event_time'])) : 'All Day';
            echo '<p class="card-meta" style="color: var(--primary-color); font-weight: 500; margin-bottom: 0.5rem;">⏱ ' . $time . '</p>';
            echo '<p style="font-size: 0.95rem;">' . htmlspecialchars($row['description']) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No upcoming events at the moment.</p>';
    }
    ?>
</div>
<?php require_once("footer.php"); ?>
