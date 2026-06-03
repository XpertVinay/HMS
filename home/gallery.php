<?php require_once("header.php"); ?>
<div class="page-header">
    <h2>Photo Gallery</h2>
    <p class="card-meta">Moments captured in our society.</p>
</div>
<div class="gallery-grid">
    <?php
    $result = mysqli_query($con, "SELECT title, image_url, description FROM gallery ORDER BY uploaded_at DESC");
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="gallery-item">';
            echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '">';
            echo '<div class="gallery-overlay">';
            echo '<h4 style="color: #fff; margin-bottom: 0.25rem;">' . htmlspecialchars($row['title']) . '</h4>';
            echo '<p style="font-size: 0.875rem; opacity: 0.8;">' . htmlspecialchars($row['description']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No images in the gallery.</p>';
    }
    ?>
</div>
<?php require_once("footer.php"); ?>
