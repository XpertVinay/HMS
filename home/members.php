<?php require_once("header.php"); ?>
<div class="page-header">
    <h2>Society Members</h2>
    <p class="card-meta">Meet the residents of our community</p>
</div>
<div class="card-grid">
    <?php
    $result = mysqli_query($con, "SELECT username, email FROM member ORDER BY username ASC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="modern-card" style="text-align: center;">';
            echo '<div style="width: 64px; height: 64px; border-radius: 50%; background: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; margin: 0 auto 1rem;">' . strtoupper(substr($row['username'], 0, 1)) . '</div>';
            echo '<h3 class="card-title">' . htmlspecialchars($row['username']) . '</h3>';
            echo '<p class="card-meta">Resident Member</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No members found.</p>';
    }
    ?>
</div>
<?php require_once("footer.php"); ?>
