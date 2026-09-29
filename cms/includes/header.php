<?php
/**
 * header.php — CMS Layout Header & Sidebar ("Rizz" SaaS Theme)
 * Variables expected from the including page:
 *   $pageTitle  — shown in <title> and topbar
 *   $pageSlug   — used to mark active nav link (e.g. 'dashboard', 'destinations')
 *   $pageSubtitle (optional) — small text under topbar title
 */

// Ensure session & env are loaded
if (session_status() === PHP_SESSION_NONE) {
    $envPath = dirname(__DIR__) . '/.env';
    if (file_exists($envPath)) {
        foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (!str_starts_with(trim($line), '#') && str_contains($line, '=')) {
                [$k, $v] = explode('=', $line, 2);
                if (!array_key_exists(trim($k), $_ENV)) $_ENV[trim($k)] = trim($v);
            }
        }
    }
    session_name($_ENV['ADMIN_SESSION_NAME'] ?? 'visabuz_cms_admin');
    session_start();
}

$currentUser = cms_current_user();

$appName  = $_ENV['APP_NAME'] ?? 'Visabuz CMS';
$cmsUrl   = rtrim($_ENV['CMS_URL'] ?? '', '/');

// Navigation sections strictly keeping original labels and slugs
$navSections = [
    'Main Menu' => [
        ['slug' => 'dashboard',           'label' => 'Dashboard',           'svg' => 'grid',        'href' => 'index.php'],
        ['slug' => 'profile',             'label' => 'Profile',             'svg' => 'user',        'href' => 'pages/profile.php'],
    ],
    'Site Content' => [
        ['slug' => 'home',                'label' => 'Home Page',           'svg' => 'home',        'href' => 'pages/home.php'],
        ['slug' => 'destinations',        'label' => 'Destinations',        'svg' => 'plane',       'href' => 'pages/destinations.php'],
        ['slug' => 'destination-content', 'label' => 'Study Pages Content', 'svg' => 'graduation',  'href' => 'pages/destination-content.php'],
        ['slug' => 'services',            'label' => 'Visa Services & Pathways', 'svg' => 'briefcase', 'href' => 'pages/services.php'],
        ['slug' => 'testimonials',        'label' => 'Testimonials',        'svg' => 'star',        'href' => 'pages/testimonials.php'],
    ],
    'Site Links & SEO' => [
        ['slug' => 'nav',                 'label' => 'Navigation',          'svg' => 'link',        'href' => 'pages/nav.php'],
        ['slug' => 'footer-editor',       'label' => 'Footer',              'svg' => 'layout',      'href' => 'pages/footer-editor.php'],
        ['slug' => 'seo',                 'label' => 'SEO',                 'svg' => 'search',      'href' => 'pages/seo.php'],
    ]
];

$pageSlug     = $pageSlug     ?? 'dashboard';
$pageTitle    = $pageTitle    ?? 'Dashboard';
$pageSubtitle = $pageSubtitle ?? '';

// Dynamic Greeting (Image 1 Style - Timezone Aware)
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Kolkata');
}
$hour = (int)date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = 'Good Morning';
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = 'Good Afternoon';
} else {
    $greeting = 'Good Evening';
}

// Resolve relative hrefs to work from any depth
$depth    = substr_count($_SERVER['PHP_SELF'], '/') - substr_count(parse_url($cmsUrl, PHP_URL_PATH) ?? '', '/');
$cmsRoot  = str_repeat('../', max($depth - 1, 0));

