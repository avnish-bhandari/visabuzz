<?php
/**
 * index.php — CMS Dashboard ("Rizz" SaaS Theme)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

cms_require_auth();

$pageTitle    = 'Dashboard';
$pageSlug     = 'dashboard';
cms_require_permission($pageSlug);
$pageSubtitle = 'Overview of your website content and modules';
$cmsRoot      = '';

// Quick stats
$stats = [];
try {
    $stats['destinations'] = $pdo->query("SELECT COUNT(*) FROM cms_destinations WHERE is_active = 1")->fetchColumn();
    $stats['testimonials'] = $pdo->query("SELECT COUNT(*) FROM cms_testimonials WHERE is_active = 1")->fetchColumn();
    $stats['nav_links']    = $pdo->query("SELECT COUNT(*) FROM cms_nav_links    WHERE is_active = 1")->fetchColumn();
    $stats['footer_links'] = $pdo->query("SELECT COUNT(*) FROM cms_footer_links WHERE is_active = 1")->fetchColumn();
} catch (Exception $e) {
    // DB not yet set up — show zeros
    $stats = ['destinations' => 0, 'testimonials' => 0, 'nav_links' => 0, 'footer_links' => 0];
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- ── 1. Stats Row (Image 1 Style) ───────────────────────── -->
<div class="cms-dashboard-grid">

  <!-- Stat 1: Destinations -->
  <div class="cms-stat-card">
    <div class="cms-stat-top">
      <div>
        <div class="cms-stat-label">Destinations</div>
        <div class="cms-stat-value"><?= (int)$stats['destinations'] ?></div>
      </div>
      <div class="cms-stat-icon-wrap green">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
        </svg>
      </div>
    </div>
    <div class="cms-stat-footer">
      <span class="cms-stat-trend up">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
        Active
      </span>
      <span class="cms-stat-trend-sub">• Global study hubs live</span>
    </div>
  </div>

  <!-- Stat 2: Testimonials -->
  <div class="cms-stat-card">
    <div class="cms-stat-top">
      <div>
        <div class="cms-stat-label">Client Reviews</div>
        <div class="cms-stat-value"><?= (int)$stats['testimonials'] ?></div>
      </div>
      <div class="cms-stat-icon-wrap amber">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
      </div>
    </div>
    <div class="cms-stat-footer">
      <span class="cms-stat-trend up">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        5.0
      </span>
      <span class="cms-stat-trend-sub">• Verified student success</span>
    </div>
  </div>

  <!-- Stat 3: Navigation Links -->
  <div class="cms-stat-card">
    <div class="cms-stat-top">
      <div>
        <div class="cms-stat-label">Navbar Links</div>
        <div class="cms-stat-value"><?= (int)$stats['nav_links'] ?></div>
      </div>
      <div class="cms-stat-icon-wrap blue">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
        </svg>
      </div>
    </div>
    <div class="cms-stat-footer">
      <span class="cms-stat-trend up">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
        Published
      </span>
      <span class="cms-stat-trend-sub">• Header menu synced</span>
    </div>
  </div>

  <!-- Stat 4: Footer Links -->
  <div class="cms-stat-card">
    <div class="cms-stat-top">
      <div>
        <div class="cms-stat-label">Footer Links</div>
        <div class="cms-stat-value"><?= (int)$stats['footer_links'] ?></div>
      </div>
      <div class="cms-stat-icon-wrap purple">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>
        </svg>
      </div>
    </div>
    <div class="cms-stat-footer">
      <span class="cms-stat-trend up">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
        Multi-Column
      </span>
      <span class="cms-stat-trend-sub">• Footer structure ready</span>
    </div>
  </div>

</div>

<!-- ── 2. Content Modules Grid (Image 1 Style) ────────────── -->
<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Content Modules
      </div>
      <div class="cms-card-subtitle">Manage and customize your live website sections</div>
    </div>
    <a href="pages/home.php" class="cms-btn cms-btn-primary cms-btn-sm">
      Quick Edit Home →
    </a>
  </div>

  <div class="cms-module-grid">

    <!-- 1. Home Page -->
    <a href="pages/home.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#ecfdf5;color:#16a34a">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Home Page</div>
          <div class="cms-module-desc">Hero headline, about text, stats, and founder story card</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 2. Destinations -->
    <a href="pages/destinations.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#eff6ff;color:#0284c7">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Destinations</div>
          <div class="cms-module-desc">Manage destination cards, country titles, and featured points</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 3. Study Pages Content -->
    <a href="pages/destination-content.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#f0fdf4;color:#16a34a">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Study Pages Content</div>
          <div class="cms-module-desc">Full 10-section content editor across all 9 study country destinations</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 4. Visa Services -->
    <a href="pages/services.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#ede9fe;color:#7c3aed">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Visa Services</div>
          <div class="cms-module-desc">Service offerings, platform capabilities, and resource tabs</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 5. Testimonials -->
    <a href="pages/testimonials.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#fffbeb;color:#d97706">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Testimonials</div>
          <div class="cms-module-desc">Add, edit, reorder or toggle client reviews and ratings</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 6. Navigation -->
    <a href="pages/nav.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#ecfdf5;color:#16a34a">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Navigation</div>
          <div class="cms-module-desc">Navbar links order, labels, URLs, and consultation CTA</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 7. Footer -->
    <a href="pages/footer-editor.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#eff6ff;color:#0284c7">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">Footer</div>
          <div class="cms-module-desc">Footer column links, social profiles, and contact details</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

    <!-- 8. SEO -->
    <a href="pages/seo.php" class="cms-module-card">
      <div class="cms-module-top">
        <div class="cms-module-icon" style="background:#ede9fe;color:#7c3aed">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div class="cms-module-info">
          <div class="cms-module-name">SEO Manager</div>
          <div class="cms-module-desc">Meta titles, descriptions, and Google snippet preview</div>
        </div>
      </div>
      <span class="cms-module-btn">More Detail →</span>
    </a>

  </div>
</div>

<!-- ── 3. Quick Access ─────────────────────────────────────── -->
<div class="cms-card" style="margin-bottom:0">
  <div class="cms-card-header">
    <div class="cms-card-title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
      Quick Access
    </div>
  </div>
  <div style="display:flex;gap:12px;flex-wrap:wrap;">
    <a href="<?= htmlspecialchars($_ENV['APP_URL'] ?? '/') ?>" target="_blank" class="cms-btn cms-btn-secondary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
      View Live Homepage
    </a>
    <a href="<?= htmlspecialchars(rtrim($_ENV['APP_URL'] ?? '/', '/') . '/study-global.php?country=uk') ?>" target="_blank" class="cms-btn cms-btn-secondary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
      View Study Pages
    </a>
    <a href="<?= htmlspecialchars(rtrim($_ENV['APP_URL'] ?? '/', '/') . '/blog/') ?>" target="_blank" class="cms-btn cms-btn-secondary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
      WordPress Blog
    </a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
