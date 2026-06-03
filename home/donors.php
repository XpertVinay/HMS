<?php require_once("header.php"); ?>
<div class="page-header">
    <h2>Our Generous Donors</h2>
    <p class="card-meta">Thank you for supporting our society initiatives.</p>
</div>
<div class="card-grid">
    <?php
    $result = mysqli_query($con, "SELECT name, amount, donation_date FROM donors ORDER BY donation_date DESC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="modern-card">';
            echo '<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">';
            echo '<div style="width: 48px; height: 48px; border-radius: 50%; background: var(--secondary-color); color: white; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold;">' . strtoupper(substr($row['name'], 0, 1)) . '</div>';
            echo '<div>';
            echo '<h3 class="card-title" style="margin-bottom: 0;">' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p class="card-meta" style="margin-bottom: 0;">' . date('F j, Y', strtotime($row['donation_date'])) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '<div style="background: var(--bg-light); padding: 1rem; border-radius: 8px; text-align: center;">';
            echo '<span style="font-size: 1.5rem; font-weight: 800; color: #111827;">₹' . number_format($row['amount'], 2) . '</span>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No donors found.</p>';
    }
    ?>
</div>
<?php require_once("footer.php"); ?>
