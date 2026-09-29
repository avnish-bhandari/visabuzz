<?php
/**
 * services.php — Comprehensive Visa Services & Pathways Editor
 * Full management of the homepage interactive feature tabs section (#feature-tabs)
 * Including: Section Header, 4 Category Filter Pills, and 25 Detailed Showcase Tabs
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/feature_tabs_config.php';

cms_require_auth();

$pageTitle    = 'Visa Services & Pathways Editor';
$pageSlug     = 'services';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit all 4 categories, 25 pathways, bullet points, and showcase photos for the homepage';
$cmsRoot      = '../';

// ── Batch fetch all homepage values from DB in 1 fast query ───────────────────
$stmtHome = $pdo->prepare("SELECT section_key, field_key, field_value FROM cms_pages WHERE page_slug = 'home'");
$stmtHome->execute();
$hData = [];
foreach ($stmtHome->fetchAll() as $r) {
    $hData[$r['section_key']][$r['field_key']] = $r['field_value'];
}

function sval(array $data, string $sec, string $fld, string $default = ''): string {
    $val = $data[$sec][$fld] ?? '';
    return ($val !== '') ? $val : $default;
}

function cms_svc_img_src(string $url): string {
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

function cms_svc_flag_svg(string $slug, int $w = 20, int $h = 14): string {
    $s = strtolower(trim($slug));
    switch ($s) {
        case 'uk':
        case 'gb':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#fff" stroke-width="8"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#C8102E" stroke-width="4"/><path d="M30,0 v40 M0,20 h60" stroke="#fff" stroke-width="12"/><path d="M30,0 v40 M0,20 h60" stroke="#C8102E" stroke-width="7"/></svg>';
        case 'usa':
        case 'us':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#fff"/><path d="M0,3.1h60 M0,9.2h60 M0,15.4h60 M0,21.5h60 M0,27.7h60 M0,33.8h60 M0,40h60" stroke="#B22234" stroke-width="3.1"/><rect width="26" height="21.5" fill="#3C3B6E"/><circle cx="5.5" cy="4.5" r="1.1" fill="#fff"/><circle cx="13" cy="4.5" r="1.1" fill="#fff"/><circle cx="20.5" cy="4.5" r="1.1" fill="#fff"/><circle cx="9.25" cy="9.5" r="1.1" fill="#fff"/><circle cx="16.75" cy="9.5" r="1.1" fill="#fff"/><circle cx="5.5" cy="14.5" r="1.1" fill="#fff"/><circle cx="13" cy="14.5" r="1.1" fill="#fff"/><circle cx="20.5" cy="14.5" r="1.1" fill="#fff"/></svg>';
        case 'ireland':
        case 'ie':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="20" height="40" fill="#169B62"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#FF883E"/></svg>';
        case 'canada':
        case 'ca':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="15" height="40" fill="#D80027"/><rect x="15" width="30" height="40" fill="#ffffff"/><rect x="45" width="15" height="40" fill="#D80027"/><path d="M30 10l1.4 4.2 3.6-1.4-1.2 4.2 4 1-3.6 2.8 1.8 4.2-4.8-1.8v3.8h-2.4V27l-4.8 1.8 1.8-4.2-3.6-2.8 4-1-1.2-4.2 3.6 1.4z" fill="#D80027"/></svg>';
        case 'germany':
        case 'de':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="13.33" fill="#000000"/><rect y="13.33" width="60" height="13.33" fill="#DD0000"/><rect y="26.66" width="60" height="13.34" fill="#FFCE00"/></svg>';
        case 'dubai':
        case 'ae':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="13.33" fill="#00732F"/><rect y="13.33" width="60" height="13.33" fill="#ffffff"/><rect y="26.66" width="60" height="13.34" fill="#000000"/><rect width="17" height="40" fill="#FF0000"/></svg>';
        case 'france':
        case 'fr':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="20" height="40" fill="#002654"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#CE1126"/></svg>';
        case 'europe':
        case 'eu':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#003399"/><circle cx="30" cy="8" r="1.4" fill="#FFCC00"/><circle cx="36" cy="9.6" r="1.4" fill="#FFCC00"/><circle cx="40.4" cy="14" r="1.4" fill="#FFCC00"/><circle cx="42" cy="20" r="1.4" fill="#FFCC00"/><circle cx="40.4" cy="26" r="1.4" fill="#FFCC00"/><circle cx="36" cy="30.4" r="1.4" fill="#FFCC00"/><circle cx="30" cy="32" r="1.4" fill="#FFCC00"/><circle cx="24" cy="30.4" r="1.4" fill="#FFCC00"/><circle cx="19.6" cy="26" r="1.4" fill="#FFCC00"/><circle cx="18" cy="20" r="1.4" fill="#FFCC00"/><circle cx="19.6" cy="14" r="1.4" fill="#FFCC00"/><circle cx="24" cy="9.6" r="1.4" fill="#FFCC00"/></svg>';
        case 'italy':
        case 'it':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="20" height="40" fill="#009246"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#CE2B37"/></svg>';
        default:
            return '<svg width="' . $w . '" height="' . $h . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>';
    }
}

$tabsCfg = cms_get_feature_tabs_config();

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- Feature Tabs Header Bar -->
<div class="dest-header-card">
  <!-- Header Top -->
  <div class="dest-header-bar">
    <div class="dest-header-title">
      <span class="dest-header-flag">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#193822" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
          <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
        </svg>
      </span>
      <div class="dest-header-text">
        <span class="dest-header-kicker">Homepage Feature Tabs Showcase</span>
        <div class="dest-header-heading">
          <strong>Comprehensive Visa Services & Pathways</strong>
          <span class="cms-badge cms-badge-accent">page_slug=home</span>
          <span class="dest-section-count">4 Categories • 25 Pathways</span>
        </div>
      </div>
    </div>
    <div class="dest-header-actions">
      <a href="../../index.php#feature-tabs" target="_blank" class="cms-btn cms-btn-secondary dest-preview-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        <span>Preview Live Showcase</span>
      </a>
    </div>
  </div>

  <!-- Primary Top Level Tabs: Header + 4 Categories -->
  <div class="dest-tabs-bar-outer">
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-prev" onclick="cmsScrollTabs('svcMainTabsWrap', -1)" aria-label="Scroll tabs left">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <div class="dest-tabs-wrap" id="svcMainTabsWrap">
      <ul class="dest-nav-tabs" role="tablist">
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn active" data-cat="tabs_header" onclick="switchSvcCategory('tabs_header', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            <span class="dest-tab-label">1. Section Header & Pills</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-cat="study" onclick="switchSvcCategory('study', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            <span class="dest-tab-label">2. Study Global (9 Countries)</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-cat="offerings" onclick="switchSvcCategory('offerings', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span class="dest-tab-label">3. Offerings (4 Pathways)</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-cat="platform" onclick="switchSvcCategory('platform', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h7v7H4V4zm10 0h6v7h-6V4zM4 14h7v6H4v-6zm10 0h6v6h-6v-6z"/></svg>
            <span class="dest-tab-label">4. Platform (4 Services)</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-cat="resources" onclick="switchSvcCategory('resources', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            <span class="dest-tab-label">5. Resources (8 Guides)</span>
          </button>
        </li>
        <li class="dest-tab-item dest-tab-item-all">
          <button type="button" class="dest-tab-btn dest-tab-btn-all" data-cat="all" onclick="switchSvcCategory('all', this)" title="Show all sections together">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            <span class="dest-tab-label">All Sections</span>
          </button>
        </li>
      </ul>
    </div>
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-next" onclick="cmsScrollTabs('svcMainTabsWrap', 1)" aria-label="Scroll tabs right">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  </div>
</div>

<!-- ======================================================================
     SECTION 1: SECTION HEADER & CATEGORY PILLS
     ====================================================================== -->
<div class="cms-card cms-svc-cat-block" id="cat-tabs_header">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        1. Section Header & Category Filter Pills
      </div>
      <div class="cms-card-subtitle">Edit the primary section title and the 4 top filter pill labels</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSvcSection('tabs_header', this)">Save Header & Pills</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="tabs_header_title">Main Section Title (H2)</label>
    <input type="text" id="tabs_header_title" class="cms-input"
           value="<?= htmlspecialchars(sval($hData, 'tabs_header', 'title', $tabsCfg['header']['default_title'])) ?>"
           data-section="tabs_header" data-field="title" />
  </div>

  <div class="cms-section-divider">Top Category Filter Pill Labels</div>
  <div class="cms-input-row" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;">
    <?php foreach ($tabsCfg['header']['pills'] as $catKey => $pillInfo): 
        $val = sval($hData, 'tabs_header', $pillInfo['key'], $pillInfo['label']);
    ?>
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">Category <?= ucfirst($catKey) ?> Pill Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($val) ?>"
             data-section="tabs_header" data-field="<?= $pillInfo['key'] ?>" />
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ======================================================================
     SECTIONS 2 - 5: THE 4 CATEGORIES WITH THEIR SUB-TABS
     ====================================================================== -->
<?php foreach ($tabsCfg['categories'] as $catKey => $catData): 
    $tabCount = count($catData['tabs']);
?>
<div class="cms-card cms-svc-cat-block" id="cat-<?= $catKey ?>" style="padding:0;overflow:hidden;">

  <!-- Category Title Bar -->
  <div class="cms-card-header" style="padding:20px 24px;border-bottom:1px solid var(--border-muted);background:#fff;">
    <div>
      <div class="cms-card-title">
        <?= $catData['pill_icon'] ?>
        <span>Category: <?= htmlspecialchars($catData['pill_label']) ?></span>
        <span class="cms-badge cms-badge-green"><?= $tabCount ?> Pathways</span>
      </div>
      <div class="cms-card-subtitle">Manage all tabs, 3 bullet points, CTA button, and showcase image for <?= htmlspecialchars($catData['pill_label']) ?></div>
    </div>
    <div style="display:flex;gap:10px;">
      <button type="button" class="cms-btn cms-btn-primary" onclick="saveActiveSubTab('<?= $catKey ?>', this)">Save Active Tab</button>
    </div>
  </div>

  <!-- Sub-Tabs Navigation Strip -->
  <div class="svc-subnav-strip">
    <div class="svc-subnav-label">
      <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
      <span>Select Tab:</span>
    </div>

    <div class="svc-subnav-scroll-wrap">
      <button type="button" class="svc-subnav-arrow-btn" onclick="scrollSvcSubtabs('subnav-<?= $catKey ?>', -1)" title="Scroll tabs left" aria-label="Scroll left">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
      </button>

      <div class="svc-subnav-track" id="subnav-<?= $catKey ?>">
        <?php 
        $isFirstSub = true;
        foreach ($catData['tabs'] as $tabId => $tabInfo): 
            $activeClass = $isFirstSub ? 'active' : '';
            $tabLabelVal = sval($hData, $tabInfo['sec_key'], 'tab_label', $tabInfo['tab_label']);
        ?>
        <button type="button" 
                class="subtab-pill-btn <?= $activeClass ?>"
                data-cat="<?= $catKey ?>" 
                data-tab="<?= $tabId ?>"
                onclick="switchSvcSubTab('<?= $catKey ?>', '<?= $tabId ?>', this)">
          <?php if (!empty($tabInfo['flag'])): ?>
            <?= cms_svc_flag_svg($tabInfo['flag'], 16, 11) ?>
          <?php endif; ?>
          <span><?= htmlspecialchars($tabLabelVal) ?></span>
        </button>
        <?php 
            $isFirstSub = false;
        endforeach; 
        ?>
      </div>

      <button type="button" class="svc-subnav-arrow-btn" onclick="scrollSvcSubtabs('subnav-<?= $catKey ?>', 1)" title="Scroll tabs right" aria-label="Scroll right">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  </div>

  <!-- Sub-Tabs Content Panels -->
  <div style="padding:24px;">
    <?php 
    $isFirstPanel = true;
    foreach ($catData['tabs'] as $tabId => $tabInfo): 
        $secKey = $tabInfo['sec_key'];
        $curLabel = sval($hData, $secKey, 'tab_label', $tabInfo['tab_label']);
        $curCtaLabel = sval($hData, $secKey, 'cta_label', $tabInfo['cta_label']);
        $curCtaUrl   = sval($hData, $secKey, 'cta_url',   $tabInfo['cta_url']);
        $curImage    = sval($hData, $secKey, 'image',     $tabInfo['image']);
        $curImageAlt = sval($hData, $secKey, 'image_alt', $tabInfo['image_alt']);
        $displayStyle = $isFirstPanel ? 'block' : 'none';
    ?>
    <div class="svc-subpanel-wrap" id="panel-<?= $catKey ?>-<?= $tabId ?>" style="display:<?= $displayStyle ?>;" data-cat="<?= $catKey ?>" data-tab="<?= $tabId ?>" data-sec="<?= $secKey ?>">

      <!-- Top subpanel bar -->
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid var(--border-muted);">
        <div style="display:flex;align-items:center;gap:10px;">
          <?php if (!empty($tabInfo['flag'])): ?>
            <?= cms_svc_flag_svg($tabInfo['flag'], 24, 16) ?>
          <?php endif; ?>
          <strong style="font-size:15px;color:var(--text-primary);"><?= htmlspecialchars($curLabel) ?></strong>
          <span class="cms-badge cms-badge-green" style="font-size:11px;">section_key=<?= htmlspecialchars($secKey) ?></span>
        </div>
        <button type="button" class="cms-btn cms-btn-primary" onclick="saveSvcSection('<?= $secKey ?>', this)">
          Save "<?= htmlspecialchars($curLabel) ?>"
        </button>
      </div>

      <!-- Tab Button Label -->
      <div class="cms-form-group">
        <label class="cms-label">Tab Button Label (shown on left vertical list)</label>
        <input type="text" class="cms-input" value="<?= htmlspecialchars($curLabel) ?>"
               data-section="<?= $secKey ?>" data-field="tab_label" />
      </div>

      <!-- 3 Feature Bullets Grid -->
      <div class="cms-section-divider">3 Feature Highlights</div>
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:16px;margin-bottom:22px;">
        <?php for ($i = 1; $i <= 3; $i++): 
            $badgeColor = ($i === 1) ? '#10b981' : (($i === 2) ? '#8b5cf6' : '#3b82f6');
            $badgeClass = ($i === 1) ? 'badge-green' : (($i === 2) ? 'badge-purple' : 'badge-blue');
            $curItemTitle = sval($hData, $secKey, "item{$i}_title", $tabInfo['items'][$i]['title']);
            $curItemDesc  = sval($hData, $secKey, "item{$i}_desc",  $tabInfo['items'][$i]['desc']);
        ?>
        <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:16px 18px;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
            <span style="width:10px;height:10px;border-radius:50%;background:<?= $badgeColor ?>;display:inline-block;"></span>
            <strong style="font-size:13px;color:var(--text-primary);">Feature Highlight #<?= $i ?></strong>
            <span class="cms-badge" style="margin-left:auto;font-size:10.5px;"><?= $badgeClass ?></span>
          </div>

          <div class="cms-form-group" style="margin-bottom:10px;">
            <label class="cms-label" style="font-size:12px;">Bullet Title</label>
            <input type="text" class="cms-input" value="<?= htmlspecialchars($curItemTitle) ?>"
                   data-section="<?= $secKey ?>" data-field="item<?= $i ?>_title" />
          </div>

          <div class="cms-form-group" style="margin-bottom:0;">
            <label class="cms-label" style="font-size:12px;">Description Text</label>
            <textarea class="cms-textarea" style="min-height:75px;font-size:12.5px;"
                      data-section="<?= $secKey ?>" data-field="item<?= $i ?>_desc"><?= htmlspecialchars($curItemDesc) ?></textarea>
          </div>
        </div>
        <?php endfor; ?>
      </div>

      <!-- Action Button & Visual Showcase Row -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        <!-- Left: CTA Action Button -->
        <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:16px 18px;">
          <strong style="font-size:13px;color:var(--text-primary);display:block;margin-bottom:12px;">Call-to-Action Button</strong>
          <div class="cms-form-group">
            <label class="cms-label" style="font-size:12px;">Button Text</label>
            <input type="text" class="cms-input" value="<?= htmlspecialchars($curCtaLabel) ?>"
                   data-section="<?= $secKey ?>" data-field="cta_label" />
          </div>
          <div class="cms-form-group" style="margin-bottom:0;">
            <label class="cms-label" style="font-size:12px;">Target URL / Link</label>
            <input type="text" class="cms-input" value="<?= htmlspecialchars($curCtaUrl) ?>"
                   data-section="<?= $secKey ?>" data-field="cta_url" />
          </div>
        </div>

        <!-- Right: Showcase Image -->
        <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:16px 18px;">
          <strong style="font-size:13px;color:var(--text-primary);display:block;margin-bottom:12px;">Showcase Image & Alt Text</strong>
          <?php 
          $fieldId = "img_{$secKey}";
          $previewSrc = cms_svc_img_src($curImage);
          $hasImg = !empty($curImage);
          ?>
          <div class="cms-image-upload-wrap" style="align-items:flex-start;">
            <div class="cms-image-preview-box" id="box_<?= $fieldId ?>" style="width:110px;height:75px;border-radius:6px;">
              <img id="prev_<?= $fieldId ?>" src="<?= htmlspecialchars($previewSrc) ?>" alt="Preview" class="cms-preview-img <?= $hasImg ? 'is-visible' : 'is-hidden' ?>" style="object-fit:cover;" />
              <div class="cms-upload-empty <?= !$hasImg ? 'is-visible' : 'is-hidden' ?>" style="font-size:11px;">No Image</div>
            </div>
            <div class="cms-upload-content" style="flex:1;">
              <div class="cms-upload-actions">
                <label class="cms-upload-btn" style="padding:5px 10px;font-size:12px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                  <span><?= $hasImg ? 'Change' : 'Upload' ?></span>
                  <input type="file" accept="image/*" class="cms-file-input-hidden" onchange="cmsUploadFile(this, 'hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')" />
                </label>
                <button type="button" class="cms-remove-img-btn" style="font-size:12px;" onclick="cmsRemoveImage('hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')">Remove</button>
              </div>
              <div style="margin-top:6px;">
                <input type="text" class="cms-input" style="font-size:11.5px;padding:5px 8px;height:auto;"
                       placeholder="Paste image URL..."
                       value="<?= htmlspecialchars($curImage) ?>"
                       oninput="document.getElementById('hid_<?= $fieldId ?>').value=this.value; document.getElementById('prev_<?= $fieldId ?>').src=this.value; document.getElementById('prev_<?= $fieldId ?>').classList.toggle('is-visible', !!this.value); document.getElementById('prev_<?= $fieldId ?>').classList.toggle('is-hidden', !this.value); document.querySelector('#box_<?= $fieldId ?> .cms-upload-empty').classList.toggle('is-visible', !this.value); document.querySelector('#box_<?= $fieldId ?> .cms-upload-empty').classList.toggle('is-hidden', !!this.value);" />
              </div>
              <input type="hidden" id="hid_<?= $fieldId ?>" class="cms-input" data-section="<?= $secKey ?>" data-field="image" value="<?= htmlspecialchars($curImage) ?>" />
            </div>
          </div>

          <div class="cms-form-group" style="margin-top:10px;margin-bottom:0;">
            <label class="cms-label" style="font-size:12px;">Image Alt Text</label>
            <input type="text" class="cms-input" style="font-size:12px;" value="<?= htmlspecialchars($curImageAlt) ?>"
                   data-section="<?= $secKey ?>" data-field="image_alt" placeholder="e.g. Students studying in UK" />
          </div>
        </div>

      </div>

    </div>
    <?php 
        $isFirstPanel = false;
    endforeach; 
    ?>
  </div>

</div>
<?php endforeach; ?>

<script>
// ── Category Switcher ─────────────────────────────────────────
function switchSvcCategory(catName, btn) {
    document.querySelectorAll('#svcMainTabsWrap .dest-tab-btn').forEach(b => b.classList.remove('active'));
    const activeBtn = btn || document.querySelector(`#svcMainTabsWrap .dest-tab-btn[data-cat="${catName}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
        activeBtn.scrollIntoView?.({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
    }

    const categories = ['tabs_header', 'study', 'offerings', 'platform', 'resources'];
    if (catName === 'all') {
        categories.forEach(c => {
            const el = document.getElementById(`cat-${c}`);
            if (el) el.style.display = 'block';
        });
    } else {
        categories.forEach(c => {
            const el = document.getElementById(`cat-${c}`);
            if (el) el.style.display = (c === catName) ? 'block' : 'none';
        });
    }

    if (history.replaceState) {
        history.replaceState(null, '', catName === 'all' ? '#all' : `#cat-${catName}`);
    }

    window.dispatchEvent(new Event('resize'));
}

// ── Sub-Tab Switcher within a category ────────────────────────
function switchSvcSubTab(catName, tabId, btn) {
    const parentNav = document.getElementById(`subnav-${catName}`);
    if (parentNav) {
        parentNav.querySelectorAll('.subtab-pill-btn').forEach(b => b.classList.remove('active'));
    }
    if (btn) {
        btn.classList.add('active');
        btn.scrollIntoView?.({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
    }

    // Hide all subpanels for this category
    document.querySelectorAll(`.svc-subpanel-wrap[data-cat="${catName}"]`).forEach(p => {
        p.style.display = 'none';
    });

    // Show target subpanel
    const target = document.getElementById(`panel-${catName}-${tabId}`);
    if (target) {
        target.style.display = 'block';
    }
}
window.switchSvcSubTab = switchSvcSubTab;

function scrollSvcSubtabs(navId, direction) {
    const track = document.getElementById(navId);
    if (track) {
        track.scrollBy({ left: direction * 180, behavior: 'smooth' });
    }
}
window.scrollSvcSubtabs = scrollSvcSubtabs;

// ── Save Current Active Sub-Tab ───────────────────────────────
function saveActiveSubTab(catKey, btn) {
    const activePanel = document.querySelector(`.svc-subpanel-wrap[data-cat="${catKey}"]:not([style*="display: none"])`);
    if (activePanel) {
        const secKey = activePanel.dataset.sec;
        saveSvcSection(secKey, btn);
    } else {
        Toast.error('No active tab found in this category.');
    }
}

// ── Save Section Handler with Feedback ────────────────────────
async function saveSvcSection(section, btn) {
    window.cmsSyncEditors?.();
    const fields = {};
    document.querySelectorAll(`[data-section="${section}"]`).forEach(el => {
        fields[el.dataset.field] = el.value;
    });

    const origBtnHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.classList.add('is-saving');
        btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cms-spin"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> <span>Saving...</span>';
    }

    const data = new FormData();
    data.append('_csrf',        CMS_CSRF);
    data.append('action',       'save_page_fields');
    data.append('page_slug',    'home');
    data.append('section_key',  section);
    for (const [k, v] of Object.entries(fields)) data.append(`fields[${k}]`, v);

    try {
        const res  = await fetch('../api/save.php', { method: 'POST', body: data });
        const json = await res.json();
        if (json.ok) {
            Toast.success(`Saved successfully!`);
            if (btn) {
                btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> <span>Saved!</span>';
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
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('is-saving');
            btn.innerHTML = origBtnHtml;
        }
    }
}

// ── Image Removal Helper ──────────────────────────────────────
function cmsRemoveImage(hidId, prevId) {
    const hid = document.getElementById(hidId);
    const prev = document.getElementById(prevId);
    if (hid) {
        hid.value = '';
        hid.dispatchEvent(new Event('input', { bubbles: true }));
    }
    if (prev) {
        prev.src = '';
        prev.classList.remove('is-visible');
        prev.classList.add('is-hidden');
    }
    const box = prev?.parentElement;
    if (box) {
        const empty = box.querySelector('.cms-upload-empty');
        if (empty) {
            empty.classList.remove('is-hidden');
            empty.classList.add('is-visible');
        }
    }
}

// ── Initial load hash router ──────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const hash = (window.location.hash || '').replace('#cat-', '').replace('#', '');
    const valid = ['tabs_header', 'study', 'offerings', 'platform', 'resources', 'all'];
    const initialCat = valid.includes(hash) ? hash : 'tabs_header';
    const targetBtn = document.querySelector(`#svcMainTabsWrap .dest-tab-btn[data-cat="${initialCat}"]`);
    if (targetBtn) {
        switchSvcCategory(initialCat, targetBtn);
    }
});
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
