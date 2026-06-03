<?php require_once("header.php"); ?>

<!-- Close the main tag from header.php because we want hero section to be full width -->
</main>

<div class="hero">
    <div class="hero-content">
        <h1>Welcome to <span class="highlight">HMS</span></h1>
        <p>The ultimate Housing Management System. We help apartments and societies manage all their work seamlessly—from managing staff to making announcements.</p>
        <a href="members.php" class="btn-login" style="padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 1.1rem; display: inline-block; margin-top: 1rem;">View Our Community</a>
    </div>
</div>

<main>
    <div class="card-grid">
        <a href="events.php" class="modern-card" style="display: block; text-decoration: none;">
            <h3 class="card-title">Upcoming Events</h3>
            <p class="card-meta">Stay updated with the latest society events and celebrations.</p>
        </a>
        <a href="notices.php" class="modern-card" style="display: block; text-decoration: none;">
            <h3 class="card-title">Notice Board</h3>
            <p class="card-meta">Important announcements and society circulars.</p>
        </a>
        <a href="gallery.php" class="modern-card" style="display: block; text-decoration: none;">
            <h3 class="card-title">Photo Gallery</h3>
            <p class="card-meta">Memories from our past events and society infrastructure.</p>
        </a>
    </div>
    
    <div class="page-header" style="margin-top: 3rem;">
        <h2>Explore Society Information</h2>
        <p class="card-meta">Access public records and updates instantly.</p>
    </div>

<?php require_once("footer.php"); ?>