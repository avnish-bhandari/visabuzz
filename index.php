<?php
// ── Load Dynamic CMS Content for Homepage ────────────────────
require_once __DIR__ . '/cms/config/db.php';
require_once __DIR__ . '/cms/includes/feature_tabs_config.php';
$ftCfg = cms_get_feature_tabs_config();
require_once __DIR__ . '/cms/includes/destinations_showcase_config.php';

$hFields = [];
try {
    $pdo = cms_pdo();
    $stmtH = $pdo->query("SELECT section_key, field_key, field_value FROM cms_pages WHERE page_slug = 'home'");
    while ($row = $stmtH->fetch(PDO::FETCH_ASSOC)) {
        $hFields[$row['section_key']][$row['field_key']] = $row['field_value'];
    }
} catch (Exception $e) {
    $hFields = [];
}

$destCfg = cms_get_destinations_showcase_config($hFields);

if (!function_exists('gh')) {
    function gh(array $fields, string $sec, string $fld, string $def = ''): string {
        $val = $fields[$sec][$fld] ?? '';
        return ($val !== '') ? $val : $def;
    }
}
if (!function_exists('gh_img')) {
    function gh_img(array $fields, string $sec, string $fld, string $def = ''): string {
        $val = $fields[$sec][$fld] ?? '';
        return ($val !== '') ? $val : $def;
    }
}
?>
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
  <section class="hero-section" id="hero" style="background-image: url('<?= htmlspecialchars(gh_img($hFields, 'hero', 'bg_image', 'https://framerusercontent.com/images/EPY1zXPyU45eKC6tijgaxFyb8.jpg')) ?>');">
    <div class="hero-bg-overlay"></div>
    <!-- Floating Pill Navigation Bar & Fullscreen Overlay -->
    <?php include 'components/navbar.php'; ?>

    <!-- Hero Content Container -->
    <div class="hero-content">
      <div class="hero-layout">

        <!-- Left Column: Eyebrow, Main Title, and CTA Button -->
        <div class="hero-left">
          <span class="hero-eyebrow"><?= htmlspecialchars(gh($hFields, 'hero', 'eyebrow', 'Global Study, Work & Travel Visa Experts')) ?></span>
          <h1 class="hero-title">
            <?= htmlspecialchars(gh($hFields, 'hero', 'title_1', 'Study, Work &')) ?><br />
            <?= htmlspecialchars(gh($hFields, 'hero', 'title_2', 'Settle Abroad')) ?>
          </h1>
          <div class="hero-cta-wrapper">
            <a href="<?= htmlspecialchars(gh($hFields, 'hero', 'cta_url', '#book')) ?>" class="btn-primary" id="findHikeBtn">
              <?= htmlspecialchars(gh($hFields, 'hero', 'cta_label', 'Book Free Consultation')) ?>
            </a>
          </div>
        </div>

        <!-- Right Column: Description Text & Filter Tags -->
        <div class="hero-right">
          <p class="hero-description">
            <?= htmlspecialchars(gh($hFields, 'hero', 'desc', 'Expert visa guidance for Canada, UK, Germany & top global destinations. We simplify your journey with honest advice and end-to-end support.')) ?>
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
              <span class="pill-label"><?= htmlspecialchars(gh($hFields, 'hero', 'pill1_label', 'Student Visa')) ?></span>
            </button>
            <button class="filter-pill" data-category="work" id="filterWork">
              <span class="pill-icon" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                  <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
              </span>
              <span class="pill-label"><?= htmlspecialchars(gh($hFields, 'hero', 'pill2_label', 'Work Visa')) ?></span>
            </button>
            <button class="filter-pill" data-category="pr" id="filterPR">
              <span class="pill-icon" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2L2 22l10-4 10 4L12 2z" />
                </svg>
              </span>
              <span class="pill-label"><?= htmlspecialchars(gh($hFields, 'hero', 'pill3_label', 'Canada PR')) ?></span>
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
              <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> <?= htmlspecialchars(gh($hFields, 'about', 'eyebrow', 'Who We Are')) ?>
            </span>
            <h2 class="about-title">
              <?= nl2br(htmlspecialchars(gh($hFields, 'about', 'title', "Study, Work &\nSettle Abroad —\nMade Simple"))) ?>
            </h2>
            <p class="about-text">
              <?= htmlspecialchars(gh($hFields, 'about', 'paragraph', 'At Visabuz, we believe borders should never limit ambition. We are a trusted overseas education and immigration consultancy, helping individuals and families access global opportunities through expert guidance in student, work, tourist, and permanent residency visas.')) ?>
            </p>
            <div class="about-cta">
              <a href="<?= htmlspecialchars(gh($hFields, 'about', 'cta_url', '#book')) ?>" class="btn-dark" id="ourStoryBtn"><?= htmlspecialchars(gh($hFields, 'about', 'cta_label', 'Request Consultation')) ?></a>
            </div>
          </div>

          <!-- Social Proof / Reviews -->
          <div class="about-social">
            <div class="avatar-group">
              <img src="<?= htmlspecialchars(gh_img($hFields, 'about', 'avatar_1', 'https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg')) ?>" alt="Client avatar" class="avatar-img" />
              <img src="<?= htmlspecialchars(gh_img($hFields, 'about', 'avatar_2', 'https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg')) ?>" alt="Student avatar" class="avatar-img" />
              <img src="<?= htmlspecialchars(gh_img($hFields, 'about', 'avatar_3', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80')) ?>" alt="Client avatar" class="avatar-img" />
              <div class="avatar-badge"><?= htmlspecialchars(gh($hFields, 'about', 'review_count', '176+')) ?></div>
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
                <span class="rating-score"><?= htmlspecialchars(gh($hFields, 'about', 'rating', '4.9/5')) ?></span>
              </div>
              <span class="explorers-count"><?= htmlspecialchars(gh($hFields, 'about', 'rating_text', 'Trusted by 176+ Students')) ?></span>
            </div>
          </div>
        </div>

        <!-- Center Column: Portrait Photo -->
        <div class="about-col about-col-center">
          <div class="hiker-photo-wrapper">
            <img src="<?= htmlspecialchars(gh_img($hFields, 'about', 'img_main', 'https://framerusercontent.com/images/Hd1GsarYYENnlRSrEEn0UjS4mY.jpg')) ?>" alt="Visabuz overseas education and study visa consultation" class="hiker-main-img" />
          </div>
        </div>

        <!-- Right Column: Stats List & Story Card -->
        <div class="about-col about-col-right">
          <!-- Stats List with Subtle Dividing Lines -->
          <div class="stats-list">
            <div class="stat-row">
              <span class="stat-label"><?= htmlspecialchars(gh($hFields, 'about', 'stat1_label', 'Success Rate')) ?></span>
              <span class="stat-value"><?= htmlspecialchars(gh($hFields, 'about', 'stat1_value', '98% visa approval')) ?></span>
            </div>
            <div class="stat-row">
              <span class="stat-label"><?= htmlspecialchars(gh($hFields, 'about', 'stat2_label', 'Students Guided')) ?></span>
              <span class="stat-value"><?= htmlspecialchars(gh($hFields, 'about', 'stat2_value', '176+ placed')) ?></span>
            </div>
            <div class="stat-row">
              <span class="stat-label"><?= htmlspecialchars(gh($hFields, 'about', 'stat3_label', 'Global Destinations')) ?></span>
              <span class="stat-value"><?= htmlspecialchars(gh($hFields, 'about', 'stat3_value', '10+ countries')) ?></span>
            </div>
          </div>

          <!-- "Every trip, a new story" Card -->
          <div class="story-card">
            <h3 class="story-card-title"><?= htmlspecialchars(gh($hFields, 'story', 'title', 'Every journey, a new future')) ?></h3>
            <p class="story-card-desc">
              <?= htmlspecialchars(gh($hFields, 'story', 'desc', 'From university shortlisting to visa approval — we guide every single step.')) ?>
            </p>

            <!-- Fanned Photo Cards -->
            <div class="fanned-deck" id="fannedDeck">
              <!-- Left Card: Work Visa -->
              <div class="deck-card card-left" data-story="work" id="cardWork">
                <img src="<?= htmlspecialchars(gh_img($hFields, 'story', 'img_work', 'https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg')) ?>" alt="Work abroad and build a global career" />
              </div>
              <!-- Center Card: Student Visa (Active) -->
              <div class="deck-card card-center active" data-story="student" id="cardStudent">
                <img src="<?= htmlspecialchars(gh_img($hFields, 'story', 'img_student', 'https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg')) ?>" alt="Study abroad with confidence" />
              </div>
              <!-- Right Card: Canada PR -->
              <div class="deck-card card-right" data-story="pr" id="cardPR">
                <img src="<?= htmlspecialchars(gh_img($hFields, 'story', 'img_pr', 'https://framerusercontent.com/images/Y3vLgrwPWPDMhYwwMsixVo50B24.png')) ?>" alt="Canada Permanent Residency pathways" />
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
        <h2 class="feature-tabs-title"><?= htmlspecialchars(gh($hFields, 'tabs_header', 'title', $ftCfg['header']['default_title'])) ?></h2>

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
              <span class="cat-pill-text"><?= htmlspecialchars(gh($hFields, 'tabs_header', 'pill_study', $ftCfg['header']['pills']['study']['label'])) ?></span>
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
              <span class="cat-pill-text"><?= htmlspecialchars(gh($hFields, 'tabs_header', 'pill_offerings', $ftCfg['header']['pills']['offerings']['label'])) ?></span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link cat-pill-btn" id="catPillPlatform" data-bs-toggle="pill" data-bs-target="#category-pane-platform" type="button" role="tab" aria-controls="category-pane-platform" aria-selected="false" data-category="platform">
              <span class="cat-pill-icon cat-icon-purple" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M4 4h7v7H4V4zm10 0h6v7h-6V4zM4 14h7v6H4v-6zm10 0h6v6h-6v-6z"/>
                </svg>
              </span>
              <span class="cat-pill-text"><?= htmlspecialchars(gh($hFields, 'tabs_header', 'pill_platform', $ftCfg['header']['pills']['platform']['label'])) ?></span>
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
              <span class="cat-pill-text"><?= htmlspecialchars(gh($hFields, 'tabs_header', 'pill_resources', $ftCfg['header']['pills']['resources']['label'])) ?></span>
            </button>
          </li>
        </ul>
      </div>

      <!-- Category Panes Wrapper -->
      <div class="tab-content" id="categoryTabsContent">
        <?php 
        $catIdx = 0;
        foreach ($ftCfg['categories'] as $catKey => $catData): 
            $isCatActive = ($catIdx === 0);
            $catPaneClass = $isCatActive ? 'tab-pane fade show active' : 'tab-pane fade';
            $catIdx++;
        ?>
        <!-- <?= strtoupper($catKey) ?> CATEGORY PANE -->
        <div class="<?= $catPaneClass ?>" id="<?= $catData['pane_id'] ?>" role="tabpanel" aria-labelledby="<?= $catData['pill_id'] ?>">
          <div class="feature-card-wrapper">
            <div class="feature-card-elevated">

              <!-- Left: Vertical Feature Tabs -->
              <div class="nav flex-column nav-pills feature-vertical-nav" id="<?= $catData['vtab_id'] ?>" role="tablist" aria-orientation="vertical" aria-label="<?= htmlspecialchars($catData['vtab_aria']) ?>">
                <?php 
                $tabIdx = 0;
                foreach ($catData['tabs'] as $tabId => $tabInfo): 
                    $isTabActive = ($tabIdx === 0);
                    $tabBtnClass = $isTabActive ? 'nav-link feature-vtab-btn active' : 'nav-link feature-vtab-btn';
                    $tabLabel = gh($hFields, $tabInfo['sec_key'], 'tab_label', $tabInfo['tab_label']);
                    $tabIdx++;
                ?>
                <button class="<?= $tabBtnClass ?>" id="vTab-<?= $tabId ?>" data-bs-toggle="pill" data-bs-target="#panel-<?= $tabId ?>" type="button" role="tab" aria-controls="panel-<?= $tabId ?>" aria-selected="<?= $isTabActive ? 'true' : 'false' ?>">
                  <span><?= htmlspecialchars($tabLabel) ?></span>
                </button>
                <?php endforeach; ?>
              </div>

              <!-- Right / Inner Main Content Panel -->
              <div class="tab-content feature-inner-panel" id="<?= $catData['content_id'] ?>">
                <?php 
                $pnlIdx = 0;
                foreach ($catData['tabs'] as $tabId => $tabInfo): 
                    $secKey = $tabInfo['sec_key'];
                    $isPnlActive = ($pnlIdx === 0);
                    $panelClass = $isPnlActive ? 'tab-pane fade show active feature-tab-content' : 'tab-pane fade feature-tab-content';
                    $pnlIdx++;

                    $ctaLabel = gh($hFields, $secKey, 'cta_label', $tabInfo['cta_label']);
                    $ctaUrl   = gh($hFields, $secKey, 'cta_url',   $tabInfo['cta_url']);
                    $imgSrc   = gh_img($hFields, $secKey, 'image', $tabInfo['image']);
                    $imgAlt   = gh($hFields, $secKey, 'image_alt', $tabInfo['image_alt']);
                ?>
                <div class="<?= $panelClass ?>" id="panel-<?= $tabId ?>" role="tabpanel" aria-labelledby="vTab-<?= $tabId ?>">
                  <div class="feature-content-col">
                    <div class="feature-items-list">
                      <?php for ($i = 1; $i <= 3; $i++): 
                          $badgeClass = ($i === 1) ? 'badge-green' : (($i === 2) ? 'badge-purple' : 'badge-blue');
                          $itemTitle = gh($hFields, $secKey, "item{$i}_title", $tabInfo['items'][$i]['title']);
                          $itemDesc  = gh($hFields, $secKey, "item{$i}_desc",  $tabInfo['items'][$i]['desc']);
                      ?>
                      <div class="feature-list-item">
                        <div class="feature-badge-icon <?= $badgeClass ?>" aria-hidden="true">
                          <?php if ($i === 1): ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                          <?php elseif ($i === 2): ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M12 2C8.69 2 6 4.69 6 8c0 2.21 1.2 4.15 3 5.19V22l3-2 3 2v-8.81c1.8-1.04 3-2.98 3-5.19 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4 1.79 4 4-1.79 4-4 4z" />
                            </svg>
                          <?php else: ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M7 2v11h3v9l7-12h-4l4-8z" />
                            </svg>
                          <?php endif; ?>
                        </div>
                        <div class="feature-item-text">
                          <h4 class="feature-item-title"><?= htmlspecialchars($itemTitle) ?></h4>
                          <p class="feature-item-desc">
                            <?= htmlspecialchars($itemDesc) ?>
                          </p>
                        </div>
                      </div>
                      <?php endfor; ?>
                    </div>
                    <div class="feature-action-row">
                      <a href="<?= htmlspecialchars($ctaUrl) ?>" class="feature-btn-primary"><?= htmlspecialchars($ctaLabel) ?></a>
                    </div>
                  </div>
                  <div class="feature-image-col">
                    <div class="feature-image-frame">
                      <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($imgAlt) ?>" class="feature-showcase-img" loading="lazy" />
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>

            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- Top Study & Immigration Destinations Section (Sticky Scroll Experience) -->
  <?php $destScrollHeight = max(2, count($destCfg['cards'])) * 100; ?>
  <div class="destinations-scroll-track" id="destinationsTrack" style="height: <?= $destScrollHeight ?>vh;">
    <section class="destinations-section" id="destinations">
      <!-- Cross-fading Fullscreen Background Images -->
      <div class="destinations-bg" id="destinationsBg">
        <?php foreach ($destCfg['cards'] as $card): 
            $secKey = $card['sec_key'];
            $bgImg = gh_img($hFields, $secKey, 'bg_image', $card['bg_image']);
            $bgAlt = gh($hFields, $secKey, 'bg_alt', $card['bg_alt']);
            $isActive = ($card['index'] === 0);
        ?>
        <img src="<?= htmlspecialchars($bgImg) ?>" alt="<?= htmlspecialchars($bgAlt) ?>" class="destinations-bg-img<?= $isActive ? ' is-active' : '' ?>"
          data-dest-bg="<?= $card['index'] ?>" />
        <?php endforeach; ?>
        <div class="destinations-bg-overlay"></div>
      </div>

      <div class="destinations-container">
        <!-- Eyebrow with globe icon -->
        <div class="destinations-eyebrow">
          <span class="eyebrow-chevron" style="color: white;" aria-hidden="true">&rsaquo;</span>
          <span><?= htmlspecialchars(gh($hFields, 'dest_showcase_header', 'eyebrow', $destCfg['header']['eyebrow'])) ?></span>
        </div>

        <!-- Section Title -->
        <h2 class="destinations-title">
          <?= nl2br(htmlspecialchars(gh($hFields, 'dest_showcase_header', 'title', $destCfg['header']['default_title']))) ?>
        </h2>

        <!-- 3D Perspective Flip Stage for Destination Cards -->
        <div class="dest-stage-wrapper">
          <div class="dest-stage" id="destStage">

            <?php foreach ($destCfg['cards'] as $card): 
                $secKey = $card['sec_key'];
                $idx = $card['index'];
                $cardItemClass = ($idx === 0) ? 'dest-card-item is-active' : 'dest-card-item is-waiting-bottom';
                $cardImg = gh_img($hFields, $secKey, 'card_image', $card['card_image']);
                $cardAlt = gh($hFields, $secKey, 'card_alt', $card['card_alt']);
                $countryName = gh($hFields, $secKey, 'country_name', $card['country_name']);
                $title = gh($hFields, $secKey, 'title', $card['title']);
                $desc = gh($hFields, $secKey, 'desc', $card['desc']);
                $ctaUrl = gh($hFields, $secKey, 'cta_url', $card['cta_url']);
                $ctaAria = gh($hFields, $secKey, 'cta_aria', $card['cta_aria']);

                $miniLeftImg = gh_img($hFields, $secKey, 'mini_left_img', $card['mini_left_img']);
                $miniLeftAlt = gh($hFields, $secKey, 'mini_left_alt', $card['mini_left_alt']);
                $miniCenterImg = gh_img($hFields, $secKey, 'mini_center_img', $card['mini_center_img']);
                $miniCenterAlt = gh($hFields, $secKey, 'mini_center_alt', $card['mini_center_alt']);
                $miniRightImg = gh_img($hFields, $secKey, 'mini_right_img', $card['mini_right_img']);
                $miniRightAlt = gh($hFields, $secKey, 'mini_right_alt', $card['mini_right_alt']);
            ?>
            <!-- Card <?= $idx ?>: <?= htmlspecialchars($countryName) ?> -->
            <div class="<?= $cardItemClass ?>" data-dest-index="<?= $idx ?>" data-country-name="<?= htmlspecialchars($countryName) ?>">
              <div class="destination-card-wrapper">
                <div class="destination-card" id="<?= $card['card_id'] ?>">
                  <img src="<?= htmlspecialchars($cardImg) ?>" alt="<?= htmlspecialchars($cardAlt) ?>"
                    class="destination-card-img" />
                  <div class="destination-card-overlay"></div>
                  <div class="destination-card-content">
                    <h3 class="destination-card-name"><?= htmlspecialchars($title) ?></h3>
                    <p class="destination-card-desc"><?= htmlspecialchars($desc) ?></p>
                  </div>
                  <a href="<?= htmlspecialchars($ctaUrl) ?>" class="destination-card-link" aria-label="<?= htmlspecialchars($ctaAria) ?>" id="<?= $card['btn_id'] ?>">
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
                    <img src="<?= htmlspecialchars($miniLeftImg) ?>" alt="<?= htmlspecialchars($miniLeftAlt) ?>" />
                  </div>
                  <div class="dest-preview-mini dest-preview-center">
                    <img src="<?= htmlspecialchars($miniCenterImg) ?>" alt="<?= htmlspecialchars($miniCenterAlt) ?>" />
                  </div>
                  <div class="dest-preview-mini dest-preview-right">
                    <img src="<?= htmlspecialchars($miniRightImg) ?>" alt="<?= htmlspecialchars($miniRightAlt) ?>" />
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

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
              <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> <?= htmlspecialchars(gh($hFields, 'process', 'eyebrow', 'Transparent Process')) ?>
            </span>
            <h2 class="how-it-works-title">
              <?= nl2br(htmlspecialchars(gh($hFields, 'process', 'title', "From consultation\nto touchdown"))) ?>
            </h2>
            <p class="how-it-works-desc">
              <?= htmlspecialchars(gh($hFields, 'process', 'desc', "We take care of everything so you don't have to worry — clear profile evaluation, flawless documentation, and end-to-end support at every step.")) ?>
            </p>
            <div class="how-it-works-cta">
              <a href="<?= htmlspecialchars(gh($hFields, 'process', 'cta_url', '#book')) ?>" class="btn-dark" id="planHikeBtn"><?= htmlspecialchars(gh($hFields, 'process', 'cta_label', 'Start Your Journey')) ?></a>
            </div>
          </div>
        </div>

        <!-- Right Column: Scrollable Cards -->
        <div class="how-it-works-right">
          <div class="steps-list">

            <!-- Step 01 -->
            <article class="step-card active" data-step="1" id="step1">
              <span class="step-number"><?= htmlspecialchars(gh($hFields, 'process', 'step1_num', '01')) ?></span>
              <div class="step-body">
                <h3 class="step-title"><?= htmlspecialchars(gh($hFields, 'process', 'step1_title', 'Free Profile Evaluation')) ?></h3>
                <p class="step-text">
                  <?= htmlspecialchars(gh($hFields, 'process', 'step1_text', 'Connect with our certified visa advisors. We assess your academic history, work experience, and goals to identify the highest-probability visa and destination.')) ?>
                </p>
              </div>
            </article>

            <!-- Step 02 -->
            <article class="step-card" data-step="2" id="step2">
              <span class="step-number"><?= htmlspecialchars(gh($hFields, 'process', 'step2_num', '02')) ?></span>
              <div class="step-body">
                <h3 class="step-title"><?= htmlspecialchars(gh($hFields, 'process', 'step2_title', 'University Shortlisting & SOP')) ?></h3>
                <p class="step-text">
                  <?= htmlspecialchars(gh($hFields, 'process', 'step2_text', 'We select top-tier accredited institutions or work pathways, craft persuasive Statements of Purpose, and vet all financial records to embassy standards.')) ?>
                </p>
              </div>
            </article>

            <!-- Step 03 -->
            <article class="step-card" data-step="3" id="step3">
              <span class="step-number"><?= htmlspecialchars(gh($hFields, 'process', 'step3_num', '03')) ?></span>
              <div class="step-body">
                <h3 class="step-title"><?= htmlspecialchars(gh($hFields, 'process', 'step3_title', 'Visa Filing & Interview Prep')) ?></h3>
                <p class="step-text">
                  <?= htmlspecialchars(gh($hFields, 'process', 'step3_text', 'We handle biometrics appointments, official embassy filing, and conduct intensive mock visa interview simulations with experienced specialists.')) ?>
                </p>
              </div>
            </article>

            <!-- Step 04 -->
            <article class="step-card" data-step="4" id="step4">
              <span class="step-number"><?= htmlspecialchars(gh($hFields, 'process', 'step4_num', '04')) ?></span>
              <div class="step-body">
                <h3 class="step-title"><?= htmlspecialchars(gh($hFields, 'process', 'step4_title', 'Pre-Departure & Housing Support')) ?></h3>
                <p class="step-text">
                  <?= htmlspecialchars(gh($hFields, 'process', 'step4_text', 'From securing safe dormitories and budget-friendly student housing to foreign exchange briefings, we support you all the way to touchdown.')) ?>
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
            <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> <?= htmlspecialchars(gh($hFields, 'features', 'eyebrow', 'Why Choose Visabuz')) ?>
          </span>
          <h2 class="features-title">
            <?= nl2br(htmlspecialchars(gh($hFields, 'features', 'title', "What makes our\nguidance different"))) ?>
          </h2>
        </div>
        <p class="features-intro">
          <?= htmlspecialchars(gh($hFields, 'features', 'intro', 'At Visabuz, we provide complete end-to-end overseas consultancy to make your international journey smooth, transparent, and successful.')) ?>
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
            <h3 class="card-title"><?= htmlspecialchars(gh($hFields, 'features', 'card1_title', 'Certified Advisors')) ?></h3>
            <p class="card-desc"><?= htmlspecialchars(gh($hFields, 'features', 'card1_desc', 'Decades of combined expertise with high visa approval records')) ?></p>
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
            <h3 class="card-title"><?= htmlspecialchars(gh($hFields, 'features', 'card2_title', 'SOP Excellence')) ?></h3>
            <p class="card-desc"><?= htmlspecialchars(gh($hFields, 'features', 'card2_desc', 'Tailored Statements of Purpose audited by admission specialists')) ?></p>
          </div>
        </div>

        <!-- Row 1, Col 3-4 (Span 2): 98% Success Rate -->
        <div class="bento-card bento-image-card card-span-2">
          <img src="<?= htmlspecialchars(gh_img($hFields, 'features', 'card3_img', 'https://framerusercontent.com/images/4vkwvuoJGYWFzk0yFRIeDpQ.jpg')) ?>" alt="Personalized visa consultation session" class="bento-bg-img" />
          <div class="bento-image-overlay"></div>
          <div class="bento-image-content">
            <span class="stat-number"><?= htmlspecialchars(gh($hFields, 'features', 'card3_stat', '98%')) ?></span>
            <span class="stat-caption"><?= htmlspecialchars(gh($hFields, 'features', 'card3_caption', 'Visa success rate across global destinations')) ?></span>
          </div>
        </div>

        <!-- Row 2, Col 1-2 (Span 2): Complete Handholding -->
        <div class="bento-card bento-image-card card-span-2">
          <img src="<?= htmlspecialchars(gh_img($hFields, 'features', 'card4_img', 'https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg')) ?>" alt="Overseas university and documentation support" class="bento-bg-img" />
          <div class="bento-image-overlay"></div>
          <div class="bento-image-content">
            <h3 class="image-card-title"><?= htmlspecialchars(gh($hFields, 'features', 'card4_title', 'End-to-End Support')) ?></h3>
            <span class="stat-caption"><?= htmlspecialchars(gh($hFields, 'features', 'card4_caption', 'From university shortlisting to landing abroad')) ?></span>
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
            <h3 class="card-title"><?= htmlspecialchars(gh($hFields, 'features', 'card5_title', 'Housing Support')) ?></h3>
            <p class="card-desc"><?= htmlspecialchars(gh($hFields, 'features', 'card5_desc', 'Dormitories, shared flats and student stays arranged before arrival')) ?></p>
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
            <h3 class="card-title"><?= htmlspecialchars(gh($hFields, 'features', 'card6_title', '100% Ethical')) ?></h3>
            <p class="card-desc"><?= htmlspecialchars(gh($hFields, 'features', 'card6_desc', 'Transparent fees, honest guidance, and verified legal compliance')) ?></p>
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
          <span class="eyebrow-chevron" aria-hidden="true">&rsaquo;</span> <?= htmlspecialchars(gh($hFields, 'gallery', 'eyebrow', 'Client Success')) ?>
        </span>
        <h2 class="experience-title">
          <?= htmlspecialchars(gh($hFields, 'gallery', 'title', 'What Our Clients Say About Us')) ?>
        </h2>
        <p class="experience-subtitle">
          <?= nl2br(htmlspecialchars(gh($hFields, 'gallery', 'subtitle', "Hear directly from students and professionals who trusted Visabuz\nwith their journey — and succeeded abroad."))) ?>
        </p>
        <div class="experience-handle-wrapper">
          <a href="<?= htmlspecialchars(gh($hFields, 'gallery', 'handle_url', 'https://instagram.com')) ?>" target="_blank" rel="noopener noreferrer" class="experience-handle-btn"
            aria-label="Follow <?= htmlspecialchars(gh($hFields, 'gallery', 'handle_text', '@visabuz')) ?> on Instagram">
            <?= htmlspecialchars(gh($hFields, 'gallery', 'handle_text', '@visabuz')) ?>
          </a>
        </div>
      </div>

    </div>

    <!-- Tilted Polaroid Photo Ribbon Strip (Swiper Infinite Carousel) -->
    <div class="experience-strip-wrapper">
      <div class="swiper experience-swiper">
        <div class="swiper-wrapper">

          <?php
          $galleryPhotos = [
              gh_img($hFields, 'gallery', 'photo_1', 'https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg'),
              gh_img($hFields, 'gallery', 'photo_2', 'https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg'),
              gh_img($hFields, 'gallery', 'photo_3', 'https://framerusercontent.com/images/C8anRpEXq9pDnOX51SU8QVo8EA.jpg'),
              gh_img($hFields, 'gallery', 'photo_4', 'https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg'),
              gh_img($hFields, 'gallery', 'photo_5', 'https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg'),
              gh_img($hFields, 'gallery', 'photo_6', 'https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg'),
              gh_img($hFields, 'gallery', 'photo_7', 'https://framerusercontent.com/images/tSFQAHhnJk5PL3nDBPgh3kc0jg.jpg'),
          ];
          $photoAlts = [
              'Aman K. - Canada Student Visa success story',
              'Priya R. - France visa documentation support',
              'Rakesh Tiwari - Europe Schengen visa approval',
              'Global career work visa and job seeker permit',
              'Visabuz students celebrating university graduation abroad',
              'International students in UK and Germany universities',
              'Airport departure and pre-departure assistance'
          ];
          ?>
          <!-- Set 1, 2, and 3 for smooth infinite loop -->
          <?php for ($set = 1; $set <= 3; $set++): ?>
            <?php foreach ($galleryPhotos as $idx => $photoUrl): ?>
            <div class="swiper-slide experience-polaroid polaroid-<?= ($idx + 1) ?>">
              <div class="polaroid-frame">
                <img src="<?= htmlspecialchars($photoUrl) ?>" alt="<?= htmlspecialchars($photoAlts[$idx] ?? 'Visabuz visa success story') ?>" loading="lazy" />
              </div>
            </div>
            <?php endforeach; ?>
          <?php endfor; ?>

        </div>
      </div>
    </div>
  </section>

  <!-- Call-to-Action (CTA) Travel Dreams Section -->
  <section class="cta-section" id="book" style="background-image: url('<?= htmlspecialchars(gh_img($hFields, 'cta', 'bg_image', 'https://framerusercontent.com/images/4vkwvuoJGYWFzk0yFRIeDpQ.jpg')) ?>');">
    <div class="cta-bg-overlay"></div>

    <div class="cta-container">
      <div class="cta-content">
        <h2 class="cta-title">
          <?= nl2br(htmlspecialchars(gh($hFields, 'cta', 'title', "Turn Your Global\nDreams Into Reality"))) ?>
        </h2>
        <p class="cta-subtitle">
          <?= htmlspecialchars(gh($hFields, 'cta', 'subtitle', 'From profile evaluation to visa stamping, our immigration experts guide you at every single step.')) ?>
        </p>
        <div class="cta-action">
          <a href="<?= htmlspecialchars(gh($hFields, 'cta', 'cta_url', '#hero')) ?>" class="btn-cta-primary" id="ctaBookBtn">
            <?= htmlspecialchars(gh($hFields, 'cta', 'cta_label', 'Book a Free Consultation')) ?>
          </a>
        </div>
      </div>
    </div>

    <!-- Infinite Auto-Scroll Text Bar (Pure text, no emojis) -->
    <?php
    $rawMarquee = gh($hFields, 'cta', 'marquee_items', 'Student Visas • Work Permits • Canada PR • Express Entry • University Shortlisting • SOP Guidance • 98% Success Rate • Pre-Departure Support');
    $marqueeList = array_filter(array_map('trim', preg_split('/[•|]/u', $rawMarquee)));
    if (empty($marqueeList)) {
        $marqueeList = ['Student Visas', 'Work Permits', 'Canada PR', 'Express Entry', 'University Shortlisting', 'SOP Guidance', '98% Success Rate', 'Pre-Departure Support'];
    }
    ?>
    <div class="cta-marquee-wrapper" aria-hidden="true">
      <div class="cta-marquee-track">
        <?php foreach ([1, 2] as $repeat): ?>
          <?php foreach ($marqueeList as $mItem): ?>
            <span class="marquee-item"><?= htmlspecialchars($mItem) ?></span>
            <span class="marquee-dot">&bull;</span>
          <?php endforeach; ?>
        <?php endforeach; ?>
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