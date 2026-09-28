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
          <img id="prev_<?= $fieldId ?>" src="<?= htmlspecialchars($previewSrc) ?>" alt="Preview" style="<?= $hasImg ? 'display:block;' : 'display:none;' ?>" />
          <div class="cms-upload-empty" style="<?= !$hasImg ? 'display:block;' : 'display:none;' ?>">No Image</div>
        </div>
        <div class="cms-upload-content" style="flex:1;">
          <div class="cms-upload-actions">
            <label class="cms-upload-btn">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span><?= $hasImg ? 'Change Image' : 'Upload Image' ?></span>
              <input type="file" accept="image/*" style="display:none;" onchange="cmsUploadFile(this, 'hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')" />
            </label>
            <button type="button" class="cms-remove-img-btn" onclick="cmsRemoveImage('hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')">Remove</button>
          </div>
          <div style="font-size:12px; color:var(--text-muted); margin-top:6px;"><?= htmlspecialchars($helpText) ?> (JPG, PNG, WebP, SVG)</div>
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

<!-- Destination Selector Pills -->
<div class="dest-country-pills">
  <?php foreach ($destinations as $d):
      $activeClass = ($d['id'] == $activeId) ? ' active' : '';
      $slugKey     = strtolower($d['country_slug']);
      $cCode       = $countryCodes[$slugKey] ?? strtoupper(substr($slugKey, 0, 2));
  ?>
  <a href="destination-content.php?id=<?= $d['id'] ?>" class="dest-pill<?= $activeClass ?>">
    <span class="dest-pill-code"><?= $cCode ?></span>
    <span><?= htmlspecialchars($d['country_name']) ?></span>
  </a>
  <?php endforeach; ?>
</div>

<!-- Active Country Banner -->
<div class="dest-header-bar">
  <div class="dest-header-title">
    <span class="dest-pill-code" style="width:28px;height:28px;font-size:12px;background:#ecfdf5;color:#16a34a;border:1px solid #bbf7d0;">
      <?= $countryCodes[strtolower($activeDest['country_slug'])] ?? strtoupper(substr($activeDest['country_slug'], 0, 2)) ?>
    </span>
    <span>Editing: <strong><?= htmlspecialchars($activeDest['country_name']) ?></strong></span>
    <span class="cms-badge cms-badge-accent">?country=<?= htmlspecialchars($activeDest['country_slug']) ?></span>
  </div>
  <div style="display:flex;gap:10px;align-items:center;">
    <a href="../../study-global.php?country=<?= htmlspecialchars($activeDest['country_slug']) ?>"
       target="_blank" class="cms-btn cms-btn-secondary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      Preview Live Page
    </a>
  </div>
</div>

