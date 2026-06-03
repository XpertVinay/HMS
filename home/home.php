<?php require_once("header.php"); ?>

<!-- Close the main tag from header.php because we want hero section to be full width -->
</main>

<div class="hero">
    <div class="hero-content">
        <h1>Empowering Communities. <br><span class="highlight">Elevating Lives.</span></h1>
        <p>Experience day-to-day residential management at your fingertips. Businzo RCMS is a purpose-driven platform dedicated to making community living affordable, secure, and harmonious.</p>
        <div class="hero-buttons">
            <a href="../register.php" class="btn-login btn-hero">Join the Community</a>
            <a href="#about" class="btn-outline btn-hero">Learn More</a>
        </div>
    </div>
</div>

<main id="about">
    <div class="page-header" style="margin-top: 1rem;">
        <h2>A Platform with a <span class="highlight">Purpose</span></h2>
        <p class="card-meta" style="max-width: 800px; margin: 0 auto; font-size: 1.1rem; line-height: 1.8;">
            At Businzo, we believe a residential society is more than just a collection of houses; it's a living, breathing community. We provide a trustworthy, transparent platform designed specially for those who find high maintenance fees a burden.<br><br>
            Operating on a strong foundation of community welfare, Businzo ensures that your day-to-day society maintenance is handled seamlessly. To sustain this high-quality experience and continuous support, we operate with a minimal, transparent platform fee—ensuring that professional, reliable management remains accessible and completely affordable for everyone.
        </p>
    </div>

    <div class="card-grid" style="margin-top: 4rem;">
        <div class="modern-card">
            <div class="card-icon">🤝</div>
            <h3 class="card-title">Communities Supporting Communities</h3>
            <p class="card-meta">We encourage neighbors to stand by each other. Businzo fosters a culture of shared responsibilities and social support. From local help to community-driven initiatives, we ensure that no one is left behind.</p>
        </div>
        <div class="modern-card">
            <div class="card-icon">💡</div>
            <h3 class="card-title">Day-to-Day Needs at Your Fingertips</h3>
            <p class="card-meta">From paying bills to raising service requests, everything you need is right in your pocket. We secure your finances by keeping operational costs low, so you receive exceptional daily maintenance support at a fraction of the usual cost.</p>
        </div>
        <div class="modern-card">
            <div class="card-icon">🏛️</div>
            <h3 class="card-title">Inclusive Progress for Every Community</h3>
            <p class="card-meta">We are taking charge of community welfare by embracing the spirit of inclusive growth—ensuring shared development for all. We build a bridge between essential community needs and effective management.</p>
        </div>
        <div class="modern-card">
            <div class="card-icon">📈</div>
            <h3 class="card-title">Driving Employment and Growth</h3>
            <p class="card-meta">By connecting communities with essential service providers, Businzo is directly increasing employment opportunities for lower-income grades—with a vision to extend these opportunities. We help build local economies.</p>
        </div>
    </div>

    <div class="page-header why-choose-us" style="margin-top: 5rem; background: var(--bg-dark); color: #fff; padding: 4rem 2rem; border-radius: 16px;">
        <h2 style="color: #fff;">Why Choose <span class="highlight">Businzo?</span></h2>
        <div class="why-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 3rem; text-align: left;">
            <div>
                <h4 style="color: var(--secondary-color); font-size: 1.2rem; margin-bottom: 0.5rem;">Transparent & Trustworthy</h4>
                <p style="color: #cbd5e1; font-size: 0.95rem;">Enjoy premium community management tools sustained by a minimal platform fee, with absolutely zero hidden charges.</p>
            </div>
            <div>
                <h4 style="color: var(--secondary-color); font-size: 1.2rem; margin-bottom: 0.5rem;">Welfare-Driven</h4>
                <p style="color: #cbd5e1; font-size: 0.95rem;">We beautifully blend the heart of a Resident Welfare Association with the efficiency and reliability of a professional organization.</p>
            </div>
            <div>
                <h4 style="color: var(--secondary-color); font-size: 1.2rem; margin-bottom: 0.5rem;">Empowering Workforce</h4>
                <p style="color: #cbd5e1; font-size: 0.95rem;">Every time your society uses Businzo, you are helping generate local employment and supporting the broader economy.</p>
            </div>
            <div>
                <h4 style="color: var(--secondary-color); font-size: 1.2rem; margin-bottom: 0.5rem;">Peace of Mind</h4>
                <p style="color: #cbd5e1; font-size: 0.95rem;">Leave the daily administrative and maintenance tasks to us, so you can focus on enjoying a harmonious community life.</p>
            </div>
        </div>
    </div>

    <div class="page-header" style="margin-top: 5rem;">
        <h2>Explore Society Information</h2>
        <p class="card-meta">Access public records and updates instantly.</p>
    </div>
    
    <div class="card-grid">
        <a href="events.php" class="modern-card" style="display: block; text-decoration: none; text-align: center;">
            <h3 class="card-title">Upcoming Events</h3>
            <p class="card-meta">Stay updated with the latest society events.</p>
        </a>
        <a href="notices.php" class="modern-card" style="display: block; text-decoration: none; text-align: center;">
            <h3 class="card-title">Notice Board</h3>
            <p class="card-meta">Important announcements and society circulars.</p>
        </a>
        <a href="gallery.php" class="modern-card" style="display: block; text-decoration: none; text-align: center;">
            <h3 class="card-title">Photo Gallery</h3>
            <p class="card-meta">Memories from our past events.</p>
        </a>
    </div>

<?php require_once("footer.php"); ?>