// SVG Icons helper
function cms_icon(string $name): string {
    return match ($name) {
        'grid' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
        'user' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'home' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
        'plane' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>',
        'graduation' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
        'briefcase' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
        'star' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'link' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>',
        'layout' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>',
        'search' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        default => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/></svg>',
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="csrf-token" content="<?= htmlspecialchars(cms_csrf_token()) ?>" />
  <title><?= htmlspecialchars($pageTitle) ?> — <?= htmlspecialchars($appName) ?></title>
  <link rel="stylesheet" href="<?= $cmsRoot ?>assets/cms.css?v=<?= @filemtime(dirname(__DIR__) . '/assets/cms.css') ?: time() ?>" />
  <script>
    window.CMS_ROOT = '<?= $cmsRoot ?>';
    window.CMS_API_SAVE = '<?= $cmsRoot ?>api/save.php';
    window.CMS_SITE_ROOT = '<?= $cmsRoot ?>../';
    window.CMS_PAGE_SLUG = '<?= $pageSlug ?? "home" ?>';
    window.CMS_PAGE_FOLDER = '<?= ($pageSlug ?? "") === "home" ? "home page" : (($pageSlug ?? "") === "destination-content" ? "destinations" : ($pageSlug ?? "general")) ?>';
    if (localStorage.getItem('cms_sidebar_collapsed') === '1' && window.innerWidth > 1024) {
      document.documentElement.classList.add('sidebar-collapsed');
    }
    window.cmsScrollTabs = function(wrapOrId, dir) {
      var wrap = typeof wrapOrId === 'string' ? document.getElementById(wrapOrId) : wrapOrId;
      if (!wrap && wrapOrId && wrapOrId.closest) {
        var outer = wrapOrId.closest('.dest-tabs-bar-outer') || wrapOrId.parentElement;
        wrap = outer ? outer.querySelector('.dest-tabs-wrap') : null;
      }
      if (!wrap) wrap = document.querySelector('.dest-tabs-wrap');
      if (!wrap) return;
      var step = (dir || 1) * 280;
      wrap.scrollLeft += step;
    };
  </script>
</head>
<body>
<div class="cms-shell" id="cmsShell">

  <!-- ═══════════════════════════════════════════════════════
       SIDEBAR (Image 1 Style)
  ═══════════════════════════════════════════════════════ -->
  <aside class="cms-sidebar" id="cmsSidebar">

    <!-- Brand -->
    <a href="<?= $cmsRoot ?>index.php" class="cms-sidebar-brand" title="Visabuz CMS">
      <div class="cms-brand-icon">V</div>
      <div class="cms-brand-text">
        <div class="cms-brand-name">Visabuz <span class="cms-brand-dot"></span></div>
        <span class="cms-brand-badge">CMS Admin</span>
      </div>
    </a>

    <!-- Nav Sections -->
    <nav class="cms-nav" aria-label="CMS Navigation">

      <?php foreach ($navSections as $sectionTitle => $items): 
          $allowedItems = array_filter($items, function($item) {
              return cms_has_permission($item['slug']);
          });
          if (empty($allowedItems)) continue;
      ?>
      <div class="cms-nav-section">
        <div class="cms-nav-label"><?= htmlspecialchars($sectionTitle) ?></div>
        <?php foreach ($allowedItems as $item):
            $active = ($pageSlug === $item['slug']) ? ' active' : '';
            $href   = $cmsRoot . $item['href'];
        ?>
        <a href="<?= htmlspecialchars($href) ?>" class="cms-nav-link<?= $active ?>" title="<?= htmlspecialchars($item['label']) ?>">
          <div class="cms-nav-link-content">
            <span class="cms-nav-link-icon"><?= cms_icon($item['svg']) ?></span>
            <span class="cms-nav-link-text"><?= htmlspecialchars($item['label']) ?></span>
          </div>
          <svg class="cms-nav-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>

      <!-- View Site Section -->
      <div class="cms-nav-section">
        <div class="cms-nav-label">Live Site</div>
        <a href="<?= htmlspecialchars($_ENV['APP_URL'] ?? '/') ?>" target="_blank" class="cms-nav-link" title="View Website">
          <div class="cms-nav-link-content">
            <span class="cms-nav-link-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            </span>
            <span class="cms-nav-link-text">View Website</span>
          </div>
          <svg class="cms-nav-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

    </nav>

    <!-- User Profile + Logout -->
    <div class="cms-sidebar-footer">
      <div class="cms-user-row">
        <div class="cms-avatar"><?= strtoupper(substr($currentUser['username'] ?: 'A', 0, 1)) ?></div>
        <div class="cms-user-info">
          <div class="cms-user-name"><?= htmlspecialchars($currentUser['full_name'] ?: $currentUser['username']) ?></div>
          <div class="cms-user-role"><?= cms_is_admin() ? 'Super Administrator' : 'Team Member' ?></div>
        </div>
      </div>
      <a href="<?= $cmsRoot ?>logout.php" class="cms-logout-btn" title="Log out">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span class="cms-logout-text">Log out</span>
      </a>
    </div>
  </aside>

  <!-- ═══════════════════════════════════════════════════════
       MAIN AREA
  ═══════════════════════════════════════════════════════ -->
  <div class="cms-main">

    <!-- Topbar (Image 1 Style) -->
    <header class="cms-topbar">
      <div class="cms-topbar-left">
        <!-- Hamburger button for mobile & desktop collapse -->
        <button id="cms-menu-btn" class="cms-menu-toggle" aria-label="Toggle sidebar" title="Toggle Sidebar">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="16" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
        </button>

        <?php if ($pageSlug === 'dashboard'): ?>
          <div>
            <h1 class="cms-greeting" id="cmsGreeting" data-username="<?= htmlspecialchars($currentUser['username']) ?>"><?= $greeting ?>, <?= htmlspecialchars($currentUser['username']) ?>!</h1>
          </div>
        <?php else: ?>
          <div>
            <div class="cms-topbar-title"><?= htmlspecialchars($pageTitle) ?></div>
            <?php if ($pageSubtitle): ?>
              <div class="cms-topbar-sub"><?= htmlspecialchars($pageSubtitle) ?></div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Topbar Actions & Search -->
      <div class="cms-topbar-actions">
        <div class="cms-search-box">
          <svg class="cms-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" class="cms-search-input" placeholder="Search here..." />
        </div>

        <a href="<?= htmlspecialchars($_ENV['APP_URL'] ?? '/') ?>" target="_blank" class="cms-action-icon-btn" title="View Website">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
        </a>

        <a href="<?= htmlspecialchars(rtrim($_ENV['APP_URL'] ?? '/', '/') . '/blog/') ?>" target="_blank" class="cms-action-icon-btn" title="Blog">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
        </a>

        <div class="cms-topbar-avatar" title="<?= htmlspecialchars($currentUser['username']) ?>">
          <?= strtoupper(substr($currentUser['username'], 0, 1)) ?>
        </div>
      </div>
    </header>

    <!-- Page content starts here -->
    <main class="cms-content">