<!-- Quick Section Navigator -->
<div class="dest-section-nav">
  <a href="#sec-hero" class="dest-nav-chip">1. Hero</a>
  <a href="#sec-about" class="dest-nav-chip">2. About / Potential</a>
  <a href="#sec-features" class="dest-nav-chip">3. Why Choose Us</a>
  <a href="#sec-testimonials" class="dest-nav-chip">4. Testimonials</a>
  <a href="#sec-faq" class="dest-nav-chip">5. FAQ</a>
  <a href="#sec-seo" class="dest-nav-chip">6. SEO Meta</a>
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
    <button class="cms-btn cms-btn-primary" onclick="saveDestSec('hero')">Save Hero</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Main Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="hero" data-field="title"
           value="<?= htmlspecialchars(strip_tags(fval($secData, 'hero', 'title', 'Turn Your Ambition into Achievement'))) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Subtitle Description</label>
    <textarea class="cms-textarea cms-ckeditor" style="min-height:75px" data-dest="<?= $activeId ?>" data-section="hero" data-field="subtitle"><?= htmlspecialchars(fval($secData, 'hero', 'subtitle', 'Empowering students with world-class education, innovation, and global opportunities.')) ?></textarea>
  </div>

  <div class="cms-card-subtitle" style="margin: 16px 0 8px; font-weight:600; color:var(--text-primary);">Hero Right Side — Fast Facts Card (No Images)</div>
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

  <div class="cms-card-subtitle" style="margin: 16px 0 8px; font-weight:600; color:var(--text-primary);">Call To Action Buttons</div>
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

  <div class="cms-card-subtitle" style="margin: 16px 0 8px; font-weight:600; color:var(--text-primary);">Social Proof &amp; Statistics</div>
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

  <div class="cms-card-subtitle" style="margin: 16px 0 8px; font-weight:600; color:var(--text-primary);">Hero Visual Image</div>
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
    <button class="cms-btn cms-btn-primary" onclick="saveDestSec('about')">Save About</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Main Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="about" data-field="heading"
           value="<?= htmlspecialchars(fval($secData, 'about', 'heading', 'The right opportunity can turn dreams into limitless potential.')) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Narrative Paragraph</label>
    <textarea class="cms-textarea cms-ckeditor" style="min-height:90px" data-dest="<?= $activeId ?>" data-section="about" data-field="desc"><?= htmlspecialchars(fval($secData, 'about', 'desc', 'Founded in 1999, NUOVA EDILE COSTANZA is a community - driven institution renowned for it\'s unique contributions.')) ?></textarea>
  </div>

  <div class="cms-card-subtitle" style="margin: 16px 0 8px; font-weight:600; color:var(--text-primary);">Progress Metrics</div>
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

  <div class="cms-card-subtitle" style="margin: 16px 0 8px; font-weight:600; color:var(--text-primary);">About Section Photos</div>
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
    <button class="cms-btn cms-btn-primary" onclick="saveDestSec('features')">Save Why Choose Us</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="features" data-field="title"
           value="<?= htmlspecialchars(fval($secData, 'features', 'title', 'One of the largest, most diverse universities in the World')) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Subtitle</label>
    <textarea class="cms-textarea cms-ckeditor" style="min-height:75px" data-dest="<?= $activeId ?>" data-section="features" data-field="subtitle"><?= htmlspecialchars(fval($secData, 'features', 'subtitle', 'Home to students from every corner of the globe, fostering diversity, inclusion, and world-class academic excellence.')) ?></textarea>
  </div>

  <!-- Hidden JSON textarea synced automatically -->
  <textarea id="ta_features" class="cms-repeater-hidden" style="display:none;"
            data-dest="<?= $activeId ?>" data-section="features" data-field="cards_json"><?= htmlspecialchars(fjson($secData, 'features', 'cards_json', '[]')) ?></textarea>

  <div class="cms-card-subtitle" style="margin: 20px 0 10px; display:flex; justify-content:space-between; align-items:center;">
    <span style="font-weight:600; color:var(--text-primary);">Feature Cards List</span>
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
    <button class="cms-btn cms-btn-primary" onclick="saveDestSec('testimonials')">Save Testimonials</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Title</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="testimonials" data-field="title"
             value="<?= htmlspecialchars(fval($secData, 'testimonials', 'title', 'Voices From Our Global Community')) ?>" />
  </div>

  <!-- Hidden JSON textarea synced automatically -->
  <textarea id="ta_testimonials" class="cms-repeater-hidden" style="display:none;"
            data-dest="<?= $activeId ?>" data-section="testimonials" data-field="cards_json"><?= htmlspecialchars(fjson($secData, 'testimonials', 'cards_json', '[]')) ?></textarea>

  <div class="cms-card-subtitle" style="margin: 20px 0 10px; display:flex; justify-content:space-between; align-items:center;">
    <span style="font-weight:600; color:var(--text-primary);">Testimonials Cards List</span>
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
    <button class="cms-btn cms-btn-primary" onclick="saveDestSec('faq')">Save FAQ</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Heading</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="faq" data-field="title"
           value="<?= htmlspecialchars(fval($secData, 'faq', 'title', 'Frequently Asked Questions?')) ?>" />
  </div>

  <?php render_cms_image_upload('Left Facade Photo', $activeId, 'faq', 'img_url', fval($secData, 'faq', 'img_url', 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=900&q=80'), 'faq_img', 'Historic building or campus facade photo'); ?>

  <!-- Hidden JSON textarea synced automatically -->
  <textarea id="ta_faq" class="cms-repeater-hidden" style="display:none;"
            data-dest="<?= $activeId ?>" data-section="faq" data-field="items_json"><?= htmlspecialchars(fjson($secData, 'faq', 'items_json', '[]')) ?></textarea>

  <div class="cms-card-subtitle" style="margin: 20px 0 10px; display:flex; justify-content:space-between; align-items:center;">
    <span style="font-weight:600; color:var(--text-primary);">FAQ Questions &amp; Answers List</span>
    <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="addFaqItem()">+ Add FAQ Item</button>
  </div>

  <div id="builder_faq" class="cms-repeater-list"></div>
</div>

<!-- ══════════════════════════════════════════════════════════
     7. SEO META
══════════════════════════════════════════════════════════ -->
<div class="cms-card" id="sec-seo">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">6. Search Engine Optimization (SEO)</div>
      <div class="cms-card-subtitle">Search snippet title and description tags</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveDestSec('seo')">Save SEO</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Meta Page Title</label>
    <input type="text" class="cms-input" data-dest="<?= $activeId ?>" data-section="seo" data-field="title"
           value="<?= htmlspecialchars(fval($secData, 'seo', 'title', "Study in {$activeDest['country_name']} — Visabuz")) ?>" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Meta Description</label>
    <textarea class="cms-textarea" style="min-height:70px" data-dest="<?= $activeId ?>" data-section="seo" data-field="description"><?= htmlspecialchars(fval($secData, 'seo', 'description', "Complete guide to studying in {$activeDest['country_name']} with Visabuz.")) ?></textarea>
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
        <div class="cms-repeater-item" data-idx="${idx}">
          <div class="cms-repeater-item-header">
            <span class="cms-repeater-item-badge">
              <span class="cms-badge ${it.is_featured ? 'cms-badge-accent' : 'cms-badge-green'}">#${idx + 1}</span>
              <strong>${escapeHtml(it.title || 'Feature Card')}</strong>
              ${it.is_featured ? '<span class="cms-badge cms-badge-accent" style="margin-left:6px;">Featured</span>' : ''}
            </span>
            <button type="button" class="cms-repeater-delete-btn" onclick="deleteRepeaterItem('features', ${idx})">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Remove
            </button>
          </div>
          <div class="cms-input-row" style="grid-template-columns: 140px 1.5fr 1fr;">
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
            <div class="cms-form-group" style="display:flex; align-items:center; gap:8px; padding-top:24px;">
              <label style="cursor:pointer; display:flex; align-items:center; gap:8px; font-weight:500;">
                <input type="checkbox" ${it.is_featured ? 'checked' : ''}
                       onchange="repeaters.features[${idx}].is_featured = this.checked; syncRepeaterToTextarea('features'); renderFeatures();" />
                Featured (Dark Border)
              </label>
            </div>
          </div>
          <div class="cms-form-group">
            <label class="cms-label">Description Text</label>
            <textarea class="cms-textarea" style="min-height:55px;" placeholder="Brief description..."
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
        <div class="cms-repeater-item" data-idx="${idx}">
          <div class="cms-repeater-item-header">
            <span class="cms-repeater-item-badge">
              <span class="cms-badge ${it.is_featured ? 'cms-badge-accent' : 'cms-badge-green'}">#${idx + 1}</span>
              <strong>${escapeHtml(it.title || it.author_name || 'Testimonial')}</strong>
              ${it.is_featured ? '<span class="cms-badge cms-badge-accent" style="margin-left:6px;">Featured (Dark Green)</span>' : ''}
            </span>
            <button type="button" class="cms-repeater-delete-btn" onclick="deleteRepeaterItem('testimonials', ${idx})">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Remove
            </button>
          </div>
          <div class="cms-input-row" style="grid-template-columns: 1.5fr 1fr;">
            <div class="cms-form-group">
              <label class="cms-label">Card Title / Summary</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.title || '')}" placeholder="e.g. A Truly Global Learning Experience"
                     oninput="repeaters.testimonials[${idx}].title = this.value; syncRepeaterToTextarea('testimonials');" />
            </div>
            <div class="cms-form-group" style="display:flex; align-items:center; gap:8px; padding-top:24px;">
              <label style="cursor:pointer; display:flex; align-items:center; gap:8px; font-weight:500;">
                <input type="checkbox" ${it.is_featured ? 'checked' : ''}
                       onchange="repeaters.testimonials[${idx}].is_featured = this.checked; syncRepeaterToTextarea('testimonials'); renderTestimonials();" />
                Featured (Dark Green Card)
              </label>
            </div>
          </div>
          <div class="cms-form-group">
            <label class="cms-label">Quote Body</label>
            <textarea class="cms-textarea" style="min-height:60px;" placeholder="What did the student say?"
                      oninput="repeaters.testimonials[${idx}].quote = this.value; syncRepeaterToTextarea('testimonials');">${escapeHtml(it.quote || '')}</textarea>
          </div>
          <div class="cms-input-row" style="grid-template-columns: 1fr 1.5fr; align-items:flex-end;">
            <div class="cms-form-group" style="margin-bottom:0;">
              <label class="cms-label">Author Name</label>
              <input type="text" class="cms-input" value="${escapeHtml(it.author_name || '')}" placeholder="e.g. Leslie Alexander"
                     oninput="repeaters.testimonials[${idx}].author_name = this.value; syncRepeaterToTextarea('testimonials');" />
            </div>
            <div class="cms-form-group" style="margin-bottom:0;">
              <label class="cms-label">Author Photo</label>
              <div class="cms-image-upload-wrap" style="padding:6px 12px; min-height:50px;">
                <div class="cms-image-preview-box is-avatar" style="width:40px; height:40px;">
                  <img src="${escapeHtml(resolvePreviewUrl(it.author_avatar || ''))}" alt="Avatar" style="${it.author_avatar ? 'display:block;' : 'display:none;'}" />
                  <div class="cms-upload-empty" style="${!it.author_avatar ? 'display:block;' : 'display:none; font-size:10px;'}">No Img</div>
                </div>
                <div class="cms-upload-actions" style="gap:8px;">
                  <label class="cms-upload-btn" style="padding:5px 12px; font-size:12px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <span>${it.author_avatar ? 'Change Photo' : 'Upload Photo'}</span>
                    <input type="file" accept="image/*" style="display:none;" onchange="uploadTestimonialAvatar(this, ${idx})" />
                  </label>
                  ${it.author_avatar ? `<button type="button" class="cms-remove-img-btn" style="padding:5px 10px; font-size:11px;" onclick="removeTestimonialAvatar(${idx})">Remove</button>` : ''}
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
          <div class="cms-form-group" style="margin-bottom:0;">
            <label class="cms-label">Answer</label>
            <textarea class="cms-textarea" style="min-height:65px;" placeholder="Detailed answer..."
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

// ── Save Section Handler ─────────────────────────────────────
async function saveDestSec(section) {
    window.cmsSyncEditors?.();
    syncAllRepeaters();

    const destId = <?= $activeId ?>;
    const fields = {};

    document.querySelectorAll(`[data-dest="${destId}"][data-section="${section}"]`).forEach(el => {
        fields[el.dataset.field] = el.value;
    });

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
        } else {
            Toast.error(json.error ?? 'Save failed.');
        }
    } catch (err) {
        Toast.error('Network error during save.');
        console.error(err);
    }
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
