<?php require_once("header.php"); ?>
<div class="page-header">
    <h2>Our Sponsors</h2>
    <p class="card-meta">Organizations that help make our society better.</p>
</div>
<div class="card-grid">
    <?php
    $result = mysqli_query($con, "SELECT name, logo_url, description, website_url FROM sponsors ORDER BY name ASC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="modern-card sponsor-card">';
            if($row['logo_url']) {
                echo '<img src="' . htmlspecialchars($row['logo_url']) . '" alt="' . htmlspecialchars($row['name']) . '" class="sponsor-logo">';
            }
            echo '<h3 class="card-title">' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p class="card-meta" style="margin-bottom: 1.5rem;">' . htmlspecialchars($row['description']) . '</p>';
            if($row['website_url']) {
                echo '<a href="' . htmlspecialchars($row['website_url']) . '" target="_blank" class="btn-login" style="padding: 0.5rem 1rem; border-radius: 6px;">Visit Website</a>';
            }
            echo '</div>';
        }
    } else {
        echo '<p>No sponsors found.</p>';
    }
    ?>
</div>
<?php require_once("footer.php"); ?>
