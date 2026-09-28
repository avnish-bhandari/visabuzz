<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Visabuz — Study, Work &amp; Settle Abroad | Overseas Visa Consultancy</title>
  <meta name="description"
    content="Expert visa guidance for Canada, UK, Germany, Australia &amp; top global destinations. Student visas, work permits, tourist visas &amp; Canada PR." />

  <!-- Official Inter Display Fonts (rsms.me) -->
  <link rel="preconnect" href="https://rsms.me/" />
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

  <!-- Google Fonts: Inter Variable with Optical Sizing (opsz 14..32) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />

  <!-- Fontshare Fonts: Cabinet Grotesk (Headings) -->
  <link href="https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@500,700,800&display=swap" rel="stylesheet" />

  <!-- Google Fonts: Playfair Display (Italic accents) -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,400;1,500;1,600&display=swap"
    rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- Stylesheet -->
  <link rel="stylesheet" href="css/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body class="">

  <!-- Hero Section with Background -->
  <section class="hero-section" id="hero">
    <div class="hero-bg-overlay"></div>
    <!-- Floating Pill Navigation Bar & Fullscreen Overlay -->
    <?php include 'components/navbar.php'; ?>

    <!-- Hero Content Container -->
    <div class="hero-content">
      <div class="hero-layout">

        <!-- Left Column: Eyebrow, Main Title, and CTA Button -->
        <div class="hero-left">
          <span class="hero-eyebrow">Global Study, Work &amp; Travel Visa Experts</span>
          <h1 class="hero-title">
            Study, Work &amp;<br />
            Settle Abroad
          </h1>
          <div class="hero-cta-wrapper">
            <a href="#book" class="btn-primary" id="findHikeBtn">
              Book Free Consultation
            </a>
          </div>
        </div>

        <!-- Right Column: Description Text & Filter Tags -->
        <div class="hero-right">
          <p class="hero-description">
            Expert visa guidance for Canada, UK, Germany &amp; top global destinations. We simplify your journey with honest advice and end-to-end support.
          </p>
          <div class="category-filters" role="group" aria-label="Visa Categories">
            <button class="filter-pill active" data-category="student" id="filterStudent">
              <span class="pill-icon" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                  <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
              </span>
              <span class="pill-label">Student Visa</span>
            </button>
            <button class="filter-pill" data-category="work" id="filterWork">
              <span class="pill-icon" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                  <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
              </span>
              <span class="pill-label">Work Visa</span>
            </button>
            <button class="filter-pill" data-category="pr" id="filterPR">
              <span class="pill-icon" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2L2 22l10-4 10 4L12 2z" />
                </svg>
              </span>
              <span class="pill-label">Canada PR</span>
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Who We Are / About Section -->
  <section class="about-section" id="about">
    <div class="about-container">
      <div class="about-layout">

        <!-- Left Column: Copy, CTA & Reviews -->
        <div class="about-col about-col-left">
          <div class="about-header-group">
            <span class="about-eyebrow">
              <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> Who We Are
            </span>
            <h2 class="about-title">
              Study, Work &amp;<br />
              Settle Abroad &mdash;<br />
              Made Simple
            </h2>
            <p class="about-text">
              At Visabuz, we believe borders should never limit ambition. We are a trusted overseas education and immigration consultancy, helping individuals and families access global opportunities through expert guidance in student, work, tourist, and permanent residency visas.
            </p>
            <div class="about-cta">
              <a href="#book" class="btn-dark" id="ourStoryBtn">Request Consultation</a>
            </div>
          </div>

          <!-- Social Proof / Reviews -->
          <div class="about-social">
            <div class="avatar-group">
              <img src="https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg" alt="Priya R. client avatar" class="avatar-img" />
              <img src="https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg" alt="Aman K. student avatar" class="avatar-img" />
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Client avatar" class="avatar-img" />
              <div class="avatar-badge">176+</div>
            </div>
            <div class="social-meta">
              <div class="rating-stars">
                <div class="stars-icons" aria-label="5 out of 5 stars">
                  <svg class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </div>
                <span class="rating-score">4.9/5</span>
              </div>
              <span class="explorers-count">Trusted by 176+ Students</span>
            </div>
          </div>
        </div>

        <!-- Center Column: Portrait Photo -->
        <div class="about-col about-col-center">
          <div class="hiker-photo-wrapper">
            <img src="https://framerusercontent.com/images/Hd1GsarYYENnlRSrEEn0UjS4mY.jpg" alt="Visabuz overseas education and study visa consultation" class="hiker-main-img" />
          </div>
        </div>

        <!-- Right Column: Stats List & Story Card -->
        <div class="about-col about-col-right">
          <!-- Stats List with Subtle Dividing Lines -->
          <div class="stats-list">
            <div class="stat-row">
              <span class="stat-label">Success Rate</span>
              <span class="stat-value">98% visa approval</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">Students Guided</span>
              <span class="stat-value">176+ placed</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">Global Destinations</span>
              <span class="stat-value">10+ countries</span>
            </div>
          </div>

          <!-- "Every trip, a new story" Card -->
          <div class="story-card">
            <h3 class="story-card-title">Every journey, a new future</h3>
            <p class="story-card-desc">
              From university shortlisting to visa approval &mdash; we guide every single step.
            </p>

            <!-- Fanned Photo Cards -->
            <div class="fanned-deck" id="fannedDeck">
              <!-- Left Card: Work Visa -->
              <div class="deck-card card-left" data-story="work" id="cardWork">
                <img src="https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg" alt="Work abroad and build a global career" />
              </div>
              <!-- Center Card: Student Visa (Active) -->
              <div class="deck-card card-center active" data-story="student" id="cardStudent">
                <img src="https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg" alt="Study abroad with confidence" />
              </div>
              <!-- Right Card: Canada PR -->
              <div class="deck-card card-right" data-story="pr" id="cardPR">
                <img src="https://framerusercontent.com/images/Y3vLgrwPWPDMhYwwMsixVo50B24.png" alt="Canada Permanent Residency pathways" />
              </div>
            </div>

            <!-- Icon Controls -->
            <div class="deck-controls" role="group" aria-label="Visa Pathways View Controls">
              <button class="deck-btn" data-target="work" aria-label="View work visa pathways" id="btnStoryWork">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                  stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                  <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
              </button>
              <button class="deck-btn active" data-target="student" aria-label="View student visa stories"
                id="btnStoryStudent">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                  <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
              </button>
              <button class="deck-btn" data-target="pr" aria-label="View Canada PR pathways" id="btnStoryPR">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2L2 22l10-4 10 4L12 2z" />
                </svg>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Interactive Feature Tabs Showcase Section -->
  <section class="feature-tabs-section" id="feature-tabs">
    <div class="feature-tabs-container">

      <!-- Section Header -->
      <div class="feature-tabs-header">
        <h2 class="feature-tabs-title">Comprehensive Visa Services &amp; Pathways</h2>

        <!-- Category Top Filter Pills -->
        <ul class="nav nav-pills feature-category-pills" id="categoryPillsTab" role="tablist" aria-label="Visa Categories">
          <li class="nav-item" role="presentation">
            <button class="nav-link cat-pill-btn active" id="catPillStudy" data-bs-toggle="pill" data-bs-target="#category-pane-study" type="button" role="tab" aria-controls="category-pane-study" aria-selected="true" data-category="study">
              <span class="cat-pill-icon" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                  <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
              </span>
              <span class="cat-pill-text">Study Global</span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link cat-pill-btn" id="catPillOfferings" data-bs-toggle="pill" data-bs-target="#category-pane-offerings" type="button" role="tab" aria-controls="category-pane-offerings" aria-selected="false" data-category="offerings">
              <span class="cat-pill-icon cat-icon-amber" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                  <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
              </span>
              <span class="cat-pill-text">Offerings</span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link cat-pill-btn" id="catPillPlatform" data-bs-toggle="pill" data-bs-target="#category-pane-platform" type="button" role="tab" aria-controls="category-pane-platform" aria-selected="false" data-category="platform">
              <span class="cat-pill-icon cat-icon-purple" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M4 4h7v7H4V4zm10 0h6v7h-6V4zM4 14h7v6H4v-6zm10 0h6v6h-6v-6z"/>
                </svg>
              </span>
              <span class="cat-pill-text">Platform</span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link cat-pill-btn" id="catPillResources" data-bs-toggle="pill" data-bs-target="#category-pane-resources" type="button" role="tab" aria-controls="category-pane-resources" aria-selected="false" data-category="resources">
              <span class="cat-pill-icon cat-icon-emerald" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
              </span>
              <span class="cat-pill-text">Resources</span>
            </button>
          </li>
        </ul>
      </div>

      <!-- Category Panes Wrapper -->
      <div class="tab-content" id="categoryTabsContent">

        <!-- ======================================================================
             CATEGORY 1: STUDY GLOBAL
             ====================================================================== -->
        <div class="tab-pane fade show active" id="category-pane-study" role="tabpanel" aria-labelledby="catPillStudy">
          <div class="feature-card-wrapper">
            <div class="feature-card-elevated">

              <!-- Left: Vertical Feature Tabs (9 Countries) -->
              <div class="nav flex-column nav-pills feature-vertical-nav" id="studyVerticalTab" role="tablist" aria-orientation="vertical" aria-label="Study Destinations">
                <button class="nav-link feature-vtab-btn active" id="vTab-study-uk" data-bs-toggle="pill" data-bs-target="#panel-study-uk" type="button" role="tab" aria-controls="panel-study-uk" aria-selected="true">
                  <span>Study in UK</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-usa" data-bs-toggle="pill" data-bs-target="#panel-study-usa" type="button" role="tab" aria-controls="panel-study-usa" aria-selected="false">
                  <span>Study in USA</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-ireland" data-bs-toggle="pill" data-bs-target="#panel-study-ireland" type="button" role="tab" aria-controls="panel-study-ireland" aria-selected="false">
                  <span>Study in Ireland</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-canada" data-bs-toggle="pill" data-bs-target="#panel-study-canada" type="button" role="tab" aria-controls="panel-study-canada" aria-selected="false">
                  <span>Study in Canada</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-germany" data-bs-toggle="pill" data-bs-target="#panel-study-germany" type="button" role="tab" aria-controls="panel-study-germany" aria-selected="false">
                  <span>Study in Germany</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-dubai" data-bs-toggle="pill" data-bs-target="#panel-study-dubai" type="button" role="tab" aria-controls="panel-study-dubai" aria-selected="false">
                  <span>Study in Dubai</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-france" data-bs-toggle="pill" data-bs-target="#panel-study-france" type="button" role="tab" aria-controls="panel-study-france" aria-selected="false">
                  <span>Study in France</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-europe" data-bs-toggle="pill" data-bs-target="#panel-study-europe" type="button" role="tab" aria-controls="panel-study-europe" aria-selected="false">
                  <span>Study in Europe</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-study-italy" data-bs-toggle="pill" data-bs-target="#panel-study-italy" type="button" role="tab" aria-controls="panel-study-italy" aria-selected="false">
                  <span>Study in Italy</span>
                </button>
              </div>

              <!-- Right / Inner Main Content Panel -->
              <div class="tab-content feature-inner-panel" id="studyInnerContent">

                <!-- 1. Study in UK -->
                <div class="tab-pane fade show active feature-tab-content" id="panel-study-uk" role="tabpanel" aria-labelledby="vTab-study-uk">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Russell Group &amp; Tier-1 Admissions</h4>
                          <p class="feature-item-desc">
                            Direct placement guidance for Oxford, Cambridge, Imperial, UCL, King's, and Manchester with personalized portfolio optimization.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Accelerated 1-Year Master's Degrees</h4>
                          <p class="feature-item-desc">
                            Complete globally recognized postgraduate programs in 12 months, reducing tuition costs and accelerating your return on investment.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">2-Year Graduate Route Work Visa</h4>
                          <p class="feature-item-desc">
                            Post-study employment authorization across England, Scotland, Wales, and Northern Ireland with employer sponsorship transition.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=uk" class="feature-btn-primary">Explore UK Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=900&q=80" alt="Students studying in the United Kingdom" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 2. Study in USA -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-usa" role="tabpanel" aria-labelledby="vTab-study-usa">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Ivy League &amp; Top STEM Universities</h4>
                          <p class="feature-item-desc">
                            Targeted applications for MIT, Stanford, UC Berkeley, Columbia, and Carnegie Mellon with comprehensive GRE and profile evaluation.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Up to 3-Year STEM OPT Work Rights</h4>
                          <p class="feature-item-desc">
                            Qualify for 36 months of lawful full-time work authorization upon graduating from STEM-eligible degree programs across the United States.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">F-1 Visa Auditing &amp; TA/RA Scholarships</h4>
                          <p class="feature-item-desc">
                            High-approval consular filing with mock visa interviews, assistantship applications, and merit fee waiver assistance.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=usa" class="feature-btn-primary">Explore US Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=900&q=80" alt="Students on a university campus in the USA" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 3. Study in Ireland -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-ireland" role="tabpanel" aria-labelledby="vTab-study-ireland">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">European Hub for Tech &amp; Pharma Giants</h4>
                          <p class="feature-item-desc">
                            Study alongside EMEA headquarters of Google, Apple, Meta, Pfizer, and Stripe with industry co-op placements.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">2-Year Post-Graduation Stay-Back Visa</h4>
                          <p class="feature-item-desc">
                            Third Level Graduate Scheme grants master's graduates two full years to work and convert into Critical Skills Employment Permits.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Trinity College Dublin, UCD &amp; Galway</h4>
                          <p class="feature-item-desc">
                            Globally ranked English-speaking higher education with tuition fees significantly lower than the US and UK.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=ireland" class="feature-btn-primary">Explore Ireland Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1549918864-48ac978761a4?auto=format&fit=crop&w=900&q=80" alt="Students studying in Ireland" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 4. Study in Canada -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-canada" role="tabpanel" aria-labelledby="vTab-study-canada">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Designated Learning Institutions (DLI)</h4>
                          <p class="feature-item-desc">
                            Direct admissions to premier universities like University of Toronto, UBC, McGill, Waterloo, and leading post-grad colleges.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Up to 3-Year PGWP Work Permit</h4>
                          <p class="feature-item-desc">
                            Earn an open post-graduation work permit allowing you to work full-time for any Canadian employer anywhere in the country.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Seamless Pathway to Canada PR</h4>
                          <p class="feature-item-desc">
                            Canadian degree credentials and Canadian work experience earn substantial bonus CRS points for Express Entry and Provincial Nominees.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=canada" class="feature-btn-primary">Explore Canada Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80" alt="Students studying in Canada" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 5. Study in Germany -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-germany" role="tabpanel" aria-labelledby="vTab-study-germany">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Zero or Near-Zero Tuition Public Universities</h4>
                          <p class="feature-item-desc">
                            World-class engineering and IT education at TU Munich, RWTH Aachen, and Heidelberg with virtually no tuition fees.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">18-Month Job Seeking Stay-Back Visa</h4>
                          <p class="feature-item-desc">
                            Generous post-study transition visa to secure professional employment, leading swiftly to the EU Blue Card.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">APS Certification &amp; Blocked Account</h4>
                          <p class="feature-item-desc">
                            Complete end-to-end guidance for APS verification, blocked account funding, and German embassy visa appointments.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=germany" class="feature-btn-primary">Explore Germany Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1564981797816-1043664bf78d?auto=format&fit=crop&w=900&q=80" alt="Students studying in Germany" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 6. Study in Dubai -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-dubai" role="tabpanel" aria-labelledby="vTab-study-dubai">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Prestigious International Branch Campuses</h4>
                          <p class="feature-item-desc">
                            Earn accredited British, Australian, and US degrees in Dubai from campuses like Heriot-Watt, Wollongong, and Middlesex.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Fast-Track 2-Week Student Visa</h4>
                          <p class="feature-item-desc">
                            Hassle-free visa documentation with near 100% approval rates, minimal financial red tape, and part-time work rights.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Tax-Free Career Hub &amp; Green Visas</h4>
                          <p class="feature-item-desc">
                            Step directly into high-growth corporate careers in finance, technology, logistics, and AI with zero personal income tax.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=dubai" class="feature-btn-primary">Explore Dubai Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=900&q=80" alt="Students studying in Dubai UAE" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 7. Study in France -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-france" role="tabpanel" aria-labelledby="vTab-study-france">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Elite Grandes Écoles &amp; Universities</h4>
                          <p class="feature-item-desc">
                            Top global management and engineering schools including HEC Paris, INSEAD, ESSEC, and Sorbonne with English curricula.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">CAF Government Housing Allowance</h4>
                          <p class="feature-item-desc">
                            All international students are eligible for up to 40% government rent subsidies (CAF) plus free French state healthcare.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">2-Year Post-Study Visa (APS / RECE)</h4>
                          <p class="feature-item-desc">
                            Master's degree holders receive 2 years of residence authorization with fast transition to the prestigious French Talent Passport.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=france" class="feature-btn-primary">Explore France Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=900&q=80" alt="Students studying in France" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 8. Study in Europe -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-europe" role="tabpanel" aria-labelledby="vTab-study-europe">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">27+ Schengen Countries Mobility</h4>
                          <p class="feature-item-desc">
                            A single national student visa allows seamless travel, internships, and cultural discovery across the entire European Schengen zone.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Netherlands, Sweden &amp; Switzerland</h4>
                          <p class="feature-item-desc">
                            High English proficiency rates, innovative tech incubators, and exceptional quality of life across top European destinations.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Erasmus+ &amp; Double Degree Options</h4>
                          <p class="feature-item-desc">
                            Gain credentials from multiple universities through funded European Union exchange programs and dual master's degrees.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=europe" class="feature-btn-primary">Explore Europe Options</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=900&q=80" alt="Students studying across Continental Europe" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 9. Study in Italy -->
                <div class="tab-pane fade feature-tab-content" id="panel-study-italy" role="tabpanel" aria-labelledby="vTab-study-italy">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Historic World-Class Institutions</h4>
                          <p class="feature-item-desc">
                            Study design, fashion, architecture, and engineering at Politecnico di Milano, University of Bologna, and Sapienza Rome.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">DSU Regional Scholarships &amp; Free Tuition</h4>
                          <p class="feature-item-desc">
                            Need-based DSU scholarships offer complete tuition waivers, free cafeteria meals, and up to €7,000 annual living stipends.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">1-Year Stay-Back &amp; DOV Assistance</h4>
                          <p class="feature-item-desc">
                            Declaration of Value (DOV) filing, Universitaly pre-enrollment management, and Post-Study Search of Employment Permit support.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="study-global.php?country=italy" class="feature-btn-primary">Explore Italy Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=900&q=80" alt="Students studying in Italy" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================================
             CATEGORY 2: OFFERINGS
             ====================================================================== -->
        <div class="tab-pane fade" id="category-pane-offerings" role="tabpanel" aria-labelledby="catPillOfferings">
          <div class="feature-card-wrapper">
            <div class="feature-card-elevated">

              <!-- Left: Vertical Feature Tabs (4 Offerings) -->
              <div class="nav flex-column nav-pills feature-vertical-nav" id="offeringsVerticalTab" role="tablist" aria-orientation="vertical" aria-label="Offerings Categories">
                <button class="nav-link feature-vtab-btn active" id="vTab-off-study" data-bs-toggle="pill" data-bs-target="#panel-off-study" type="button" role="tab" aria-controls="panel-off-study" aria-selected="true">
                  <span>Study Global</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-off-work" data-bs-toggle="pill" data-bs-target="#panel-off-work" type="button" role="tab" aria-controls="panel-off-work" aria-selected="false">
                  <span>Work Global</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-off-online" data-bs-toggle="pill" data-bs-target="#panel-off-online" type="button" role="tab" aria-controls="panel-off-online" aria-selected="false">
                  <span>Learn Online</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-off-local" data-bs-toggle="pill" data-bs-target="#panel-off-local" type="button" role="tab" aria-controls="panel-off-local" aria-selected="false">
                  <span>Study Local</span>
                </button>
              </div>

              <!-- Right / Inner Main Content Panel -->
              <div class="tab-content feature-inner-panel" id="offeringsInnerContent">

                <!-- 1. Offerings: Study Global -->
                <div class="tab-pane fade show active feature-tab-content" id="panel-off-study" role="tabpanel" aria-labelledby="vTab-off-study">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">End-to-End Overseas Placement</h4>
                          <p class="feature-item-desc">
                            Personalized course evaluation, university shortlisting, and direct partner applications across 800+ top universities worldwide.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Admissions &amp; Visa Assurance</h4>
                          <p class="feature-item-desc">
                            Dedicated counseling mentors ensuring 98.7% visa success rates with rigorous document audits and mock interview sessions.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Guaranteed Scholarship Guidance</h4>
                          <p class="feature-item-desc">
                            Access exclusive institutional fee waivers, departmental bursaries, and merit-based international scholarships.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Explore Study Pathways</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80" alt="Students graduating from global universities" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 2. Offerings: Work Global -->
                <div class="tab-pane fade feature-tab-content" id="panel-off-work" role="tabpanel" aria-labelledby="vTab-off-work">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Skilled Migration &amp; Points Evaluation</h4>
                          <p class="feature-item-desc">
                            Points assessment and filing for Germany Opportunity Card (Chancenkarte), UK Skilled Worker, and Canada Express Entry.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Employer Sponsorship &amp; Compliance</h4>
                          <p class="feature-item-desc">
                            Complete assistance for LMIA certifications, Certificate of Sponsorship (CoS), and employer compliance requirements.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">International Relocation Onboarding</h4>
                          <p class="feature-item-desc">
                            Biometric scheduling, visa stamping follow-ups, tax residency guidance, and overseas banking setup before departure.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Explore Work Visas</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=900&q=80" alt="Professionals working globally" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 3. Offerings: Learn Online -->
                <div class="tab-pane fade feature-tab-content" id="panel-off-online" role="tabpanel" aria-labelledby="vTab-off-online">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Accredited International Online Degrees</h4>
                          <p class="feature-item-desc">
                            Earn recognized master's and bachelor's degrees from accredited US and UK universities at up to 70% lower tuition costs.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Flexible Working Professional Curricula</h4>
                          <p class="feature-item-desc">
                            Self-paced modules in AI, Data Science, Cyber Security, and Global MBA designed for busy working professionals.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Hybrid On-Campus Transfer Options</h4>
                          <p class="feature-item-desc">
                            Study Year 1 online from home and transfer directly to an overseas campus for final year completion and work permits.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Explore Online Programs</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?auto=format&fit=crop&w=900&q=80" alt="Online learning and executive education" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 4. Offerings: Study Local -->
                <div class="tab-pane fade feature-tab-content" id="panel-off-local" role="tabpanel" aria-labelledby="vTab-off-local">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Premier Domestic Universities</h4>
                          <p class="feature-item-desc">
                            Discover top-tier national institutions offering industry-aligned degrees, state-of-the-art labs, and strong placement cells.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">International 2+2 Twinning Programs</h4>
                          <p class="feature-item-desc">
                            Complete two foundational years locally and transition abroad to graduate with an international degree at half the total cost.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Credit Transfer &amp; Articulation</h4>
                          <p class="feature-item-desc">
                            Verified university credit evaluation ensuring smooth academic equivalence for future global higher education pursuits.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Explore Local Options</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=900&q=80" alt="Students in a university classroom" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================================
             CATEGORY 3: PLATFORM
             ====================================================================== -->
        <div class="tab-pane fade" id="category-pane-platform" role="tabpanel" aria-labelledby="catPillPlatform">
          <div class="feature-card-wrapper">
            <div class="feature-card-elevated">

              <!-- Left: Vertical Feature Tabs (4 Platform Services) -->
              <div class="nav flex-column nav-pills feature-vertical-nav" id="platformVerticalTab" role="tablist" aria-orientation="vertical" aria-label="Platform Services">
                <button class="nav-link feature-vtab-btn active" id="vTab-plat-finance" data-bs-toggle="pill" data-bs-target="#panel-plat-finance" type="button" role="tab" aria-controls="panel-plat-finance" aria-selected="true">
                  <span>Financial Services</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-plat-housing" data-bs-toggle="pill" data-bs-target="#panel-plat-housing" type="button" role="tab" aria-controls="panel-plat-housing" aria-selected="false">
                  <span>Affordable &amp; Safe Housing</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-plat-visa" data-bs-toggle="pill" data-bs-target="#panel-plat-visa" type="button" role="tab" aria-controls="panel-plat-visa" aria-selected="false">
                  <span>Visa &amp; Citizen Services</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-plat-career" data-bs-toggle="pill" data-bs-target="#panel-plat-career" type="button" role="tab" aria-controls="panel-plat-career" aria-selected="false">
                  <span>Continuous Career Support</span>
                </button>
              </div>

              <!-- Right / Inner Main Content Panel -->
              <div class="tab-content feature-inner-panel" id="platformInnerContent">

                <!-- 1. Platform: Financial Services -->
                <div class="tab-pane fade show active feature-tab-content" id="panel-plat-finance" role="tabpanel" aria-labelledby="vTab-plat-finance">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Collateral-Free Education Loans</h4>
                          <p class="feature-item-desc">
                            Fast sanctioning up to ₹1.5 Crore ($180K USD) across 15+ premier public, private banks, and global international NBFCs.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Germany Blocked Account &amp; Canada GIC</h4>
                          <p class="feature-item-desc">
                            Instant digital setup for German blocked accounts (Fintiba/Expatrio) and Canadian GIC accounts with zero paperwork friction.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Zero-Markup Forex Cards &amp; Wire Transfers</h4>
                          <p class="feature-item-desc">
                            Save up to 3% on university tuition fee transfers and international student debit cards with real-time exchange rates.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Explore Financial Services</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=900&q=80" alt="Student education finance and loan services" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 2. Platform: Affordable & Safe Housing -->
                <div class="tab-pane fade feature-tab-content" id="panel-plat-housing" role="tabpanel" aria-labelledby="vTab-plat-housing">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Verified Student Accommodations</h4>
                          <p class="feature-item-desc">
                            Search over 50,000 vetted rooms, shared apartments, and student dormitories within walking distance of global campuses.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Furnished Living with All Bills Included</h4>
                          <p class="feature-item-desc">
                            High-speed Wi-Fi, electricity, water, and central heating fully covered in rent with 24/7 on-site concierge and security.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Zero Brokerage &amp; Visa Cancellation Guarantee</h4>
                          <p class="feature-item-desc">
                            Direct landlord agreements with zero middleman fees and 100% refund policy in the rare event of visa delay or refusal.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Find Student Housing</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=900&q=80" alt="Safe and affordable modern student housing" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 3. Platform: Visa & Citizen Services -->
                <div class="tab-pane fade feature-tab-content" id="panel-plat-visa" role="tabpanel" aria-labelledby="vTab-plat-visa">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Embassy Dossier Auditing &amp; Compliance</h4>
                          <p class="feature-item-desc">
                            Strict verification of sponsorship affidavits, source of funds, income proofs, and bank statements to eliminate refusal risks.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">VFS &amp; Consular Biometrics Scheduling</h4>
                          <p class="feature-item-desc">
                            Early slot notifications, rapid biometric appointment booking, and direct liaison with consular processing centers.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Mock Interviews with Visa Specialists</h4>
                          <p class="feature-item-desc">
                            Realistic interview drills simulating US F-1, German consular, and UK credibility interviews to build complete confidence.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Book Visa Consultation</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=900&q=80" alt="Visa and consular legal consultation" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 4. Platform: Continuous Career Support -->
                <div class="tab-pane fade feature-tab-content" id="panel-plat-career" role="tabpanel" aria-labelledby="vTab-plat-career">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">ATS-Optimized Global Resumes &amp; CVs</h4>
                          <p class="feature-item-desc">
                            Professional transformation of your CV into country-compliant formats (Europass, US Resume, UK CV) tailored for recruiters.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Global Alumni &amp; Corporate Mentorship</h4>
                          <p class="feature-item-desc">
                            1-on-1 networking with alumni currently working in high-growth companies across London, Toronto, Berlin, and Dublin.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Post-Study Career Placement Bootcamps</h4>
                          <p class="feature-item-desc">
                            Interview preparation masterclasses, LinkedIn personal branding, and direct referrals to hiring corporate partners.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Access Career Support</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=900&q=80" alt="Career mentorship and global employment training" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================================
             CATEGORY 4: RESOURCES
             ====================================================================== -->
        <div class="tab-pane fade" id="category-pane-resources" role="tabpanel" aria-labelledby="catPillResources">
          <div class="feature-card-wrapper">
            <div class="feature-card-elevated">

              <!-- Left: Vertical Feature Tabs (8 Resources) -->
              <div class="nav flex-column nav-pills feature-vertical-nav" id="resourcesVerticalTab" role="tablist" aria-orientation="vertical" aria-label="Resources Categories">
                <button class="nav-link feature-vtab-btn active" id="vTab-res-lor" data-bs-toggle="pill" data-bs-target="#panel-res-lor" type="button" role="tab" aria-controls="panel-res-lor" aria-selected="true">
                  <span>LOR</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-sop" data-bs-toggle="pill" data-bs-target="#panel-res-sop" type="button" role="tab" aria-controls="panel-res-sop" aria-selected="false">
                  <span>SOP</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-ielts" data-bs-toggle="pill" data-bs-target="#panel-res-ielts" type="button" role="tab" aria-controls="panel-res-ielts" aria-selected="false">
                  <span>IELTS</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-gmat" data-bs-toggle="pill" data-bs-target="#panel-res-gmat" type="button" role="tab" aria-controls="panel-res-gmat" aria-selected="false">
                  <span>GMAT</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-gre" data-bs-toggle="pill" data-bs-target="#panel-res-gre" type="button" role="tab" aria-controls="panel-res-gre" aria-selected="false">
                  <span>GRE</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-sat" data-bs-toggle="pill" data-bs-target="#panel-res-sat" type="button" role="tab" aria-controls="panel-res-sat" aria-selected="false">
                  <span>SAT</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-toefl" data-bs-toggle="pill" data-bs-target="#panel-res-toefl" type="button" role="tab" aria-controls="panel-res-toefl" aria-selected="false">
                  <span>TOEFL</span>
                </button>
                <button class="nav-link feature-vtab-btn" id="vTab-res-pte" data-bs-toggle="pill" data-bs-target="#panel-res-pte" type="button" role="tab" aria-controls="panel-res-pte" aria-selected="false">
                  <span>PTE</span>
                </button>
              </div>

              <!-- Right / Inner Main Content Panel -->
              <div class="tab-content feature-inner-panel" id="resourcesInnerContent">

                <!-- 1. Resources: LOR -->
                <div class="tab-pane fade show active feature-tab-content" id="panel-res-lor" role="tabpanel" aria-labelledby="vTab-res-lor">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Academic &amp; Professional Draft Frameworks</h4>
                          <p class="feature-item-desc">
                            Structuring high-credibility recommendation letters emphasizing research rigor, intellectual curiosity, and workplace leadership.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Professor &amp; Manager Briefing Kits</h4>
                          <p class="feature-item-desc">
                            Ready-to-use recommendation questionnaire sheets for faculty and supervisors to draft strong, personalized endorsements.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Tone &amp; Plagiarism Audits</h4>
                          <p class="feature-item-desc">
                            Thorough reviews verifying distinct writing tones across multiple recommenders and ensuring 100% originality.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Download LOR Guides</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=900&q=80" alt="Letter of recommendation and academic writing" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 2. Resources: SOP -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-sop" role="tabpanel" aria-labelledby="vTab-res-sop">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Compelling Personal Narrative Frameworks</h4>
                          <p class="feature-item-desc">
                            Transforming your background into a coherent story that highlights intellectual passion, resilience, and vision.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">University-Specific Motivation Alignment</h4>
                          <p class="feature-item-desc">
                            Tailor each statement to exact lab faculty research, curriculum electives, campus centers, and community values.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Senior Admissions Editors Review</h4>
                          <p class="feature-item-desc">
                            Multi-tier editing by ivy-league graduates checking rhetorical structure, clarity, word economy, and impact.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Request SOP Review</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=900&q=80" alt="Student drafting statement of purpose" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 3. Resources: IELTS -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-ielts" role="tabpanel" aria-labelledby="vTab-res-ielts">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Band 8+ Targeted 4-Module Strategy</h4>
                          <p class="feature-item-desc">
                            Specialized coaching across Academic Reading skimming, Listening note-taking, and cohesive Writing Task 1 &amp; 2 structures.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">1-on-1 Certified Examiner Speaking Drills</h4>
                          <p class="feature-item-desc">
                            Live face-to-face mock speaking evaluations grading fluency, lexical resource, grammatical accuracy, and pronunciation.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Full Computer-Delivered Mock Tests</h4>
                          <p class="feature-item-desc">
                            Access timed practice simulations replicating official British Council and IDP test screen interfaces with instant feedback.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Start IELTS Prep</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=900&q=80" alt="IELTS study and examination preparation" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 4. Resources: GMAT -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-gmat" role="tabpanel" aria-labelledby="vTab-res-gmat">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">GMAT Focus Edition 705+ Blueprint</h4>
                          <p class="feature-item-desc">
                            Targeted drills covering Data Insights, Problem Solving, and Critical Reasoning with proprietary time-management formulas.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Adaptive Computer Algorithm Simulations</h4>
                          <p class="feature-item-desc">
                            Practice on calibrated adaptive mock test engines that adjust question difficulty dynamically just like GMAC's real test.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Top 1% Percentile MBA Mentorship</h4>
                          <p class="feature-item-desc">
                            Weekly live problem-solving clinics mentored by 99th-percentile scorers and top global business school alumni.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Start GMAT Prep</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80" alt="GMAT business analysis and quantitative study" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 5. Resources: GRE -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-gre" role="tabpanel" aria-labelledby="vTab-res-gre">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">GRE 325+ High Score Roadmap</h4>
                          <p class="feature-item-desc">
                            Master high-yield vocabulary mnemonics, Text Completion patterns, and Sentence Equivalence logic shortcuts.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Advanced Quantitative Problem-Solving</h4>
                          <p class="feature-item-desc">
                            Comprehensive coverage of Algebra, Geometry, and Data Interpretation for engineering and STEM graduate admissions.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Analytical Writing (AWA) Templates</h4>
                          <p class="feature-item-desc">
                            Issue task frameworks and argumentation templates designed to consistently secure a 4.5+ score on the essay section.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Start GRE Prep</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=80" alt="GRE graduate exam preparation and quantitative math" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 6. Resources: SAT -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-sat" role="tabpanel" aria-labelledby="vTab-res-sat">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Digital SAT 1500+ Preparation</h4>
                          <p class="feature-item-desc">
                            Master the adaptive Bluebook testing format with built-in Desmos graphing calculator hacks and timing pacing.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Reading &amp; Writing Module Drills</h4>
                          <p class="feature-item-desc">
                            Rapid rhetorical analysis, transitions, and standard English punctuation rules for maximum verbal point accumulation.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">AI Diagnostics &amp; Score Improvement Guarantee</h4>
                          <p class="feature-item-desc">
                            Targeted diagnostic analytics identifying exact concept vulnerabilities for fast, measurable score jumps.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Start SAT Prep</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=900&q=80" alt="Students studying for the SAT test" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 7. Resources: TOEFL -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-toefl" role="tabpanel" aria-labelledby="vTab-res-toefl">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">TOEFL iBT 105+ Score Guarantee</h4>
                          <p class="feature-item-desc">
                            Specialized strategies for the streamlined 2-hour TOEFL iBT format, including Writing for an Academic Discussion.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Speech Clarity &amp; Acoustic Analysis</h4>
                          <p class="feature-item-desc">
                            AI voice feedback coaching on pauses, intonation, and response structure for integrated speaking tasks.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">Official ETS Practice Tests</h4>
                          <p class="feature-item-desc">
                            Full-length authentic retired test papers graded using official ETS SpeechRater and e-rater scoring algorithms.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Start TOEFL Prep</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80" alt="Student with headphones preparing for TOEFL exam" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

                <!-- 8. Resources: PTE -->
                <div class="tab-pane fade feature-tab-content" id="panel-res-pte" role="tabpanel" aria-labelledby="vTab-res-pte">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-green" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">PTE Academic 79+ (Band 8 Equivalent)</h4>
                          <p class="feature-item-desc">
                            Master Pearson AI scoring logic for Read Aloud, Repeat Sentence, and Re-tell Lecture to secure maximum points.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-purple" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">High-Weight Task Templates &amp; Formulas</h4>
                          <p class="feature-item-desc">
                            High-scoring grammar templates for Summarize Spoken Text and Write From Dictation with 100% spelling precision.
                          </p>
                        </div>
                      </div>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon badge-blue" aria-hidden="true">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                          </svg>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title">14-Day Intensive Fast-Track Bootcamp</h4>
                          <p class="feature-item-desc">
                            Daily computer mock tests with AI score breakdown, pronunciation metrics, and personalized booster sessions.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="feature-action-row">
                      <a href="#book" class="feature-btn-primary">Start PTE Prep</a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=900&q=80" alt="Student preparing for PTE academic certification on laptop" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Top Study & Immigration Destinations Section (Sticky Scroll Experience) -->
  <div class="destinations-scroll-track" id="destinationsTrack">
    <section class="destinations-section" id="destinations">
      <!-- Cross-fading Fullscreen Background Images -->
      <div class="destinations-bg" id="destinationsBg">
        <img src="https://images.unsplash.com/photo-1517935703635-27c946e65452?auto=format&fit=crop&w=1920&q=80" alt="Canada scenic skyline background" class="destinations-bg-img is-active"
          data-dest-bg="0" />
        <img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=1920&q=80" alt="United Kingdom London background" class="destinations-bg-img"
          data-dest-bg="1" />
        <img src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=1920&q=80" alt="Germany historic background" class="destinations-bg-img"
          data-dest-bg="2" />
        <img src="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=1920&q=80" alt="Australia Sydney harbour background" class="destinations-bg-img"
          data-dest-bg="3" />
        <div class="destinations-bg-overlay"></div>
      </div>

      <div class="destinations-container">
        <!-- Eyebrow with globe icon -->
        <div class="destinations-eyebrow">
          <span class="eyebrow-chevron" style="color: white;" aria-hidden="true">&rsaquo;</span>
          <span>Top Global Destinations</span>
        </div>

        <!-- Section Title -->
        <h2 class="destinations-title">
          Explore The World's Leading<br />
          Study &amp; Visa Hubs
        </h2>

        <!-- 3D Perspective Flip Stage for Destination Cards -->
        <div class="dest-stage-wrapper">
          <div class="dest-stage" id="destStage">

            <!-- Card 0: Canada -->
            <div class="dest-card-item is-active" data-dest-index="0">
              <div class="destination-card-wrapper">
                <div class="destination-card" id="destCardCanada">
                  <img src="https://images.unsplash.com/photo-1503614472-8c93d56e92ce?auto=format&fit=crop&w=800&q=80" alt="Canada Banff Rocky Mountains"
                    class="destination-card-img" />
                  <div class="destination-card-overlay"></div>
                  <div class="destination-card-content">
                    <h3 class="destination-card-name">Canada 🇨🇦</h3>
                    <p class="destination-card-desc">Top-ranked universities, post-graduation work permits &amp; direct PR routes</p>
                  </div>
                  <a href="#book" class="destination-card-link" aria-label="Explore Canada Visas" id="exploreCanadaBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                      stroke-linecap="round" stroke-linejoin="round">
                      <line x1="7" y1="17" x2="17" y2="7"></line>
                      <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                  </a>
                </div>
                <!-- Hover Mini Preview Images -->
                <div class="dest-hover-previews">
                  <div class="dest-preview-mini dest-preview-left">
                    <img src="https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=300&q=80" alt="University of Toronto" />
                  </div>
                  <div class="dest-preview-mini dest-preview-center">
                    <img src="https://images.unsplash.com/photo-1588733103629-b77afe0425ce?auto=format&fit=crop&w=300&q=80" alt="Vancouver British Columbia" />
                  </div>
                  <div class="dest-preview-mini dest-preview-right">
                    <img src="https://images.unsplash.com/photo-1569974498991-d3c12a504f95?auto=format&fit=crop&w=300&q=80" alt="Montreal McGill University" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 1: United Kingdom -->
            <div class="dest-card-item is-waiting-bottom" data-dest-index="1">
              <div class="destination-card-wrapper">
                <div class="destination-card" id="destCardUK">
                  <img src="https://images.unsplash.com/photo-1526129318478-62ed807ebdf9?auto=format&fit=crop&w=800&q=80" alt="London Big Ben and Westminster, UK"
                    class="destination-card-img" />
                  <div class="destination-card-overlay"></div>
                  <div class="destination-card-content">
                    <h3 class="destination-card-name">United Kingdom 🇬🇧</h3>
                    <p class="destination-card-desc">1-year Master's degrees, 2-year Graduate Route work visa &amp; Russell Group prestige</p>
                  </div>
                  <a href="#book" class="destination-card-link" aria-label="Explore UK Visas" id="exploreUKBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                      stroke-linecap="round" stroke-linejoin="round">
                      <line x1="7" y1="17" x2="17" y2="7"></line>
                      <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                  </a>
                </div>
                <!-- Hover Mini Preview Images -->
                <div class="dest-hover-previews">
                  <div class="dest-preview-mini dest-preview-left">
                    <img src="https://images.unsplash.com/photo-1529655683826-aba9b3e77383?auto=format&fit=crop&w=300&q=80" alt="Oxford University" />
                  </div>
                  <div class="dest-preview-mini dest-preview-center">
                    <img src="https://images.unsplash.com/photo-1508739773434-c26b3d09e071?auto=format&fit=crop&w=300&q=80" alt="Manchester cityscape" />
                  </div>
                  <div class="dest-preview-mini dest-preview-right">
                    <img src="https://images.unsplash.com/photo-1543783207-ec64e4d95325?auto=format&fit=crop&w=300&q=80" alt="Cambridge historic campus" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 2: Germany -->
            <div class="dest-card-item is-waiting-bottom" data-dest-index="2">
              <div class="destination-card-wrapper">
                <div class="destination-card" id="destCardGermany">
                  <img src="https://framerusercontent.com/images/M2egTeKnNQIzIFaVSX6x4kziaWs.jpg" alt="Germany Berlin landmarks and castles"
                    class="destination-card-img" />
                  <div class="destination-card-overlay"></div>
                  <div class="destination-card-content">
                    <h3 class="destination-card-name">Germany 🇩🇪</h3>
                    <p class="destination-card-desc">Zero/low tuition fees, Opportunity Card (Chancenkarte) &amp; powerhouse industry</p>
                  </div>
                  <a href="#book" class="destination-card-link" aria-label="Explore Germany Visas" id="exploreGermanyBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                      stroke-linecap="round" stroke-linejoin="round">
                      <line x1="7" y1="17" x2="17" y2="7"></line>
                      <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                  </a>
                </div>
                <!-- Hover Mini Preview Images -->
                <div class="dest-hover-previews">
                  <div class="dest-preview-mini dest-preview-left">
                    <img src="https://images.unsplash.com/photo-1560969184-10fe8719e047?auto=format&fit=crop&w=300&q=80" alt="Berlin Brandenburg gate" />
                  </div>
                  <div class="dest-preview-mini dest-preview-center">
                    <img src="https://images.unsplash.com/photo-1595867818082-083862f3d630?auto=format&fit=crop&w=300&q=80" alt="Munich Technical University" />
                  </div>
                  <div class="dest-preview-mini dest-preview-right">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=300&q=80" alt="Frankfurt modern hub" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 3: Australia -->
            <div class="dest-card-item is-waiting-bottom" data-dest-index="3">
              <div class="destination-card-wrapper">
                <div class="destination-card" id="destCardAus">
                  <img src="https://framerusercontent.com/images/f103CLxkNZC2uJepoNQIt3D4xU.jpg" alt="Sydney Opera House, Australia"
                    class="destination-card-img" />
                  <div class="destination-card-overlay"></div>
                  <div class="destination-card-content">
                    <h3 class="destination-card-name">Australia 🇦🇺</h3>
                    <p class="destination-card-desc">High standard of living, extended work rights &amp; world-class research universities</p>
                  </div>
                  <a href="#book" class="destination-card-link" aria-label="Explore Australia Visas" id="exploreAusBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                      stroke-linecap="round" stroke-linejoin="round">
                      <line x1="7" y1="17" x2="17" y2="7"></line>
                      <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                  </a>
                </div>
                <!-- Hover Mini Preview Images -->
                <div class="dest-hover-previews">
                  <div class="dest-preview-mini dest-preview-left">
                    <img src="https://images.unsplash.com/photo-1514395462725-fb4566210144?auto=format&fit=crop&w=300&q=80" alt="Sydney Harbour" />
                  </div>
                  <div class="dest-preview-mini dest-preview-center">
                    <img src="https://images.unsplash.com/photo-1545044846-351ba102b6d5?auto=format&fit=crop&w=300&q=80" alt="Melbourne Monash campus" />
                  </div>
                  <div class="dest-preview-mini dest-preview-right">
                    <img src="https://images.unsplash.com/photo-1524293581917-878a6d017cba?auto=format&fit=crop&w=300&q=80" alt="Brisbane skyline" />
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Infinite Scrolling Destination Name Marquee -->
      <div class="destinations-marquee-wrapper" aria-hidden="true">
        <div class="destinations-marquee-track" id="destMarqueeTrack">
          <!-- Populated and dynamically synced by script.js -->
        </div>
      </div>
    </section>
  </div>

  <!-- How It Works Section -->
  <section class="how-it-works-section" id="how-it-works">
    <div class="how-it-works-container">
      <div class="how-it-works-layout">

        <!-- Left Column: Sticky to Middle -->
        <div class="how-it-works-left">
          <div class="how-it-works-sticky-inner">
            <span class="how-it-works-eyebrow">
              <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> Transparent Process
            </span>
            <h2 class="how-it-works-title">
              From consultation<br />
              to touchdown
            </h2>
            <p class="how-it-works-desc">
              We take care of everything so you don't have to worry &mdash; clear profile evaluation, flawless documentation, and end-to-end support at every step.
            </p>
            <div class="how-it-works-cta">
              <a href="#book" class="btn-dark" id="planHikeBtn">Start Your Journey</a>
            </div>
          </div>
        </div>

        <!-- Right Column: Scrollable Cards -->
        <div class="how-it-works-right">
          <div class="steps-list">

            <!-- Step 01 -->
            <article class="step-card active" data-step="1" id="step1">
              <span class="step-number">01</span>
              <div class="step-body">
                <h3 class="step-title">Free Profile Evaluation</h3>
                <p class="step-text">
                  Connect with our certified visa advisors. We assess your academic history, work experience, and goals to identify the highest-probability visa and destination.
                </p>
              </div>
            </article>

            <!-- Step 02 -->
            <article class="step-card" data-step="2" id="step2">
              <span class="step-number">02</span>
              <div class="step-body">
                <h3 class="step-title">University Shortlisting &amp; SOP</h3>
                <p class="step-text">
                  We select top-tier accredited institutions or work pathways, craft persuasive Statements of Purpose, and vet all financial records to embassy standards.
                </p>
              </div>
            </article>

            <!-- Step 03 -->
            <article class="step-card" data-step="3" id="step3">
              <span class="step-number">03</span>
              <div class="step-body">
                <h3 class="step-title">Visa Filing &amp; Interview Prep</h3>
                <p class="step-text">
                  We handle biometrics appointments, official embassy filing, and conduct intensive mock visa interview simulations with experienced specialists.
                </p>
              </div>
            </article>

            <!-- Step 04 -->
            <article class="step-card" data-step="4" id="step4">
              <span class="step-number">04</span>
              <div class="step-body">
                <h3 class="step-title">Pre-Departure &amp; Housing Support</h3>
                <p class="step-text">
                  From securing safe dormitories and budget-friendly student housing to foreign exchange briefings, we support you all the way to touchdown.
                </p>
              </div>
            </article>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- What's Included / Features Bento Section -->
  <section class="features-section" id="included">
    <div class="features-container">

      <!-- Section Header -->
      <div class="features-header">
        <div class="features-title-group">
          <span class="features-eyebrow">
            <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> Why Choose Visabuz
          </span>
          <h2 class="features-title">
            What makes our<br />
            guidance different
          </h2>
        </div>
        <p class="features-intro">
          At Visabuz, we provide complete end-to-end overseas consultancy to make your international journey smooth, transparent, and successful.
        </p>
      </div>

      <!-- Bento Features Grid -->
      <div class="bento-grid">

        <!-- Row 1, Col 1: Certified Counselors -->
        <div class="bento-card bento-text-card">
          <div class="card-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>
          <div class="card-content">
            <h3 class="card-title">Certified Advisors</h3>
            <p class="card-desc">Decades of combined expertise with high visa approval records</p>
          </div>
        </div>

        <!-- Row 1, Col 2: SOP Excellence -->
        <div class="bento-card bento-text-card">
          <div class="card-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
          </div>
          <div class="card-content">
            <h3 class="card-title">SOP Excellence</h3>
            <p class="card-desc">Tailored Statements of Purpose audited by admission specialists</p>
          </div>
        </div>

        <!-- Row 1, Col 3-4 (Span 2): 98% Success Rate -->
        <div class="bento-card bento-image-card card-span-2">
          <img src="https://framerusercontent.com/images/4vkwvuoJGYWFzk0yFRIeDpQ.jpg" alt="Personalized visa consultation session" class="bento-bg-img" />
          <div class="bento-image-overlay"></div>
          <div class="bento-image-content">
            <span class="stat-number">98%</span>
            <span class="stat-caption">Visa success rate across global destinations</span>
          </div>
        </div>

        <!-- Row 2, Col 1-2 (Span 2): Complete Handholding -->
        <div class="bento-card bento-image-card card-span-2">
          <img src="https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg" alt="Overseas university and documentation support" class="bento-bg-img" />
          <div class="bento-image-overlay"></div>
          <div class="bento-image-content">
            <h3 class="image-card-title">End-to-End Support</h3>
            <span class="stat-caption">From university shortlisting to landing abroad</span>
          </div>
        </div>

        <!-- Row 2, Col 3: Housing Assistance -->
        <div class="bento-card bento-text-card">
          <div class="card-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
              <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
          </div>
          <div class="card-content">
            <h3 class="card-title">Housing Support</h3>
            <p class="card-desc">Dormitories, shared flats and student stays arranged before arrival</p>
          </div>
        </div>

        <!-- Row 2, Col 4: 100% Ethical Advice -->
        <div class="bento-card bento-text-card">
          <div class="card-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
          </div>
          <div class="card-content">
            <h3 class="card-title">100% Ethical</h3>
            <p class="card-desc">Transparent fees, honest guidance, and verified legal compliance</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Experience / Follow the Journey Section -->
  <section class="experience-section" id="gallery">
    <div class="experience-container">

      <!-- Editorial Header (Left Aligned) -->
      <div class="experience-header">
        <span class="experience-eyebrow">
          <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> Client Success
        </span>
        <h2 class="experience-title">
          What Our Clients Say About Us
        </h2>
        <p class="experience-subtitle">
          Hear directly from students and professionals who trusted Visabuz<br />with their journey — and succeeded abroad.
        </p>
        <div class="experience-handle-wrapper">
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="experience-handle-btn"
            aria-label="Follow @visabuz on Instagram">
            @visabuz
          </a>
        </div>
      </div>

    </div>

    <!-- Tilted Polaroid Photo Ribbon Strip (Swiper Infinite Carousel) -->
    <div class="experience-strip-wrapper">
      <div class="swiper experience-swiper">
        <div class="swiper-wrapper">

          <!-- Set 1 -->
          <div class="swiper-slide experience-polaroid polaroid-1">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg" alt="Aman K. - Canada Student Visa success story" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-2">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg" alt="Priya R. - France visa documentation support"
                loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-3">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/C8anRpEXq9pDnOX51SU8QVo8EA.jpg" alt="Rakesh Tiwari - Europe Schengen visa approval" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-4">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg" alt="Global career work visa and job seeker permit" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-5">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg" alt="Visabuz students celebrating university graduation abroad" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-6">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg" alt="International students in UK and Germany universities" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-7">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/tSFQAHhnJk5PL3nDBPgh3kc0jg.jpg" alt="Airport departure and pre-departure assistance"
                loading="lazy" />
            </div>
          </div>

          <!-- Set 2 -->
          <div class="swiper-slide experience-polaroid polaroid-1">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg" alt="Aman K. - Canada Student Visa success story" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-2">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg" alt="Priya R. - France visa documentation support"
                loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-3">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/C8anRpEXq9pDnOX51SU8QVo8EA.jpg" alt="Rakesh Tiwari - Europe Schengen visa approval" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-4">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg" alt="Global career work visa and job seeker permit" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-5">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg" alt="Visabuz students celebrating university graduation abroad" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-6">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg" alt="International students in UK and Germany universities" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-7">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/tSFQAHhnJk5PL3nDBPgh3kc0jg.jpg" alt="Airport departure and pre-departure assistance"
                loading="lazy" />
            </div>
          </div>

          <!-- Set 3 -->
          <div class="swiper-slide experience-polaroid polaroid-1">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg" alt="Aman K. - Canada Student Visa success story" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-2">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg" alt="Priya R. - France visa documentation support"
                loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-3">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/C8anRpEXq9pDnOX51SU8QVo8EA.jpg" alt="Rakesh Tiwari - Europe Schengen visa approval" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-4">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg" alt="Global career work visa and job seeker permit" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-5">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg" alt="Visabuz students celebrating university graduation abroad" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-6">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg" alt="International students in UK and Germany universities" loading="lazy" />
            </div>
          </div>
          <div class="swiper-slide experience-polaroid polaroid-7">
            <div class="polaroid-frame">
              <img src="https://framerusercontent.com/images/tSFQAHhnJk5PL3nDBPgh3kc0jg.jpg" alt="Airport departure and pre-departure assistance"
                loading="lazy" />
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Call-to-Action (CTA) Travel Dreams Section -->
  <section class="cta-section" id="book">
    <div class="cta-bg-overlay"></div>

    <div class="cta-container">
      <div class="cta-content">
        <h2 class="cta-title">
          Turn Your Global<br />
          Dreams Into Reality
        </h2>
        <p class="cta-subtitle">
          From profile evaluation to visa stamping, our immigration experts guide you at every single step.
        </p>
        <div class="cta-action">
          <a href="#hero" class="btn-cta-primary" id="ctaBookBtn">
            Book a Free Consultation
          </a>
        </div>
      </div>
    </div>

    <!-- Infinite Auto-Scroll Text Bar (Pure text, no emojis) -->
    <div class="cta-marquee-wrapper" aria-hidden="true">
      <div class="cta-marquee-track">
        <span class="marquee-item">Student Visas</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Work Permits</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Canada PR</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Express Entry</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">University Shortlisting</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">SOP Guidance</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">98% Success Rate</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Pre-Departure Support</span>
        <span class="marquee-dot">&bull;</span>
        <!-- Duplicate set for seamless continuous scroll -->
        <span class="marquee-item">Student Visas</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Work Permits</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Canada PR</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Express Entry</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">University Shortlisting</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">SOP Guidance</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">98% Success Rate</span>
        <span class="marquee-dot">&bull;</span>
        <span class="marquee-item">Pre-Departure Support</span>
        <span class="marquee-dot">&bull;</span>
      </div>
    </div>
  </section>

  <!-- Site Footer -->
  <?php include 'components/footer.php'; ?>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <!-- Swiper JS Library -->
  <script src="js/swiper-bundle.min.js"></script>
  <!-- Interactive Script -->
  <script src="js/script.js"></script>
</body>

</html>