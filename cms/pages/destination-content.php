<?php
/**
 * destination-content.php — Dynamic Study Destination Content Editor
 * Manages all 6 redesigned page sections + SEO for any study destination.
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Study Pages Content Editor';
$pageSlug     = 'destination-content';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit all page sections for each study destination';
$cmsRoot      = '../';

// ── All destinations for selector ──────────────────────────────────────────
$destinations = $pdo->query("SELECT id, country_slug, country_name, hero_image_url FROM cms_destinations ORDER BY sort_order ASC")->fetchAll();

// Determine active destination
$activeId = 0;
if (!empty($_GET['id'])) {
    $activeId = (int)$_GET['id'];
} elseif (!empty($_GET['country'])) {
    $stmtSlug = $pdo->prepare("SELECT id FROM cms_destinations WHERE country_slug = ? LIMIT 1");
    $stmtSlug->execute([trim($_GET['country'])]);
    $activeId = (int)$stmtSlug->fetchColumn();
}

if ($activeId <= 0 && !empty($destinations)) {
    $activeId = (int)$destinations[0]['id'];
}

// Fetch active destination row
$stmtActive = $pdo->prepare("SELECT * FROM cms_destinations WHERE id = ? LIMIT 1");
$stmtActive->execute([$activeId]);
$activeDest = $stmtActive->fetch();

if (!$activeDest && !empty($destinations)) {
    $activeDest = $destinations[0];
    $activeId   = (int)$activeDest['id'];
}

// ── Fetch section fields for this destination ──────────────────────────────
$stmtSec = $pdo->prepare("SELECT section_key, field_key, field_value FROM cms_destination_sections WHERE destination_id = ?");
$stmtSec->execute([$activeId]);
$secData = [];
foreach ($stmtSec->fetchAll() as $row) {
    $secData[$row['section_key']][$row['field_key']] = $row['field_value'];
}

function fval(array $secData, string $sec, string $fld, string $def = ''): string {
    return $secData[$sec][$fld] ?? $def;
}

function fjson(array $secData, string $sec, string $fld, string $def = '[]'): string {
    $val = $secData[$sec][$fld] ?? '';
    if (!$val) return $def;
    $decoded = json_decode($val);
    return $decoded !== null ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $val;
}

function cms_img_src(string $url): string {
    if (!$url) return '';
    if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'data:') || str_starts_with($url, '/')) {
        return $url;
    }
    if (str_starts_with($url, 'cms/')) {
        return '../' . substr($url, 4);
    }
    if (str_starts_with($url, 'uploads/')) {
        return '../' . $url;
    }
    return '../../' . ltrim($url, '/');
}

function render_cms_image_upload(string $label, int $destId, string $section, string $field, string $currentVal, string $fieldId, string $helpText = 'Upload a photo for this section') {
    $previewSrc = cms_img_src($currentVal);
    $hasImg = !empty($currentVal);
    ?>
    <div class="cms-form-group">
      <label class="cms-label"><?= htmlspecialchars($label) ?></label>
      <div class="cms-image-upload-wrap">
        <div class="cms-image-preview-box" id="box_<?= $fieldId ?>">
          <img id="prev_<?= $fieldId ?>" src="<?= htmlspecialchars($previewSrc) ?>" alt="Preview" class="cms-preview-img <?= $hasImg ? 'is-visible' : 'is-hidden' ?>" />
          <div class="cms-upload-empty <?= !$hasImg ? 'is-visible' : 'is-hidden' ?>">No Image</div>
        </div>
        <div class="cms-upload-content">
          <div class="cms-upload-actions">
            <label class="cms-upload-btn">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span><?= $hasImg ? 'Change Image' : 'Upload Image' ?></span>
              <input type="file" accept="image/*" class="cms-file-input-hidden" onchange="cmsUploadFile(this, 'hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')" />
            </label>
            <button type="button" class="cms-remove-img-btn" onclick="cmsRemoveImage('hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')">Remove</button>
          </div>
          <div class="cms-upload-help"><?= htmlspecialchars($helpText) ?> (JPG, PNG, WebP, SVG)</div>
        </div>
        <input type="hidden" id="hid_<?= $fieldId ?>" class="cms-input" data-dest="<?= $destId ?>" data-section="<?= $section ?>" data-field="<?= $field ?>" value="<?= htmlspecialchars($currentVal) ?>" />
      </div>
    </div>
    <?php
}

$countryCodes = [
    'uk'      => 'GB',
    'usa'     => 'US',
    'ireland' => 'IE',
    'canada'  => 'CA',
    'germany' => 'DE',
    'dubai'   => 'AE',
    'france'  => 'FR',
    'europe'  => 'EU',
    'italy'   => 'IT',
];

function cms_dest_flag_svg(string $slug, int $w = 22, int $h = 15): string {
    $s = strtolower(trim($slug));
    switch ($s) {
        case 'uk':
        case 'gb':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#fff" stroke-width="8"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#C8102E" stroke-width="4"/><path d="M30,0 v40 M0,20 h60" stroke="#fff" stroke-width="12"/><path d="M30,0 v40 M0,20 h60" stroke="#C8102E" stroke-width="7"/></svg>';
        case 'usa':
        case 'us':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="60" height="40" fill="#fff"/><path d="M0,3.1h60 M0,9.2h60 M0,15.4h60 M0,21.5h60 M0,27.7h60 M0,33.8h60 M0,40h60" stroke="#B22234" stroke-width="3.1"/><rect width="26" height="21.5" fill="#3C3B6E"/><circle cx="5.5" cy="4.5" r="1.1" fill="#fff"/><circle cx="13" cy="4.5" r="1.1" fill="#fff"/><circle cx="20.5" cy="4.5" r="1.1" fill="#fff"/><circle cx="9.25" cy="9.5" r="1.1" fill="#fff"/><circle cx="16.75" cy="9.5" r="1.1" fill="#fff"/><circle cx="5.5" cy="14.5" r="1.1" fill="#fff"/><circle cx="13" cy="14.5" r="1.1" fill="#fff"/><circle cx="20.5" cy="14.5" r="1.1" fill="#fff"/></svg>';
        case 'ireland':
        case 'ie':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="20" height="40" fill="#169B62"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#FF883E"/></svg>';
        case 'canada':
        case 'ca':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="15" height="40" fill="#D80027"/><rect x="15" width="30" height="40" fill="#ffffff"/><rect x="45" width="15" height="40" fill="#D80027"/><path d="M30 10l1.4 4.2 3.6-1.4-1.2 4.2 4 1-3.6 2.8 1.8 4.2-4.8-1.8v3.8h-2.4V27l-4.8 1.8 1.8-4.2-3.6-2.8 4-1-1.2-4.2 3.6 1.4z" fill="#D80027"/></svg>';
        case 'germany':
        case 'de':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="60" height="13.33" fill="#000000"/><rect y="13.33" width="60" height="13.33" fill="#DD0000"/><rect y="26.66" width="60" height="13.34" fill="#FFCE00"/></svg>';
        case 'dubai':
        case 'ae':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="60" height="13.33" fill="#00732F"/><rect y="13.33" width="60" height="13.33" fill="#ffffff"/><rect y="26.66" width="60" height="13.34" fill="#000000"/><rect width="17" height="40" fill="#FF0000"/></svg>';
        case 'france':
        case 'fr':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="20" height="40" fill="#002654"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#CE1126"/></svg>';
        case 'europe':
        case 'eu':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="60" height="40" fill="#003399"/><circle cx="30" cy="8" r="1.4" fill="#FFCC00"/><circle cx="36" cy="9.6" r="1.4" fill="#FFCC00"/><circle cx="40.4" cy="14" r="1.4" fill="#FFCC00"/><circle cx="42" cy="20" r="1.4" fill="#FFCC00"/><circle cx="40.4" cy="26" r="1.4" fill="#FFCC00"/><circle cx="36" cy="30.4" r="1.4" fill="#FFCC00"/><circle cx="30" cy="32" r="1.4" fill="#FFCC00"/><circle cx="24" cy="30.4" r="1.4" fill="#FFCC00"/><circle cx="19.6" cy="26" r="1.4" fill="#FFCC00"/><circle cx="18" cy="20" r="1.4" fill="#FFCC00"/><circle cx="19.6" cy="14" r="1.4" fill="#FFCC00"/><circle cx="24" cy="9.6" r="1.4" fill="#FFCC00"/></svg>';
        case 'italy':
        case 'it':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" class="dest-flag-svg" aria-hidden="true"><rect width="20" height="40" fill="#009246"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#CE2B37"/></svg>';
        default:
            $code = strtoupper(substr($slug, 0, 2));
            return '<span class="dest-flag-code">' . htmlspecialchars($code) . '</span>';
    }
}

$destFactMap = [
    'uk' => [
        'intakes'   => 'Jan / Feb & Sep / Oct',
        'duration'  => '3 Yrs (UG) / 1 Yr (PG)',
        'psw'       => '2 - 3 Years (Graduate Route)',
        'work'      => 'Up to 20 hrs/week term time',
    ],
    'usa' => [
        'intakes'   => 'Fall (Aug) & Spring (Jan)',
        'duration'  => '4 Yrs (UG) / 2 Yrs (PG)',
        'psw'       => '1 - 3 Years (OPT / STEM OPT)',
        'work'      => 'Up to 20 hrs/week on-campus',
    ],
    'canada' => [
        'intakes'   => 'Fall (Sep), Winter (Jan), May',
        'duration'  => '3-4 Yrs (UG) / 1-2 Yrs (PG)',
        'psw'       => 'Up to 3 Years (PGWP)',
        'work'      => '20 - 24 hrs/week part-time',
    ],
    'germany' => [
        'intakes'   => 'Winter (Sep/Oct) & Summer (Mar/Apr)',
        'duration'  => '3 Yrs (UG) / 1.5 - 2 Yrs (PG)',
        'psw'       => '18 Months Job Seeking Visa',
        'work'      => '140 full days / 280 half days',
    ],
    'ireland' => [
        'intakes'   => 'Autumn (Sep) & Spring (Jan/Feb)',
        'duration'  => '3-4 Yrs (UG) / 1 Yr (PG)',
        'psw'       => '2 Years (Third Level Graduate)',
        'work'      => 'Up to 20 hrs/week term time',
    ],
    'dubai' => [
        'intakes'   => 'Sep, Jan & May',
        'duration'  => '3-4 Yrs (UG) / 1-2 Yrs (PG)',
        'psw'       => 'Post-Grad & Golden Visa Routes',
        'work'      => 'Part-time student work permitted',
    ],
    'france' => [
        'intakes'   => 'Sep / Oct & Jan / Feb',
        'duration'  => '3 Yrs (License) / 2 Yrs (Master)',
        'psw'       => '2 Years Post-Study Work Permit',
        'work'      => 'Up to 60% of annual hours',
    ],
    'italy' => [
        'intakes'   => 'September / October',
        'duration'  => '3 Yrs (UG) / 2 Yrs (PG)',
        'psw'       => '1 Year Permesso di Soggiorno',
        'work'      => 'Up to 20 hrs/week (1040 hrs/yr)',
    ],
    'europe' => [
        'intakes'   => 'Fall (Sep) & Spring (Feb)',
        'duration'  => '3 Yrs (UG) / 1 - 2 Yrs (PG)',
        'psw'       => '1 - 2 Years EU Job Seeker Route',
        'work'      => '20 hrs/week part-time allowed',
    ],
];
$activeSlug   = strtolower(trim($activeDest['country_slug'] ?? 'uk'));
$defaultFacts = $destFactMap[$activeSlug] ?? [
    'intakes'   => 'Jan / Feb & Sep / Oct',
    'duration'  => '3 Yrs (UG) / 1-2 Yrs (PG)',
    'psw'       => '1 - 3 Years Post-Study Work',
    'work'      => '20 hrs/week part-time work rights',
];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- Destination Switcher Panel -->
<div class="dest-switcher-card">
  <div class="dest-switcher-top">
    <div class="dest-switcher-meta">
      <div class="dest-switcher-title">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        <span>Study Destination</span>
      </div>
      <span class="dest-count-badge"><?= count($destinations) ?> Destinations</span>
    </div>
    <div class="dest-switcher-quick-links">
      <a href="home.php#sec-dest_showcase" class="dest-manage-link" title="Edit the 3D rotating destination showcase cards on the homepage">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
        <span>Homepage 3D Showcase</span>
      </a>
      <a href="destinations.php" class="dest-manage-link" title="Manage all destinations, add countries, or change routes">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
        <span>Manage Destinations</span>
      </a>
    </div>
  </div>

  <!-- Country Switcher Pills Rail -->
  <div class="dest-country-pills-rail">
    <div class="dest-country-pills">
      <?php foreach ($destinations as $d):
          $isActive    = ($d['id'] == $activeId);
          $activeClass = $isActive ? ' active' : '';
          $slugKey     = strtolower($d['country_slug']);
          $cleanName   = preg_replace('/^Study in\s+(the\s+)?/i', '', $d['country_name']);
          if (empty($cleanName)) {
              $cleanName = $d['country_name'];
          }
      ?>
      <a href="destination-content.php?id=<?= $d['id'] ?>"
         class="dest-pill<?= $activeClass ?>"
         title="Edit content for <?= htmlspecialchars($d['country_name']) ?>">
        <span class="dest-pill-flag"><?= cms_dest_flag_svg($slugKey) ?></span>
        <span class="dest-pill-name"><?= htmlspecialchars($cleanName) ?></span>
        <?php if ($isActive): ?>
          <span class="dest-pill-dot" aria-hidden="true" title="Currently active"></span>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Active Country Banner & Section Tabs Bar -->
<div class="dest-header-card">
  <!-- Active Country Header Top -->
  <div class="dest-header-bar">
    <div class="dest-header-title">
      <span class="dest-header-flag">
        <?= cms_dest_flag_svg(strtolower($activeDest['country_slug']), 32, 22) ?>
      </span>
      <div class="dest-header-text">
        <span class="dest-header-kicker">Currently Editing Destination</span>
        <div class="dest-header-heading">
          <strong><?= htmlspecialchars($activeDest['country_name']) ?></strong>
          <span class="cms-badge cms-badge-accent">?country=<?= htmlspecialchars($activeDest['country_slug']) ?></span>
          <span class="dest-section-count">6 Sections</span>
        </div>
      </div>
    </div>
    <div class="dest-header-actions">
      <a href="../../study-global.php?country=<?= htmlspecialchars($activeDest['country_slug']) ?>"
         target="_blank" class="cms-btn cms-btn-secondary dest-preview-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        <span>Preview Live Page</span>
      </a>
    </div>
  </div>

  <!-- Navigation Underline Tabs with Left/Right Scroll Controls -->
  <div class="dest-tabs-bar-outer">
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-prev" id="destTabsPrev" onclick="cmsScrollTabs('destTabsWrap', -1)" aria-label="Scroll tabs left" title="Scroll left">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <div class="dest-tabs-wrap" id="destTabsWrap">
      <ul class="dest-nav-tabs" role="tablist">
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn active" data-sec="hero" onclick="switchDestTab('hero', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
            <span class="dest-tab-label">1. Hero</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="about" onclick="switchDestTab('about', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <span class="dest-tab-label">2. About / Potential</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="features" onclick="switchDestTab('features', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span class="dest-tab-label">3. Why Choose Us</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="testimonials" onclick="switchDestTab('testimonials', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span class="dest-tab-label">4. Testimonials</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="faq" onclick="switchDestTab('faq', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span class="dest-tab-label">5. FAQ</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="seo" onclick="switchDestTab('seo', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <span class="dest-tab-label">6. SEO Meta</span>
          </button>
        </li>
        <li class="dest-tab-item dest-tab-item-all">
          <button type="button" class="dest-tab-btn dest-tab-btn-all" data-sec="all" onclick="switchDestTab('all', this)" title="Show all sections together">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            <span class="dest-tab-label">All Sections</span>
          </button>
        </li>
      </ul>
    </div>
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-next" id="destTabsNext" onclick="cmsScrollTabs('destTabsWrap', 1)" aria-label="Scroll tabs right" title="Scroll right">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     1. HERO SECTION
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-hero">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">1. Hero Section</div>
      <div class="cms-card-subtitle">Headline, fast facts card, call-to-actions, success rate, and visual campus image</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveDestSec('hero', this)">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      <span>Save Hero</span>
    </button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Main Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="title"
           value="<?= htmlspecialchars(strip_tags(fval($secData, 'hero', 'title', 'Turn Your Ambition into Achievement'))) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Subtitle Description</label>
    <textarea class="cms-textarea cms-ckeditor cms-editor-sm" data-dest="<?= $activeId ?>" data-section="hero" data-field="subtitle"><?= htmlspecialchars(fval($secData, 'hero', 'subtitle', 'Empowering students with world-class education, innovation, and global opportunities.')) ?></textarea>
  </div>

  <div class="cms-section-divider">Hero Right Side — Fast Facts Card (No Images)</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Upcoming Intakes</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="fact_intakes"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'fact_intakes', $defaultFacts['intakes'])) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Course Duration</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="fact_duration"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'fact_duration', $defaultFacts['duration'])) ?>" />
    </div>
  </div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Post-Study Work Visa</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="fact_psw"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'fact_psw', $defaultFacts['psw'])) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Student Work Rights</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="fact_work"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'fact_work', $defaultFacts['work'])) ?>" />
    </div>
  </div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Fast Facts Button Label</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="fact_btn_label"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'fact_btn_label', 'Check Eligibility & Options')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Fast Facts Button URL</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="fact_btn_url"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'fact_btn_url', '#apply')) ?>" />
    </div>
  </div>

  <div class="cms-section-divider">Call To Action Buttons</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Primary Button Label</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="cta1_label"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'cta1_label', 'Apply Now')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Primary Button URL</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="cta1_url"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'cta1_url', '#apply')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Secondary Button Label</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="cta2_label"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'cta2_label', 'Explore Campus')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Secondary Button URL</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="cta2_url"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'cta2_url', '#why-us')) ?>" />
    </div>
  </div>

  <div class="cms-section-divider">Social Proof &amp; Statistics</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Success Rate Figure</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="stat_rate"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'stat_rate', '99%')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Success Rate Label</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="stat_rate_label"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'stat_rate_label', 'Our Success Rate')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Total Students Figure</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="stat_students"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'stat_students', '30K')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Total Students Label</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="stat_students_label"
             value="<?= htmlspecialchars(fval($secData, 'hero', 'stat_students_label', 'Total Students')) ?>" />
    </div>
  </div>

  <div class="cms-section-divider">Hero Visual Image</div>
  <?php render_cms_image_upload('Main Campus Building Image', $activeId, 'hero', 'img_main', fval($secData, 'hero', 'img_main', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80'), 'hero_main', 'Main campus / university visual displayed in hero section'); ?>
</div>

<!-- ══════════════════════════════════════════════════════════
     2. ABOUT / POTENTIAL SECTION (Dark Forest Green)
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-about">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">2. About / Potential Section (Dark Green)</div>
      <div class="cms-card-subtitle">Founding narrative, graduate photos, and progress percentage statistics</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveDestSec('about', this)">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      <span>Save About</span>
    </button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Main Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="about" data-field="heading"
           value="<?= htmlspecialchars(fval($secData, 'about', 'heading', 'The right opportunity can turn dreams into limitless potential.')) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Narrative Paragraph</label>
    <textarea class="cms-textarea cms-ckeditor cms-editor-md" data-dest="<?= $activeId ?>" data-section="about" data-field="desc"><?= htmlspecialchars(fval($secData, 'about', 'desc', 'Founded in 1999, NUOVA EDILE COSTANZA is a community - driven institution renowned for it\'s unique contributions.')) ?></textarea>
  </div>

  <div class="cms-section-divider">Progress Metrics</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Stat 1 Percentage (e.g. 30%)</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="about" data-field="stat1_pct"
             value="<?= htmlspecialchars(fval($secData, 'about', 'stat1_pct', '30%')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Stat 1 Description Text</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="about" data-field="stat1_label"
             value="<?= htmlspecialchars(fval($secData, 'about', 'stat1_label', 'Daily Growing Students are still grinding')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Stat 2 Percentage (e.g. 95%)</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="about" data-field="stat2_pct"
             value="<?= htmlspecialchars(fval($secData, 'about', 'stat2_pct', '95%')) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Stat 2 Description Text</label>
      <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="about" data-field="stat2_label"
             value="<?= htmlspecialchars(fval($secData, 'about', 'stat2_label', 'They are in a job related to their field of study')) ?>" />
    </div>
  </div>

  <div class="cms-section-divider">About Section Photos</div>
  <div class="cms-input-row">
    <?php render_cms_image_upload('Left Photo (Graduates holding diplomas)', $activeId, 'about', 'img_left', fval($secData, 'about', 'img_left', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80'), 'about_left', 'Graduation diploma photo'); ?>
    <?php render_cms_image_upload('Right Photo (Graduates tossing caps)', $activeId, 'about', 'img_right', fval($secData, 'about', 'img_right', 'https://images.unsplash.com/photo-1525921429624-479b6a26d84d?auto=format&fit=crop&w=900&q=80'), 'about_right', 'Celebration cap tossing photo'); ?>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     3. WHY CHOOSE US / FEATURES
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-features">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">3. Why Choose Us Section</div>
      <div class="cms-card-subtitle">Title, subtitle, and 3 feature cards</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveDestSec('features', this)">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      <span>Save Why Choose Us</span>
    </button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="features" data-field="title"
           value="<?= htmlspecialchars(fval($secData, 'features', 'title', 'One of the largest, most diverse universities in the World')) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Subtitle</label>
    <textarea class="cms-textarea cms-ckeditor cms-editor-sm" data-dest="<?= $activeId ?>" data-section="features" data-field="subtitle"><?= htmlspecialchars(fval($secData, 'features', 'subtitle', 'Home to students from every corner of the globe, fostering diversity, inclusion, and world-class academic excellence.')) ?></textarea>
  </div>

  <!-- Hidden JSON textarea synced automatically -->
  <textarea id="ta_features" class="cms-repeater-hidden"
            data-dest="<?= $activeId ?>" data-section="features" data-field="cards_json"><?= htmlspecialchars(fjson($secData, 'features', 'cards_json', '[]')) ?></textarea>

  <div class="cms-repeater-header-bar">
    <span class="cms-repeater-title">Feature Cards List</span>
    <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="addFeatureCard()">+ Add Feature Card</button>
  </div>

  <div id="builder_features" class="cms-repeater-list"></div>
</div>

<!-- ══════════════════════════════════════════════════════════
     4. TESTIMONIALS SECTION
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-testimonials">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">4. Voices From Our Global Community (Testimonials)</div>
      <div class="cms-card-subtitle">Manage top large featured cards and bottom student feedback cards</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveDestSec('testimonials', this)">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      <span>Save Testimonials</span>
    </button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Title</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="testimonials" data-field="title"
             value="<?= htmlspecialchars(fval($secData, 'testimonials', 'title', 'Voices From Our Global Community')) ?>" />
  </div>

  <!-- Hidden JSON textarea synced automatically -->
  <textarea id="ta_testimonials" class="cms-repeater-hidden"
            data-dest="<?= $activeId ?>" data-section="testimonials" data-field="cards_json"><?= htmlspecialchars(fjson($secData, 'testimonials', 'cards_json', '[]')) ?></textarea>

  <div class="cms-repeater-header-bar">
    <span class="cms-repeater-title">Testimonials Cards List</span>
    <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="addTestimonialCard()">+ Add Testimonial</button>
  </div>

  <div id="builder_testimonials" class="cms-repeater-list"></div>
</div>

<!-- ══════════════════════════════════════════════════════════
     5. FREQUENTLY ASKED QUESTIONS (FAQ)
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-faq">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">5. Frequently Asked Questions (FAQ)</div>
      <div class="cms-card-subtitle">Historic facade photo and interactive question accordion items</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveDestSec('faq', this)">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      <span>Save FAQ</span>
    </button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="faq" data-field="title"
           value="<?= htmlspecialchars(fval($secData, 'faq', 'title', 'Frequently Asked Questions?')) ?>" />
  </div>

  <?php render_cms_image_upload('Left Facade Photo', $activeId, 'faq', 'img_url', fval($secData, 'faq', 'img_url', 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=900&q=80'), 'faq_img', 'Historic building or campus facade photo'); ?>

  <!-- Hidden JSON textarea synced automatically -->
  <textarea id="ta_faq" class="cms-repeater-hidden"
            data-dest="<?= $activeId ?>" data-section="faq" data-field="items_json"><?= htmlspecialchars(fjson($secData, 'faq', 'items_json', '[]')) ?></textarea>

  <div class="cms-repeater-header-bar">
    <span class="cms-repeater-title">FAQ Questions &amp; Answers List</span>
    <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="addFaqItem()">+ Add FAQ Item</button>
  </div>

  <div id="builder_faq" class="cms-repeater-list"></div>
</div>

<!-- ══════════════════════════════════════════════════════════
     6. SEO META
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-seo">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">6. Search Engine Optimization (SEO)</div>
      <div class="cms-card-subtitle">Search snippet title and description tags</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveDestSec('seo', this)">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      <span>Save SEO</span>
    </button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Meta Page Title</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="seo" data-field="title"
           value="<?= htmlspecialchars(fval($secData, 'seo', 'title', "Study in {$activeDest['country_name']} — Visabuz")) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Meta Description</label>
    <textarea class="cms-textarea cms-textarea-sm" data-dest="<?= $activeId ?>" data-section="seo" data-field="description"><?= htmlspecialchars(fval($secData, 'seo', 'description', "Complete guide to studying in {$activeDest['country_name']} with Visabuz.")) ?></textarea>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     JAVASCRIPT REPEATERS & SAVE LOGIC
══════════════════════════════════════════════════════════ -->
<script>
// Repeater Collections State
const repeaters = {
    features:     [],
    testimonials: [],
    faq:          []
};

function safeParseJson(str, def) {
    try {
        const parsed = JSON.parse(str);
        return Array.isArray(parsed) ? parsed : def;
    } catch (e) {
        return def;
    }
}

function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function resolvePreviewUrl(url) {
    if (!url) return '';
    if (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('data:') || url.startsWith('/')) {
        return url;
    }
    return (window.CMS_SITE_ROOT || '../../') + url.replace(/^\/+/, '');
}

function uploadTestimonialAvatar(input, idx) {
    cmsUploadFile(input, null, null, function(json) {
        repeaters.testimonials[idx].author_avatar = json.url;
        syncRepeaterToTextarea('testimonials');
        renderTestimonials();
    });
}

function removeTestimonialAvatar(idx) {
    repeaters.testimonials[idx].author_avatar = '';
    syncRepeaterToTextarea('testimonials');
    renderTestimonials();
}

function initRepeaterState() {
    repeaters.features     = safeParseJson(document.getElementById('ta_features')?.value || '[]', []);
    repeaters.testimonials = safeParseJson(document.getElementById('ta_testimonials')?.value || '[]', []);
    repeaters.faq          = safeParseJson(document.getElementById('ta_faq')?.value || '[]', []);
}

function syncRepeaterToTextarea(key) {
    const ta = document.getElementById('ta_' + key);
    if (ta) {
        ta.value = JSON.stringify(repeaters[key], null, 2);
    }
}

function syncAllRepeaters() {
    ['features', 'testimonials', 'faq'].forEach(syncRepeaterToTextarea);
}

function deleteRepeaterItem(key, index) {
    if (!confirm('Remove this item?')) return;
    repeaters[key].splice(index, 1);
    syncRepeaterToTextarea(key);
    renderRepeater(key);
}

function renderRepeater(key) {
    if (key === 'features') renderFeatures();
    else if (key === 'testimonials') renderTestimonials();
    else if (key === 'faq') renderFaq();
}

function renderAllRepeaters() {
    initRepeaterState();
    renderFeatures();
    renderTestimonials();
    renderFaq();
}

// ── 1. Features Renderer ─────────────────────────────────────
function renderFeatures() {
    const c = document.getElementById('builder_features');
    if (!c) return;
    const items = repeaters.features;
    if (!items.length) {
        c.innerHTML = '<div class="cms-repeater-empty">No feature cards added. Click "+ Add Feature Card" above.</div>';
        return;
    }
    c.innerHTML = items.map((it, idx) => `
        <div class="cms-repeater-item ${it.is_featured ? 'is-featured' : ''}" data-idx="${idx}">
          <div class="cms-repeater-item-header">
            <span class="cms-repeater-item-badge">
              <span class="cms-badge ${it.is_featured ? 'cms-badge-accent' : 'cms-badge-green'}">#${idx + 1}</span>
              <strong>${escapeHtml(it.title || 'Feature Card')}</strong>
              ${it.is_featured ? '<span class="cms-badge cms-badge-accent ms-1">Featured</span>' : ''}
            </span>
            <button type="button" class="cms-repeater-delete-btn" onclick="deleteRepeaterItem('features', ${idx})">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Remove
            </button>
          </div>
          <div class="cms-input-row cms-grid-feature-top">
            <div class="cms-form-group">
              <label class="cms-label">Icon Type</label>
              <select class="cms-select" onchange="repeaters.features[${idx}].icon = this.value; syncRepeaterToTextarea('features');">
                <option value="bulb" ${it.icon === 'bulb' ? 'selected' : ''}>Inspiring Bulb</option>
                <option value="grad" ${it.icon === 'grad' ? 'selected' : ''}>Graduation Cap</option>
                <option value="academic" ${it.icon === 'academic' ? 'selected' : ''}>Academic Spark</option>
              </select>
            </div>
            <div class="cms-form-group">
              <label class="cms-label">Card Title</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.title || '')}" placeholder="e.g. Inspiring Student Life"
                     oninput="repeaters.features[${idx}].title = this.value; syncRepeaterToTextarea('features');" />
            </div>
            <div class="cms-form-group cms-checkbox-group">
              <label class="cms-checkbox-label">
                <input type="checkbox" ${it.is_featured ? 'checked' : ''}
                       onchange="repeaters.features[${idx}].is_featured = this.checked; syncRepeaterToTextarea('features'); renderFeatures();" />
                <span>Featured (Dark Border)</span>
              </label>
            </div>
          </div>
          <div class="cms-form-group">
            <label class="cms-label">Description Text</label>
            <textarea class="cms-textarea cms-textarea-sm" placeholder="Brief description..."
                      oninput="repeaters.features[${idx}].desc = this.value; syncRepeaterToTextarea('features');">${escapeHtml(it.desc || '')}</textarea>
          </div>
          <div class="cms-input-row">
            <div class="cms-form-group">
              <label class="cms-label">Button Label</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.btn_label || 'Read More')}"
                     oninput="repeaters.features[${idx}].btn_label = this.value; syncRepeaterToTextarea('features');" />
            </div>
            <div class="cms-form-group">
              <label class="cms-label">Button Link URL</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.btn_url || '#')}"
                     oninput="repeaters.features[${idx}].btn_url = this.value; syncRepeaterToTextarea('features');" />
            </div>
          </div>
        </div>
    `).join('');
}

function addFeatureCard() {
    repeaters.features.push({
        icon: 'bulb',
        title: 'New Feature Card',
        desc: 'We have focused on generating new knowledge & promoting.',
        btn_label: 'Read More',
        btn_url: '#',
        is_featured: false
    });
    syncRepeaterToTextarea('features');
    renderFeatures();
}

// ── 2. Testimonials Renderer ─────────────────────────────────
function renderTestimonials() {
    const c = document.getElementById('builder_testimonials');
    if (!c) return;
    const items = repeaters.testimonials;
    if (!items.length) {
        c.innerHTML = '<div class="cms-repeater-empty">No testimonials added. Click "+ Add Testimonial" above.</div>';
        return;
    }
    c.innerHTML = items.map((it, idx) => `
        <div class="cms-repeater-item ${it.is_featured ? 'is-featured' : ''}" data-idx="${idx}">
          <div class="cms-repeater-item-header">
            <span class="cms-repeater-item-badge">
              <span class="cms-badge ${it.is_featured ? 'cms-badge-accent' : 'cms-badge-green'}">#${idx + 1}</span>
              <strong>${escapeHtml(it.title || it.author_name || 'Testimonial')}</strong>
              ${it.is_featured ? '<span class="cms-badge cms-badge-accent ms-1">Featured (Dark Green)</span>' : ''}
            </span>
            <button type="button" class="cms-repeater-delete-btn" onclick="deleteRepeaterItem('testimonials', ${idx})">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Remove
            </button>
          </div>
          <div class="cms-input-row cms-grid-testi-top">
            <div class="cms-form-group">
              <label class="cms-label">Card Title / Summary</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.title || '')}" placeholder="e.g. A Truly Global Learning Experience"
                     oninput="repeaters.testimonials[${idx}].title = this.value; syncRepeaterToTextarea('testimonials');" />
            </div>
            <div class="cms-form-group cms-checkbox-group">
              <label class="cms-checkbox-label">
                <input type="checkbox" ${it.is_featured ? 'checked' : ''}
                       onchange="repeaters.testimonials[${idx}].is_featured = this.checked; syncRepeaterToTextarea('testimonials'); renderTestimonials();" />
                <span>Featured (Dark Green Card)</span>
              </label>
            </div>
          </div>
          <div class="cms-form-group">
            <label class="cms-label">Quote Body</label>
            <textarea class="cms-textarea cms-textarea-sm" placeholder="What did the student say?"
                      oninput="repeaters.testimonials[${idx}].quote = this.value; syncRepeaterToTextarea('testimonials');">${escapeHtml(it.quote || '')}</textarea>
          </div>
          <div class="cms-input-row cms-grid-testi-meta">
            <div class="cms-form-group mb-0">
              <label class="cms-label">Author Name</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.author_name || '')}" placeholder="e.g. Leslie Alexander"
                     oninput="repeaters.testimonials[${idx}].author_name = this.value; syncRepeaterToTextarea('testimonials');" />
            </div>
            <div class="cms-form-group mb-0">
              <label class="cms-label">Author Photo</label>
              <div class="cms-image-upload-wrap cms-upload-wrap-compact">
                <div class="cms-image-preview-box is-avatar cms-avatar-preview">
                  <img src="${escapeHtml(resolvePreviewUrl(it.author_avatar || ''))}" alt="Avatar" class="cms-preview-img ${it.author_avatar ? 'is-visible' : 'is-hidden'}" />
                  <div class="cms-upload-empty cms-upload-empty-xs ${!it.author_avatar ? 'is-visible' : 'is-hidden'}">No Img</div>
                </div>
                <div class="cms-upload-actions cms-upload-actions-compact">
                  <label class="cms-upload-btn cms-upload-btn-sm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <span>${it.author_avatar ? 'Change Photo' : 'Upload Photo'}</span>
                    <input type="file" accept="image/*" class="cms-file-input-hidden" onchange="uploadTestimonialAvatar(this, ${idx})" />
                  </label>
                  ${it.author_avatar ? `<button type="button" class="cms-remove-img-btn cms-remove-img-btn-sm" onclick="removeTestimonialAvatar(${idx})">Remove</button>` : ''}
                </div>
              </div>
            </div>
          </div>
        </div>
    `).join('');
}

function addTestimonialCard() {
    repeaters.testimonials.push({
        title: 'Inspiring Education Experience',
        quote: 'Studying here gave me unparalleled exposure and career readiness.',
        author_name: 'Student Name',
        author_avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
        rating: 5,
        is_featured: false
    });
    syncRepeaterToTextarea('testimonials');
    renderTestimonials();
}

// ── 3. FAQ Renderer ──────────────────────────────────────────
function renderFaq() {
    const c = document.getElementById('builder_faq');
    if (!c) return;
    const items = repeaters.faq;
    if (!items.length) {
        c.innerHTML = '<div class="cms-repeater-empty">No FAQ questions added. Click "+ Add FAQ Item" above.</div>';
        return;
    }
    c.innerHTML = items.map((it, idx) => `
        <div class="cms-repeater-item" data-idx="${idx}">
          <div class="cms-repeater-item-header">
            <span class="cms-repeater-item-badge">
              <span class="cms-badge cms-badge-green">Q${idx + 1}</span>
              <strong>${escapeHtml(it.question || 'New Question')}</strong>
            </span>
            <button type="button" class="cms-repeater-delete-btn" onclick="deleteRepeaterItem('faq', ${idx})">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Remove
            </button>
          </div>
          <div class="cms-form-group">
            <label class="cms-label">Question</label>
            <input type="text" class="cms-input" value="${escapeHtml(it.question || '')}" placeholder="What programs does the university offer?"
                   oninput="repeaters.faq[${idx}].question = this.value; syncRepeaterToTextarea('faq');" />
          </div>
          <div class="cms-form-group mb-0">
            <label class="cms-label">Answer</label>
            <textarea class="cms-textarea cms-textarea-sm" placeholder="Detailed answer..."
                      oninput="repeaters.faq[${idx}].answer = this.value; syncRepeaterToTextarea('faq');">${escapeHtml(it.answer || '')}</textarea>
          </div>
        </div>
    `).join('');
}

function addFaqItem() {
    repeaters.faq.push({
        question: 'New Question?',
        answer: 'Detailed explanation regarding programs, admissions, or requirements.'
    });
    syncRepeaterToTextarea('faq');
    renderFaq();
}

// Initial render
document.addEventListener('DOMContentLoaded', renderAllRepeaters);
renderAllRepeaters();

// ── Save Section Handler with Enhanced Feedback ──────────────
async function saveDestSec(section, btn) {
    window.cmsSyncEditors?.();
    syncAllRepeaters();

    const destId = <?= $activeId ?>;
    const fields = {};

    document.querySelectorAll(`[data-dest="${destId}"][data-section="${section}"]`).forEach(el => {
        fields[el.dataset.field] = el.value;
    });

    const origBtnHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.classList.add('is-saving');
        btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cms-spin"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> <span>Saving...</span>';
    }

    const data = new FormData();
    data.append('_csrf', CMS_CSRF);
    data.append('action', 'save_dest_section');
    data.append('destination_id', destId);
    data.append('section_key', section);
    for (const [k, v] of Object.entries(fields)) {
        data.append(`fields[${k}]`, v);
    }

    try {
        const res  = await fetch('../api/save.php', { method: 'POST', body: data });
        const json = await res.json();
        if (json.ok) {
            Toast.success(`Section "${section}" saved successfully!`);
            if (btn) {
                btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> <span>Saved!</span>';
                setTimeout(() => {
                    btn.disabled = false;
                    btn.classList.remove('is-saving');
                    btn.innerHTML = origBtnHtml;
                }, 1400);
            }
        } else {
            Toast.error(json.error ?? 'Save failed.');
            if (btn) {
                btn.disabled = false;
                btn.classList.remove('is-saving');
                btn.innerHTML = origBtnHtml;
            }
        }
    } catch (err) {
        Toast.error('Network error during save.');
        console.error(err);
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('is-saving');
            btn.innerHTML = origBtnHtml;
        }
    }
}

// ── Section Tabs Switcher & State ────────────────────────────
function cmsScrollTabs(wrapOrId, dir) {
    const wrap = typeof wrapOrId === 'string' ? document.getElementById(wrapOrId) : wrapOrId;
    if (!wrap) return;
    const amount = (dir || 1) * 280;
    wrap.scrollLeft += amount;
}
window.cmsScrollTabs = cmsScrollTabs;

function switchDestTab(secName, btn) {
    document.querySelectorAll('.dest-tab-btn').forEach(b => b.classList.remove('active'));
    const activeBtn = btn || document.querySelector(`.dest-tab-btn[data-sec="${secName}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
        if (typeof activeBtn.scrollIntoView === 'function') {
            activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
        }
    }

    const sections = ['hero', 'about', 'features', 'testimonials', 'faq', 'seo'];
    if (secName === 'all') {
        sections.forEach(s => {
            const el = document.getElementById(`sec-${s}`);
            if (el) el.style.display = 'block';
        });
    } else {
        sections.forEach(s => {
            const el = document.getElementById(`sec-${s}`);
            if (el) {
                el.style.display = (s === secName) ? 'block' : 'none';
            }
        });
    }

    // Update URL hash without causing a page jump
    if (history.replaceState) {
        history.replaceState(null, '', secName === 'all' ? '#all' : `#sec-${secName}`);
    }

    // Trigger window resize so CKEditor & repeaters refresh smoothly
    window.dispatchEvent(new Event('resize'));

    // Scroll up smoothly if user is scrolled past tabs
    const headerCard = document.querySelector('.dest-header-card');
    if (headerCard) {
        const topPos = headerCard.getBoundingClientRect().top + window.scrollY - 10;
        if (window.scrollY > topPos + 80) {
            window.scrollTo({ top: topPos, behavior: 'smooth' });
        }
    }
}

// ── Tab ScrollSpy in "All Sections" Mode ──────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const sections = ['sec-hero', 'sec-about', 'sec-features', 'sec-testimonials', 'sec-faq', 'sec-seo'].map(id => document.getElementById(id)).filter(Boolean);

    window.addEventListener('scroll', () => {
        const allBtn = document.querySelector('.dest-tab-btn[data-sec="all"]');
        if (!allBtn || !allBtn.classList.contains('active')) return;

        const scrollPos = window.scrollY + 130;
        let currentSec = sections[0];
        for (const sec of sections) {
            if (sec.offsetTop <= scrollPos) {
                currentSec = sec;
            }
        }
        if (currentSec) {
            const secKey = currentSec.id.replace('sec-', '');
            document.querySelectorAll('.dest-tab-btn').forEach(btn => {
                if (btn.dataset.sec === secKey) {
                    btn.classList.add('is-scrolled-active');
                } else {
                    btn.classList.remove('is-scrolled-active');
                }
            });
        }
    }, { passive: true });

    // Handle deep-link / URL hash on page load
    const hash = (window.location.hash || '').replace('#sec-', '').replace('#', '');
    const valid = ['hero', 'about', 'features', 'testimonials', 'faq', 'seo', 'all'];
    const initialSec = valid.includes(hash) ? hash : 'hero';
    const targetBtn = document.querySelector(`.dest-tab-btn[data-sec="${initialSec}"]`);
    if (targetBtn) {
        switchDestTab(initialSec, targetBtn);
    }
});
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
