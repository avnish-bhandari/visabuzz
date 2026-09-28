<!-- Floating Pill Navigation Bar (Sticky Middle) -->
<header class="floating-navbar" id="floatingNavbar">
  <button class="nav-pill-btn" id="navPillToggle" aria-label="Open navigation menu" aria-expanded="false">
    <span class="pill-logo">
      <svg class="pill-logo-icon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2L2 22l10-4 10 4L12 2z" />
      </svg>
      <span class="pill-brand-name">Visabuz</span>
    </span>
    <span class="pill-hamburger" aria-hidden="true">
      <span class="pill-bar"></span>
      <span class="pill-bar"></span>
    </span>
  </button>
</header>

<!-- Fullscreen Blur Navigation Overlay -->
<div class="nav-overlay" id="navOverlay" aria-hidden="true">
  <div class="nav-overlay-backdrop" id="navOverlayBackdrop"></div>
  <div class="nav-overlay-container">

    <!-- Top Bar: Brand Logo & Close Button -->
    <div class="nav-overlay-top">
      <a href="#hero" class="nav-overlay-logo" id="overlayLogo">
        <svg class="overlay-logo-icon" width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2L2 22l10-4 10 4L12 2z" />
        </svg>
        <span>Visabuz</span>
      </a>
      <button class="nav-overlay-close" id="navOverlayClose" aria-label="Close navigation menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
          stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <!-- Middle Section: Left Image + Right Text Links -->
    <div class="nav-overlay-middle">

      <!-- Left Column: Featured Image -->
      <div class="nav-overlay-left">
        <div class="nav-image-card">
          <img src="https://framerusercontent.com/images/Hd1GsarYYENnlRSrEEn0UjS4mY.jpg" alt="Students celebrating admission abroad"
            class="nav-featured-img" />
        </div>
      </div>

      <!-- Right Column: Navigation Links -->
      <div class="nav-overlay-right">
        <nav class="nav-overlay-menu">
          <a href="#hero" class="overlay-link" data-index="1">
            <span class="link-label">Home</span>
          </a>
          <a href="#about" class="overlay-link" data-index="2">
            <span class="link-label">About Us</span>
          </a>
          <a href="#feature-tabs" class="overlay-link" data-index="3">
            <span class="link-label">Visa Services</span>
          </a>
          <a href="#destinations" class="overlay-link" data-index="4">
            <span class="link-label">Destinations</span>
          </a>
          <a href="#how-it-works" class="overlay-link" data-index="5">
            <span class="link-label">How It Works</span>
          </a>
          <a href="#book" class="overlay-link overlay-link-book" data-index="8">
            <span class="link-label">Book Consultation</span>
          </a>
        </nav>
      </div>

    </div>

    <!-- Bottom Bar: Contact Info & Socials -->
    <div class="nav-overlay-bottom">
      <div class="nav-overlay-contact">
        <span class="contact-eyebrow">Get In Touch</span>
        <a href="mailto:info@visabuz.com" class="contact-email">info@visabuz.com</a>
      </div>
      <div class="nav-overlay-socials">
        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-circle-btn"
          aria-label="Facebook">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
          </svg>
        </a>
        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-circle-btn"
          aria-label="Instagram">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
          </svg>
        </a>
        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-circle-btn"
          aria-label="LinkedIn">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
            <rect x="2" y="9" width="4" height="12"></rect>
            <circle cx="4" cy="4" r="2"></circle>
          </svg>
        </a>
      </div>
    </div>

  </div>
</div>
