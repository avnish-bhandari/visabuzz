<?php
/**
 * home.php — Comprehensive Home Page Section Editor
 * Full management of all 7 home page sections, text content, and image uploads.
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Home Page Editor';
$pageSlug     = 'home';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit all homepage sections, headings, call-to-actions, and photos';
$cmsRoot      = '../';

// ── Batch fetch existing homepage values from DB in 1 fast query ─────────────
$stmtHome = $pdo->prepare("SELECT section_key, field_key, field_value FROM cms_pages WHERE page_slug = 'home'");
$stmtHome->execute();
$hData = [];
foreach ($stmtHome->fetchAll() as $r) {
    $hData[$r['section_key']][$r['field_key']] = $r['field_value'];
}

function hval(array $data, string $sec, string $fld, string $default = ''): string {
    $val = $data[$sec][$fld] ?? '';
    return ($val !== '') ? $val : $default;
}

function cms_home_img_src(string $url): string {
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

function render_home_image_input(string $label, string $section, string $field, string $currentVal, string $fieldId, string $helpText = 'Upload or replace photo', bool $isAvatar = false) {
    $previewSrc = cms_home_img_src($currentVal);
    $hasImg = !empty($currentVal);
    ?>
    <div class="cms-form-group">
      <label class="cms-label"><?= htmlspecialchars($label) ?></label>
      <div class="cms-image-upload-wrap">
        <div class="cms-image-preview-box <?= $isAvatar ? 'is-avatar' : '' ?>" id="box_<?= $fieldId ?>">
          <img id="prev_<?= $fieldId ?>" src="<?= htmlspecialchars($previewSrc) ?>" alt="Preview" class="cms-preview-img <?= $hasImg ? 'is-visible' : 'is-hidden' ?>" />
          <div class="cms-upload-empty <?= !$hasImg ? 'is-visible' : 'is-hidden' ?>">No Image</div>
        </div>
        <div class="cms-upload-content" style="flex:1;">
          <div class="cms-upload-actions">
            <label class="cms-upload-btn">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span><?= $hasImg ? 'Change Image' : 'Upload Image' ?></span>
              <input type="file" accept="image/*" class="cms-file-input-hidden" onchange="cmsUploadFile(this, 'hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')" />
            </label>
            <button type="button" class="cms-remove-img-btn" onclick="cmsRemoveImage('hid_<?= $fieldId ?>', 'prev_<?= $fieldId ?>')">Remove</button>
          </div>
          <div class="cms-upload-help"><?= htmlspecialchars($helpText) ?> (JPG, PNG, WebP, SVG)</div>
          <div style="margin-top:8px;">
            <input type="text" class="cms-input" style="font-size:12px;padding:6px 10px;height:auto;"
                   placeholder="Or paste external image URL..."
                   value="<?= htmlspecialchars($currentVal) ?>"
                   oninput="document.getElementById('hid_<?= $fieldId ?>').value=this.value; document.getElementById('prev_<?= $fieldId ?>').src=this.value; document.getElementById('prev_<?= $fieldId ?>').classList.toggle('is-visible', !!this.value); document.getElementById('prev_<?= $fieldId ?>').classList.toggle('is-hidden', !this.value); document.querySelector('#box_<?= $fieldId ?> .cms-upload-empty').classList.toggle('is-visible', !this.value); document.querySelector('#box_<?= $fieldId ?> .cms-upload-empty').classList.toggle('is-hidden', !!this.value);" />
          </div>
        </div>
        <input type="hidden" id="hid_<?= $fieldId ?>" class="cms-input" data-section="<?= $section ?>" data-field="<?= $field ?>" value="<?= htmlspecialchars($currentVal) ?>" />
      </div>
    </div>
    <?php
}

// 1. Hero Section Fields
$hero = [
    'eyebrow'      => hval($hData, 'hero', 'eyebrow',      'Global Study, Work & Travel Visa Experts'),
    'title_1'      => hval($hData, 'hero', 'title_1',      'Study, Work &'),
    'title_2'      => hval($hData, 'hero', 'title_2',      'Settle Abroad'),
    'desc'         => hval($hData, 'hero', 'desc',         'Expert visa guidance for Canada, UK, Germany & top global destinations. We simplify your journey with honest advice and end-to-end support.'),
    'cta_label'    => hval($hData, 'hero', 'cta_label',    'Book Free Consultation'),
    'cta_url'      => hval($hData, 'hero', 'cta_url',      '#book'),
    'bg_image'     => hval($hData, 'hero', 'bg_image',     'https://framerusercontent.com/images/EPY1zXPyU45eKC6tijgaxFyb8.jpg'),
    'pill1_label'  => hval($hData, 'hero', 'pill1_label',  'Student Visa'),
    'pill2_label'  => hval($hData, 'hero', 'pill2_label',  'Work Visa'),
    'pill3_label'  => hval($hData, 'hero', 'pill3_label',  'Canada PR'),
];

// 2. Visa Services & Pathways (Tabs Showcase) Header Fields
$tabsHeader = [
    'title'          => hval($hData, 'tabs_header', 'title',          'Comprehensive Visa Services & Pathways'),
    'pill_study'     => hval($hData, 'tabs_header', 'pill_study',     'Study Global'),
    'pill_offerings' => hval($hData, 'tabs_header', 'pill_offerings', 'Offerings'),
    'pill_platform'  => hval($hData, 'tabs_header', 'pill_platform',  'Platform'),
    'pill_resources' => hval($hData, 'tabs_header', 'pill_resources', 'Resources'),
];

// 3. Top Global Destinations (3D Showcase) Fields
require_once dirname(__DIR__) . '/includes/destinations_showcase_config.php';
$destShowcaseCfg = cms_get_destinations_showcase_config($hData);
$destShowcaseHeader = [
    'eyebrow'          => hval($hData, 'dest_showcase_header', 'eyebrow',          $destShowcaseCfg['header']['eyebrow']),
    'title'            => hval($hData, 'dest_showcase_header', 'title',            $destShowcaseCfg['header']['default_title']),
    'active_countries' => hval($hData, 'dest_showcase_header', 'active_countries', $destShowcaseCfg['header']['active_countries']),
];
$destShowcaseCards = [];
foreach ($destShowcaseCfg['cards'] as $k => $c) {
    $sec = $c['sec_key'];
    $destShowcaseCards[$k] = [
        'country_name'     => hval($hData, $sec, 'country_name',     $c['country_name']),
        'title'            => hval($hData, $sec, 'title',            $c['title']),
        'desc'             => hval($hData, $sec, 'desc',             $c['desc']),
        'cta_url'          => hval($hData, $sec, 'cta_url',          $c['cta_url']),
        'cta_aria'         => hval($hData, $sec, 'cta_aria',         $c['cta_aria']),
        'bg_image'         => hval($hData, $sec, 'bg_image',         $c['bg_image']),
        'bg_alt'           => hval($hData, $sec, 'bg_alt',           $c['bg_alt']),
        'card_image'       => hval($hData, $sec, 'card_image',       $c['card_image']),
        'card_alt'         => hval($hData, $sec, 'card_alt',         $c['card_alt']),
        'mini_left_img'    => hval($hData, $sec, 'mini_left_img',    $c['mini_left_img']),
        'mini_left_alt'    => hval($hData, $sec, 'mini_left_alt',    $c['mini_left_alt']),
        'mini_center_img'  => hval($hData, $sec, 'mini_center_img',  $c['mini_center_img']),
        'mini_center_alt'  => hval($hData, $sec, 'mini_center_alt',  $c['mini_center_alt']),
        'mini_right_img'   => hval($hData, $sec, 'mini_right_img',   $c['mini_right_img']),
        'mini_right_alt'   => hval($hData, $sec, 'mini_right_alt',   $c['mini_right_alt']),
    ];
}

// 3. About / Who We Are Fields
$about = [
    'eyebrow'      => hval($hData, 'about', 'eyebrow',      'Who We Are'),
    'title'        => hval($hData, 'about', 'title',        'Study, Work & Settle Abroad — Made Simple'),
    'paragraph'    => hval($hData, 'about', 'paragraph',    'At Visabuz, we believe borders should never limit ambition. We are a trusted overseas education and immigration consultancy, helping individuals and families access global opportunities through expert guidance in student, work, tourist, and permanent residency visas.'),
    'cta_label'    => hval($hData, 'about', 'cta_label',    'Request Consultation'),
    'cta_url'      => hval($hData, 'about', 'cta_url',      '#book'),
    'img_main'     => hval($hData, 'about', 'img_main',     'https://framerusercontent.com/images/Hd1GsarYYENnlRSrEEn0UjS4mY.jpg'),
    'avatar_1'     => hval($hData, 'about', 'avatar_1',     'https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg'),
    'avatar_2'     => hval($hData, 'about', 'avatar_2',     'https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg'),
    'avatar_3'     => hval($hData, 'about', 'avatar_3',     'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80'),
    'review_count' => hval($hData, 'about', 'review_count', '176+'),
    'rating'       => hval($hData, 'about', 'rating',       '4.9/5'),
    'rating_text'  => hval($hData, 'about', 'rating_text',  'Trusted by 176+ Students'),
    'stat1_label'  => hval($hData, 'about', 'stat1_label',  'Success Rate'),
    'stat1_value'  => hval($hData, 'about', 'stat1_value',  '98% visa approval'),
    'stat2_label'  => hval($hData, 'about', 'stat2_label',  'Students Guided'),
    'stat2_value'  => hval($hData, 'about', 'stat2_value',  '176+ placed'),
    'stat3_label'  => hval($hData, 'about', 'stat3_label',  'Global Destinations'),
    'stat3_value'  => hval($hData, 'about', 'stat3_value',  '10+ countries'),
];

// 3. Story Card Fields
$story = [
    'title'       => hval($hData, 'story', 'title',       'Every journey, a new future'),
    'desc'        => hval($hData, 'story', 'desc',        'From university shortlisting to visa approval — we guide every single step.'),
    'img_work'    => hval($hData, 'story', 'img_work',    'https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg'),
    'img_student' => hval($hData, 'story', 'img_student', 'https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg'),
    'img_pr'      => hval($hData, 'story', 'img_pr',      'https://framerusercontent.com/images/Y3vLgrwPWPDMhYwwMsixVo50B24.png'),
];

// 4. How It Works Fields
$process = [
    'eyebrow'      => hval($hData, 'process', 'eyebrow',      'Transparent Process'),
    'title'        => hval($hData, 'process', 'title',        "From consultation\nto touchdown"),
    'desc'         => hval($hData, 'process', 'desc',         'We take care of everything so you don\'t have to worry — clear profile evaluation, flawless documentation, and end-to-end support at every step.'),
    'cta_label'    => hval($hData, 'process', 'cta_label',    'Start Your Journey'),
    'cta_url'      => hval($hData, 'process', 'cta_url',      '#book'),
    'step1_num'    => hval($hData, 'process', 'step1_num',    '01'),
    'step1_title'  => hval($hData, 'process', 'step1_title',  'Free Profile Evaluation'),
    'step1_text'   => hval($hData, 'process', 'step1_text',   'Connect with our certified visa advisors. We assess your academic history, work experience, and goals to identify the highest-probability visa and destination.'),
    'step2_num'    => hval($hData, 'process', 'step2_num',    '02'),
    'step2_title'  => hval($hData, 'process', 'step2_title',  'University Shortlisting & SOP'),
    'step2_text'   => hval($hData, 'process', 'step2_text',   'We select top-tier accredited institutions or work pathways, craft persuasive Statements of Purpose, and vet all financial records to embassy standards.'),
    'step3_num'    => hval($hData, 'process', 'step3_num',    '03'),
    'step3_title'  => hval($hData, 'process', 'step3_title',  'Visa Filing & Interview Prep'),
    'step3_text'   => hval($hData, 'process', 'step3_text',   'We handle biometrics appointments, official embassy filing, and conduct intensive mock visa interview simulations with experienced specialists.'),
    'step4_num'    => hval($hData, 'process', 'step4_num',    '04'),
    'step4_title'  => hval($hData, 'process', 'step4_title',  'Pre-Departure & Housing Support'),
    'step4_text'   => hval($hData, 'process', 'step4_text',   'From securing safe dormitories and budget-friendly student housing to foreign exchange briefings, we support you all the way to touchdown.'),
];

// 5. Why Choose Us / Features Bento Fields
$features = [
    'eyebrow'       => hval($hData, 'features', 'eyebrow',       'Why Choose Visabuz'),
    'title'         => hval($hData, 'features', 'title',         "What makes our\nguidance different"),
    'intro'         => hval($hData, 'features', 'intro',         'At Visabuz, we provide complete end-to-end overseas consultancy to make your international journey smooth, transparent, and successful.'),
    'card1_title'   => hval($hData, 'features', 'card1_title',   'Certified Advisors'),
    'card1_desc'    => hval($hData, 'features', 'card1_desc',    'Decades of combined expertise with high visa approval records'),
    'card2_title'   => hval($hData, 'features', 'card2_title',   'SOP Excellence'),
    'card2_desc'    => hval($hData, 'features', 'card2_desc',    'Tailored Statements of Purpose audited by admission specialists'),
    'card3_stat'    => hval($hData, 'features', 'card3_stat',    '98%'),
    'card3_caption' => hval($hData, 'features', 'card3_caption', 'Visa success rate across global destinations'),
    'card3_img'     => hval($hData, 'features', 'card3_img',     'https://framerusercontent.com/images/4vkwvuoJGYWFzk0yFRIeDpQ.jpg'),
    'card4_title'   => hval($hData, 'features', 'card4_title',   'End-to-End Support'),
    'card4_caption' => hval($hData, 'features', 'card4_caption', 'From university shortlisting to landing abroad'),
    'card4_img'     => hval($hData, 'features', 'card4_img',     'https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg'),
    'card5_title'   => hval($hData, 'features', 'card5_title',   'Housing Support'),
    'card5_desc'    => hval($hData, 'features', 'card5_desc',    'Dormitories, shared flats and student stays arranged before arrival'),
    'card6_title'   => hval($hData, 'features', 'card6_title',   '100% Ethical'),
    'card6_desc'    => hval($hData, 'features', 'card6_desc',    'Transparent fees, honest guidance, and verified legal compliance'),
];

// 6. Client Success / Gallery Ribbon Fields
$gallery = [
    'eyebrow'     => hval($hData, 'gallery', 'eyebrow',     'Client Success'),
    'title'       => hval($hData, 'gallery', 'title',       'What Our Clients Say About Us'),
    'subtitle'    => hval($hData, 'gallery', 'subtitle',    "Hear directly from students and professionals who trusted Visabuz\nwith their journey — and succeeded abroad."),
    'handle_text' => hval($hData, 'gallery', 'handle_text', '@visabuz'),
    'handle_url'  => hval($hData, 'gallery', 'handle_url',  'https://instagram.com'),
    'photo_1'     => hval($hData, 'gallery', 'photo_1',     'https://framerusercontent.com/images/0EzEy3OQx8MdWIBwxaY8xAHeEA.jpg'),
    'photo_2'     => hval($hData, 'gallery', 'photo_2',     'https://framerusercontent.com/images/xdXxNRNsWozlqTO7u2IebKJfM.jpg'),
    'photo_3'     => hval($hData, 'gallery', 'photo_3',     'https://framerusercontent.com/images/C8anRpEXq9pDnOX51SU8QVo8EA.jpg'),
    'photo_4'     => hval($hData, 'gallery', 'photo_4',     'https://framerusercontent.com/images/Vfc5WjxRD9AZsH4sRo4UmhEFU.jpg'),
    'photo_5'     => hval($hData, 'gallery', 'photo_5',     'https://framerusercontent.com/images/E4HlMJufpQTZjFJAxPu72tZKGBA.jpg'),
    'photo_6'     => hval($hData, 'gallery', 'photo_6',     'https://framerusercontent.com/images/xZlo6AmfY1KuB9flDiLBcriVFbw.jpg'),
    'photo_7'     => hval($hData, 'gallery', 'photo_7',     'https://framerusercontent.com/images/tSFQAHhnJk5PL3nDBPgh3kc0jg.jpg'),
];

// 7. Call To Action (CTA) Fields
$cta = [
    'title'         => hval($hData, 'cta', 'title',         "Turn Your Global\nDreams Into Reality"),
    'subtitle'      => hval($hData, 'cta', 'subtitle',      'From profile evaluation to visa stamping, our immigration experts guide you at every single step.'),
    'cta_label'     => hval($hData, 'cta', 'cta_label',     'Book a Free Consultation'),
    'cta_url'       => hval($hData, 'cta', 'cta_url',       '#hero'),
    'bg_image'      => hval($hData, 'cta', 'bg_image',      'https://framerusercontent.com/images/4vkwvuoJGYWFzk0yFRIeDpQ.jpg'),
    'marquee_items' => hval($hData, 'cta', 'marquee_items', 'Student Visas • Work Permits • Canada PR • Express Entry • University Shortlisting • SOP Guidance • 98% Success Rate • Pre-Departure Support'),
];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- Home Page Editor Header & Section Tabs Bar -->
<div class="dest-header-card">
  <!-- Header Top -->
  <div class="dest-header-bar">
    <div class="dest-header-title">
      <span class="dest-header-flag">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#193822" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </span>
      <div class="dest-header-text">
        <span class="dest-header-kicker">Home Page Content Management</span>
        <div class="dest-header-heading">
          <strong>Home Page Sections</strong>
          <span class="cms-badge cms-badge-accent">page_slug=home</span>
          <span class="dest-section-count">9 Sections</span>
        </div>
      </div>
    </div>
    <div class="dest-header-actions">
      <a href="../../index.php" target="_blank" class="cms-btn cms-btn-secondary dest-preview-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        <span>Preview Live Home Page</span>
      </a>
    </div>
  </div>

  <!-- Navigation Underline Tabs with Left/Right Scroll Controls -->
  <div class="dest-tabs-bar-outer">
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-prev" id="homeTabsPrev" onclick="cmsScrollTabs('homeTabsWrap', -1)" aria-label="Scroll tabs left" title="Scroll left">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <div class="dest-tabs-wrap" id="homeTabsWrap">
      <ul class="dest-nav-tabs" role="tablist">
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn active" data-sec="hero" onclick="switchHomeTab('hero', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="dest-tab-label">1. Hero Section</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="services" onclick="switchHomeTab('services', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span class="dest-tab-label">2. Visa Services & Pathways</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="dest_showcase" onclick="switchHomeTab('dest_showcase', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
            <span class="dest-tab-label">3. Global Destinations 3D</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="about" onclick="switchHomeTab('about', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span class="dest-tab-label">4. About / Who We Are</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="story" onclick="switchHomeTab('story', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
            <span class="dest-tab-label">5. Story Card</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="process" onclick="switchHomeTab('process', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span class="dest-tab-label">6. How It Works</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="features" onclick="switchHomeTab('features', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span class="dest-tab-label">7. Why Choose Us</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="gallery" onclick="switchHomeTab('gallery', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span class="dest-tab-label">8. Client Success Ribbon</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="cta" onclick="switchHomeTab('cta', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            <span class="dest-tab-label">9. Final CTA Banner</span>
          </button>
        </li>
        <li class="dest-tab-item dest-tab-item-all">
          <button type="button" class="dest-tab-btn dest-tab-btn-all" data-sec="all" onclick="switchHomeTab('all', this)" title="Show all sections together">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            <span class="dest-tab-label">All Sections</span>
          </button>
        </li>
      </ul>
    </div>
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-next" id="homeTabsNext" onclick="cmsScrollTabs('homeTabsWrap', 1)" aria-label="Scroll tabs right" title="Scroll right">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     1. HERO SECTION
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-hero">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        1. Hero Section
      </div>
      <div class="cms-card-subtitle">Main landing banner — eyebrow text, title, CTA button, and background visual</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('hero', this)">Save Hero</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="hero_eyebrow">Eyebrow Text</label>
    <input type="text" id="hero_eyebrow" class="cms-input" value="<?= htmlspecialchars($hero['eyebrow']) ?>"
           data-section="hero" data-field="eyebrow" data-maxlength="80" />
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="hero_title_1">H1 Heading (Line 1)</label>
      <input type="text" id="hero_title_1" class="cms-input" value="<?= htmlspecialchars($hero['title_1']) ?>"
             data-section="hero" data-field="title_1" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="hero_title_2">H1 Heading (Line 2)</label>
      <input type="text" id="hero_title_2" class="cms-input" value="<?= htmlspecialchars($hero['title_2']) ?>"
             data-section="hero" data-field="title_2" />
    </div>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="hero_desc">Hero Subtitle / Description</label>
    <textarea id="hero_desc" class="cms-textarea" style="min-height:75px;" data-section="hero" data-field="desc"><?= htmlspecialchars($hero['desc']) ?></textarea>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="hero_cta_label">CTA Button Label</label>
      <input type="text" id="hero_cta_label" class="cms-input" value="<?= htmlspecialchars($hero['cta_label']) ?>"
             data-section="hero" data-field="cta_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="hero_cta_url">CTA Button URL</label>
      <input type="text" id="hero_cta_url" class="cms-input" value="<?= htmlspecialchars($hero['cta_url']) ?>"
             data-section="hero" data-field="cta_url" />
    </div>
  </div>

  <div class="cms-section-divider">Category Filter Pills</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Filter Pill 1 Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($hero['pill1_label']) ?>"
             data-section="hero" data-field="pill1_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Filter Pill 2 Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($hero['pill2_label']) ?>"
             data-section="hero" data-field="pill2_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Filter Pill 3 Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($hero['pill3_label']) ?>"
             data-section="hero" data-field="pill3_label" />
    </div>
  </div>

  <div class="cms-section-divider">Hero Section Background Visual</div>
  <?php render_home_image_input('Hero Background Visual Image', 'hero', 'bg_image', $hero['bg_image'], 'hero_bg', 'Full-width cinematic background photograph for the landing hero banner'); ?>
</div>

<!-- ═══════════════════════════════════════════════════════════
     2. VISA SERVICES & PATHWAYS TABS (#feature-tabs)
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-services">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        2. Visa Services & Pathways Showcase
      </div>
      <div class="cms-card-subtitle">Interactive 4-category tabs section on the homepage (#feature-tabs) — 4 categories, 25 pathways, bullet highlights, and photos</div>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
      <a href="services.php" class="cms-btn cms-btn-secondary" style="display:inline-flex;align-items:center;gap:6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        <span>Open Full 25-Tab Editor</span>
      </a>
      <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('tabs_header', this)">Save Header & Pills</button>
    </div>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="tabs_header_title">Main Section Heading (H2)</label>
    <input type="text" id="tabs_header_title" class="cms-input" value="<?= htmlspecialchars($tabsHeader['title']) ?>"
           data-section="tabs_header" data-field="title" />
  </div>

  <div class="cms-section-divider">Top Category Filter Pill Labels</div>
  <div class="cms-input-row" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;">
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">Category 1 Pill Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($tabsHeader['pill_study']) ?>"
             data-section="tabs_header" data-field="pill_study" />
    </div>
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">Category 2 Pill Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($tabsHeader['pill_offerings']) ?>"
             data-section="tabs_header" data-field="pill_offerings" />
    </div>
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">Category 3 Pill Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($tabsHeader['pill_platform']) ?>"
             data-section="tabs_header" data-field="pill_platform" />
    </div>
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">Category 4 Pill Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($tabsHeader['pill_resources']) ?>"
             data-section="tabs_header" data-field="pill_resources" />
    </div>
  </div>

  <div class="cms-section-divider">25 Feature Pathways Overview & Direct Editors</div>
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:14px;margin-top:12px;">
    <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px 16px;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <strong style="font-size:13.5px;color:var(--text-primary);">1. Study Global</strong>
        <span class="cms-badge cms-badge-green">9 Countries</span>
      </div>
      <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;line-height:1.5;">UK, USA, Ireland, Canada, Germany, Dubai, France, Europe, Italy</p>
      <a href="services.php#cat-study" class="cms-btn cms-btn-secondary" style="font-size:11.5px;padding:4px 10px;width:100%;justify-content:center;">Edit 9 Countries &rarr;</a>
    </div>
    <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px 16px;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <strong style="font-size:13.5px;color:var(--text-primary);">2. Offerings</strong>
        <span class="cms-badge cms-badge-green">4 Pathways</span>
      </div>
      <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;line-height:1.5;">Study Global, Work Global, Learn Online, Study Local</p>
      <a href="services.php#cat-offerings" class="cms-btn cms-btn-secondary" style="font-size:11.5px;padding:4px 10px;width:100%;justify-content:center;">Edit 4 Offerings &rarr;</a>
    </div>
    <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px 16px;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <strong style="font-size:13.5px;color:var(--text-primary);">3. Platform</strong>
        <span class="cms-badge cms-badge-green">4 Services</span>
      </div>
      <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;line-height:1.5;">Financial Services, Housing, Visa Services, Career Support</p>
      <a href="services.php#cat-platform" class="cms-btn cms-btn-secondary" style="font-size:11.5px;padding:4px 10px;width:100%;justify-content:center;">Edit 4 Services &rarr;</a>
    </div>
    <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px 16px;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <strong style="font-size:13.5px;color:var(--text-primary);">4. Resources</strong>
        <span class="cms-badge cms-badge-green">8 Guides</span>
      </div>
      <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;line-height:1.5;">LOR, SOP, IELTS, GMAT, GRE, SAT, TOEFL, PTE</p>
      <a href="services.php#cat-resources" class="cms-btn cms-btn-secondary" style="font-size:11.5px;padding:4px 10px;width:100%;justify-content:center;">Edit 8 Resources &rarr;</a>
    </div>
  </div>

  <div style="margin-top:16px;padding:12px 16px;background:#eef8f1;border:1px solid #c7ebd0;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <div style="font-size:12.5px;color:#193822;">
      <strong>Looking to update bullet highlights, buttons, and photos?</strong> All 25 individual destination and pathway tabs are fully customizable in the dedicated <strong>Visa Services & Pathways Editor</strong>.
    </div>
    <a href="services.php" class="cms-btn cms-btn-primary" style="white-space:nowrap;font-size:12px;padding:6px 14px;">Open Full Editor</a>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     3. TOP GLOBAL DESTINATIONS (3D SHOWCASE) (#destinationsTrack)
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-dest_showcase">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
        3. Top Global Destinations (3D Flip &amp; Scroll Showcase)
      </div>
      <div class="cms-card-subtitle">Interactive 3D rotating stage on homepage (#destinations) &bull; <?= count($destShowcaseCfg['cards']) ?> active countries in 3D flip scroll &bull; Add, remove, and reorder countries freely</div>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
      <a href="../../index.php#destinations" target="_blank" class="cms-btn cms-btn-secondary dest-preview-btn" style="display:inline-flex;align-items:center;gap:6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        <span>Preview 3D Stage</span>
      </a>
      <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('dest_showcase_header', this)">Save Header</button>
    </div>
  </div>

  <input type="hidden" id="dest_showcase_active_countries" data-section="dest_showcase_header" data-field="active_countries" value="<?= htmlspecialchars($destShowcaseHeader['active_countries']) ?>" />

  <div class="cms-form-group">
    <label class="cms-label" for="dest_showcase_eyebrow">Eyebrow Badge Text</label>
    <input type="text" id="dest_showcase_eyebrow" class="cms-input" value="<?= htmlspecialchars($destShowcaseHeader['eyebrow']) ?>"
           data-section="dest_showcase_header" data-field="eyebrow" placeholder="Top Global Destinations" />
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="dest_showcase_title">Main Section Heading (H2)</label>
    <textarea id="dest_showcase_title" class="cms-textarea" style="min-height:65px;" data-section="dest_showcase_header" data-field="title"><?= htmlspecialchars($destShowcaseHeader['title']) ?></textarea>
    <div style="font-size:11.5px;color:var(--text-muted);margin-top:4px;">Use a line break to separate the first line (e.g. &ldquo;Explore The World&rsquo;s Leading&rdquo;) and second line (e.g. &ldquo;Study &amp; Visa Hubs&rdquo;).</div>
  </div>

  <?php 
  $cardCount = count($destShowcaseCfg['cards']);
  $activeCardKeys = array_keys($destShowcaseCfg['cards']);
  ?>
  <div class="cms-section-divider">Featured Destination Cards &amp; 3D Stage Order (<?= $cardCount ?> Active Countries)</div>

  <!-- Country Pills Bar & Add Country Trigger -->
  <div class="showcase-pills-bar">
    <?php 
    $firstCard = true;
    foreach ($destShowcaseCfg['cards'] as $k => $c): 
        $flag = cms_dest_flag_svg($c['flag_code'], 18, 12);
        $cardTitle = $destShowcaseCards[$k]['title'] ?: $c['title'];
    ?>
    <button type="button" class="showcase-country-pill<?= $firstCard ? ' active' : '' ?>" data-card="<?= $k ?>" onclick="switchDestShowcaseCard('<?= $k ?>', this)">
      <?= $flag ?>
      <span><?= htmlspecialchars($c['country_name']) ?></span>
      <span class="country-code-tag"><?= strtoupper(htmlspecialchars($c['flag_code'] ?: substr($k, 0, 2))) ?></span>
    </button>
    <?php 
        $firstCard = false;
    endforeach; 
    ?>
    <button type="button" class="showcase-add-pill-btn" onclick="openAddCountryModal()" title="Add another destination country to homepage 3D scroll">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      <span>+ Add Country</span>
    </button>
  </div>

  <!-- Destination Country Panels -->
  <?php 
  $firstPane = true;
  $cardIndex = 0;
  foreach ($destShowcaseCfg['cards'] as $k => $c): 
      $secKey = $c['sec_key'];
      $cardData = $destShowcaseCards[$k];
      $flag = cms_dest_flag_svg($c['flag_code'], 22, 15);
      $isFirst = ($cardIndex === 0);
      $isLast  = ($cardIndex === $cardCount - 1);
  ?>
  <div class="dest-showcase-pane" id="dest-pane-<?= $k ?>" style="display:<?= $firstPane ? 'block' : 'none' ?>;">
    <div style="background:#f8fafc;border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:20px;margin-bottom:16px;">
      
      <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid var(--border-muted);">
        <div style="display:flex;align-items:center;gap:10px;">
          <?= $flag ?>
          <div>
            <h3 style="font-size:16px;font-weight:700;color:var(--text-primary);margin:0;"><?= htmlspecialchars($c['country_name']) ?> &mdash; Card <?= $cardIndex + 1 ?> of <?= $cardCount ?> in 3D Scroll</h3>
            <span style="font-size:12px;color:var(--text-muted);">Section Key: <code><?= $secKey ?></code> &bull; Card Stage ID: <code><?= $c['card_id'] ?></code></span>
          </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
          <button type="button" class="cms-btn cms-btn-secondary" onclick="moveShowcaseCountry('<?= $k ?>', -1)" <?= $isFirst ? 'disabled style="opacity:0.4;cursor:not-allowed;"' : '' ?> title="Move this country earlier in the 3D scroll order">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            <span>Move Left</span>
          </button>
          <button type="button" class="cms-btn cms-btn-secondary" onclick="moveShowcaseCountry('<?= $k ?>', 1)" <?= $isLast ? 'disabled style="opacity:0.4;cursor:not-allowed;"' : '' ?> title="Move this country later in the 3D scroll order">
            <span>Move Right</span>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
          <button type="button" class="cms-btn cms-btn-danger" onclick="removeShowcaseCountry('<?= $k ?>', '<?= htmlspecialchars(addslashes($c['country_name'])) ?>')" title="Remove this country from the homepage 3D scroll">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            <span>Remove</span>
          </button>
          <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('<?= $secKey ?>', this)" style="padding:7px 18px;">
            Save <?= htmlspecialchars($c['country_name']) ?> Card
          </button>
        </div>
      </div>

      <!-- Country Name and Card Title -->
      <div class="cms-input-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="cms-form-group">
          <label class="cms-label">Country / Marquee Name (Used for Ticker &amp; Tracking)</label>
          <input type="text" class="cms-input" value="<?= htmlspecialchars($cardData['country_name']) ?>"
                 data-section="<?= $secKey ?>" data-field="country_name" placeholder="<?= htmlspecialchars($c['country_name']) ?>" />
        </div>
        <div class="cms-form-group">
          <label class="cms-label">3D Card Display Title (With Flag Emoji)</label>
          <input type="text" class="cms-input" value="<?= htmlspecialchars($cardData['title']) ?>"
                 data-section="<?= $secKey ?>" data-field="title" placeholder="<?= htmlspecialchars($c['title']) ?>" />
        </div>
      </div>

      <!-- Description -->
      <div class="cms-form-group">
        <label class="cms-label">Card Subtitle / Description</label>
        <textarea class="cms-textarea" style="min-height:60px;" data-section="<?= $secKey ?>" data-field="desc" placeholder="<?= htmlspecialchars($c['desc']) ?>"><?= htmlspecialchars($cardData['desc']) ?></textarea>
      </div>

      <!-- CTA URL & Aria Label -->
      <div class="cms-input-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="cms-form-group">
          <label class="cms-label">Card Arrow Button Link URL</label>
          <input type="text" class="cms-input" value="<?= htmlspecialchars($cardData['cta_url']) ?>"
                 data-section="<?= $secKey ?>" data-field="cta_url" placeholder="#book or destination URL" />
        </div>
        <div class="cms-form-group">
          <label class="cms-label">Button Accessible Label (Aria-label)</label>
          <input type="text" class="cms-input" value="<?= htmlspecialchars($cardData['cta_aria']) ?>"
                 data-section="<?= $secKey ?>" data-field="cta_aria" placeholder="<?= htmlspecialchars($c['cta_aria']) ?>" />
        </div>
      </div>

      <!-- Visual Assets: Background & Center Card -->
      <div class="cms-section-divider" style="margin-top:10px;">Primary Visuals (Fullscreen Background &amp; Center 3D Card)</div>
      <div class="cms-input-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
        <div style="background:#ffffff;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px;">
          <?php render_home_image_input('1. Fullscreen Background Image', $secKey, 'bg_image', $cardData['bg_image'], 'dest_' . $k . '_bg', 'Cinematic cross-fading background (1920x1080 recommended)'); ?>
          <div class="cms-form-group" style="margin-top:8px;margin-bottom:0;">
            <label class="cms-label" style="font-size:11.5px;">Background Image Alt Text</label>
            <input type="text" class="cms-input" style="font-size:12px;padding:6px 10px;" value="<?= htmlspecialchars($cardData['bg_alt']) ?>"
                   data-section="<?= $secKey ?>" data-field="bg_alt" placeholder="<?= htmlspecialchars($c['bg_alt']) ?>" />
          </div>
        </div>

        <div style="background:#ffffff;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px;">
          <?php render_home_image_input('2. Center 3D Card Image', $secKey, 'card_image', $cardData['card_image'], 'dest_' . $k . '_card', 'Main focal photo shown on the 3D card (800x600 recommended)'); ?>
          <div class="cms-form-group" style="margin-top:8px;margin-bottom:0;">
            <label class="cms-label" style="font-size:11.5px;">Card Image Alt Text</label>
            <input type="text" class="cms-input" style="font-size:12px;padding:6px 10px;" value="<?= htmlspecialchars($cardData['card_alt']) ?>"
                   data-section="<?= $secKey ?>" data-field="card_alt" placeholder="<?= htmlspecialchars($c['card_alt']) ?>" />
          </div>
        </div>
      </div>

      <!-- Hover Mini Preview Images -->
      <div class="cms-section-divider" style="margin-top:16px;">Hover Mini Preview Photos (Animated on Mouseover)</div>
      <div class="cms-input-row" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;">
        <!-- Left Mini -->
        <div style="background:#ffffff;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:12px;">
          <?php render_home_image_input('Mini Preview (Left)', $secKey, 'mini_left_img', $cardData['mini_left_img'], 'dest_' . $k . '_mini_l', 'Left fan photo (300x300)'); ?>
          <div class="cms-form-group" style="margin-top:8px;margin-bottom:0;">
            <label class="cms-label" style="font-size:11px;">Alt Text / Caption</label>
            <input type="text" class="cms-input" style="font-size:11.5px;padding:5px 8px;" value="<?= htmlspecialchars($cardData['mini_left_alt']) ?>"
                   data-section="<?= $secKey ?>" data-field="mini_left_alt" placeholder="<?= htmlspecialchars($c['mini_left_alt']) ?>" />
          </div>
        </div>

        <!-- Center Mini -->
        <div style="background:#ffffff;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:12px;">
          <?php render_home_image_input('Mini Preview (Center)', $secKey, 'mini_center_img', $cardData['mini_center_img'], 'dest_' . $k . '_mini_c', 'Center fan photo (300x300)'); ?>
          <div class="cms-form-group" style="margin-top:8px;margin-bottom:0;">
            <label class="cms-label" style="font-size:11px;">Alt Text / Caption</label>
            <input type="text" class="cms-input" style="font-size:11.5px;padding:5px 8px;" value="<?= htmlspecialchars($cardData['mini_center_alt']) ?>"
                   data-section="<?= $secKey ?>" data-field="mini_center_alt" placeholder="<?= htmlspecialchars($c['mini_center_alt']) ?>" />
          </div>
        </div>

        <!-- Right Mini -->
        <div style="background:#ffffff;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:12px;">
          <?php render_home_image_input('Mini Preview (Right)', $secKey, 'mini_right_img', $cardData['mini_right_img'], 'dest_' . $k . '_mini_r', 'Right fan photo (300x300)'); ?>
          <div class="cms-form-group" style="margin-top:8px;margin-bottom:0;">
            <label class="cms-label" style="font-size:11px;">Alt Text / Caption</label>
            <input type="text" class="cms-input" style="font-size:11.5px;padding:5px 8px;" value="<?= htmlspecialchars($cardData['mini_right_alt']) ?>"
                   data-section="<?= $secKey ?>" data-field="mini_right_alt" placeholder="<?= htmlspecialchars($c['mini_right_alt']) ?>" />
          </div>
        </div>
      </div>

      <div style="display:flex;justify-content:flex-end;margin-top:16px;padding-top:12px;border-top:1px solid var(--border-muted);">
        <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('<?= $secKey ?>', this)" style="padding:8px 22px;">
          Save <?= htmlspecialchars($c['country_name']) ?> Card
        </button>
      </div>

    </div>
  </div>
  <?php 
      $firstPane = false;
      $cardIndex++;
  endforeach; 
  ?>

  <!-- Add Country Modal -->
  <?php 
  $catalog = cms_get_destinations_catalog();
  $availablePresets = [];
  foreach ($catalog as $pKey => $preset) {
      if (!in_array($pKey, $activeCardKeys, true)) {
          $availablePresets[$pKey] = $preset;
      }
  }
  ?>
  <div class="showcase-modal-backdrop" id="destAddCountryModal" style="display:none;" onclick="if(event.target === this) closeAddCountryModal();">
    <div class="showcase-modal-box">
      <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border-color);">
        <div>
          <h3 style="margin:0;font-size:16px;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Add Destination to Homepage 3D Showcase
          </h3>
          <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Select from ready-to-use popular country presets or create a custom country card.</div>
        </div>
        <button type="button" onclick="closeAddCountryModal()" style="border:none;background:transparent;cursor:pointer;color:var(--text-muted);padding:4px;border-radius:6px;display:flex;align-items:center;justify-content:center;" title="Close modal">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <div style="padding:20px;max-height:calc(85vh - 120px);overflow-y:auto;">
        <div style="font-size:13px;font-weight:700;color:var(--text-primary);margin-bottom:12px;display:flex;align-items:center;gap:6px;">
          <span>Available Country Presets (1-Click Add)</span>
          <span class="cms-badge cms-badge-green"><?= count($availablePresets) ?> Available</span>
        </div>

        <?php if (!empty($availablePresets)): ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));gap:12px;margin-bottom:24px;">
          <?php foreach ($availablePresets as $pKey => $p): 
              $pFlag = cms_dest_flag_svg($p['flag_code'], 22, 15);
          ?>
          <div class="showcase-preset-card">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
              <?= $pFlag ?>
              <strong style="font-size:14px;color:var(--text-primary);"><?= htmlspecialchars($p['country_name']) ?></strong>
              <span class="country-code-tag"><?= strtoupper(htmlspecialchars($p['flag_code'])) ?></span>
            </div>
            <p style="font-size:11.5px;color:var(--text-secondary);line-height:1.4;margin:0 0 10px 0;flex:1;"><?= htmlspecialchars($p['desc']) ?></p>
            <button type="button" class="cms-btn cms-btn-primary" onclick="addShowcaseCountry('<?= $pKey ?>')" style="width:100%;font-size:12px;padding:6px 12px;justify-content:center;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              <span>Add <?= htmlspecialchars($p['country_name']) ?></span>
            </button>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="padding:14px;background:#f8fafc;border:1px dashed var(--border-muted);border-radius:var(--radius-md);text-align:center;font-size:12.5px;color:var(--text-muted);margin-bottom:20px;">
          All catalog preset countries are currently active in your 3D showcase! You can add custom countries below.
        </div>
        <?php endif; ?>

        <!-- Custom Country Option -->
        <div class="cms-section-divider" style="margin-top:0;">Or Add Any Custom Country</div>
        <div style="background:#f8fafc;border:1px solid var(--border-color);border-radius:var(--radius-md);padding:16px;">
          <div class="cms-input-row" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:12px;">
            <div class="cms-form-group" style="margin-bottom:0;">
              <label class="cms-label" for="custom_dest_name">Country Name *</label>
              <input type="text" id="custom_dest_name" class="cms-input" placeholder="e.g. Switzerland, Japan, Netherlands" />
            </div>
            <div class="cms-form-group" style="margin-bottom:0;">
              <label class="cms-label" for="custom_dest_slug">Country Slug / Code *</label>
              <input type="text" id="custom_dest_slug" class="cms-input" placeholder="e.g. switzerland, japan, netherlands" />
            </div>
          </div>
          <div style="display:flex;justify-content:flex-end;">
            <button type="button" class="cms-btn cms-btn-primary" onclick="addCustomShowcaseCountry()" style="font-size:12.5px;padding:7px 18px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              <span>Add Custom Country</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ═══════════════════════════════════════════════════════════
     4. ABOUT / WHO WE ARE
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-about">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        4. About / Who We Are
      </div>
      <div class="cms-card-subtitle">Title, copy, CTA, center portrait photograph, social proof avatars, and statistics</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('about', this)">Save About</button>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="about_eyebrow">Section Eyebrow</label>
      <input type="text" id="about_eyebrow" class="cms-input" value="<?= htmlspecialchars($about['eyebrow']) ?>"
             data-section="about" data-field="eyebrow" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="about_title">Section Title</label>
      <input type="text" id="about_title" class="cms-input" value="<?= htmlspecialchars($about['title']) ?>"
             data-section="about" data-field="title" />
    </div>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="about_paragraph">Main Paragraph Description</label>
    <textarea id="about_paragraph" class="cms-textarea" style="min-height:95px;" data-section="about" data-field="paragraph"><?= htmlspecialchars($about['paragraph']) ?></textarea>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="about_cta_label">CTA Button Label</label>
      <input type="text" id="about_cta_label" class="cms-input" value="<?= htmlspecialchars($about['cta_label']) ?>"
             data-section="about" data-field="cta_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="about_cta_url">CTA Button URL</label>
      <input type="text" id="about_cta_url" class="cms-input" value="<?= htmlspecialchars($about['cta_url']) ?>"
             data-section="about" data-field="cta_url" />
    </div>
  </div>

  <div class="cms-section-divider">Center Portrait Visual Image</div>
  <?php render_home_image_input('Center Column Photo (Consultant / Advisor)', 'about', 'img_main', $about['img_main'], 'about_img_main', 'Vertical portrait photograph displayed in the center column of the About section'); ?>

  <div class="cms-section-divider">Social Proof Avatars &amp; Ratings</div>
  <div class="cms-input-row">
    <?php render_home_image_input('Client Avatar 1', 'about', 'avatar_1', $about['avatar_1'], 'about_av1', 'Round student client avatar 1', true); ?>
    <?php render_home_image_input('Client Avatar 2', 'about', 'avatar_2', $about['avatar_2'], 'about_av2', 'Round student client avatar 2', true); ?>
  </div>
  <div class="cms-input-row">
    <?php render_home_image_input('Client Avatar 3', 'about', 'avatar_3', $about['avatar_3'], 'about_av3', 'Round student client avatar 3', true); ?>
    <div class="cms-form-group">
      <label class="cms-label" for="about_review_count">Avatar Badge Count</label>
      <input type="text" id="about_review_count" class="cms-input" value="<?= htmlspecialchars($about['review_count']) ?>"
             data-section="about" data-field="review_count" placeholder="176+" />
    </div>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="about_rating">Rating Score</label>
      <input type="text" id="about_rating" class="cms-input" value="<?= htmlspecialchars($about['rating']) ?>"
             data-section="about" data-field="rating" placeholder="4.9/5" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="about_rating_text">Rating Caption</label>
      <input type="text" id="about_rating_text" class="cms-input" value="<?= htmlspecialchars($about['rating_text']) ?>"
             data-section="about" data-field="rating_text" placeholder="Trusted by 176+ Students" />
    </div>
  </div>

  <div class="cms-section-divider">Key Highlight Statistics (Right Column)</div>
  <?php foreach ([1,2,3] as $i): ?>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Stat <?= $i ?> Label</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($about["stat{$i}_label"]) ?>"
             data-section="about" data-field="stat<?= $i ?>_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Stat <?= $i ?> Value</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($about["stat{$i}_value"]) ?>"
             data-section="about" data-field="stat<?= $i ?>_value" />
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- ═══════════════════════════════════════════════════════════
     3. STORY CARD
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-story">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
        5. Story Card
      </div>
      <div class="cms-card-subtitle">The "Every journey, a new future" card and 3 interactive fanned deck pathway photos</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('story', this)">Save Story</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="story_title">Card Title</label>
    <input type="text" id="story_title" class="cms-input" value="<?= htmlspecialchars($story['title']) ?>"
           data-section="story" data-field="title" />
  </div>
  <div class="cms-form-group">
    <label class="cms-label" for="story_desc">Card Description</label>
    <textarea id="story_desc" class="cms-textarea" style="min-height:70px"
              data-section="story" data-field="desc"><?= htmlspecialchars($story['desc']) ?></textarea>
  </div>

  <div class="cms-section-divider">Fanned Deck Pathway Photos</div>
  <?php render_home_image_input('Work Visa Pathway Photo (Left Card)', 'story', 'img_work', $story['img_work'], 'story_work', 'Photo shown when Work Visa pathway is selected'); ?>
  <?php render_home_image_input('Student Visa Pathway Photo (Center Card - Default)', 'story', 'img_student', $story['img_student'], 'story_student', 'Photo shown when Student Visa pathway is active'); ?>
  <?php render_home_image_input('Canada PR Pathway Photo (Right Card)', 'story', 'img_pr', $story['img_pr'], 'story_pr', 'Photo shown when Canada PR pathway is selected'); ?>
</div>

<!-- ═══════════════════════════════════════════════════════════
     4. HOW IT WORKS / PROCESS
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-process">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        6. How It Works
      </div>
      <div class="cms-card-subtitle">Transparent Process steps — header copy, CTA, and 4 sequential milestone cards</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('process', this)">Save Process</button>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="process_eyebrow">Section Eyebrow</label>
      <input type="text" id="process_eyebrow" class="cms-input" value="<?= htmlspecialchars($process['eyebrow']) ?>"
             data-section="process" data-field="eyebrow" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="process_title">Section Title</label>
      <input type="text" id="process_title" class="cms-input" value="<?= htmlspecialchars($process['title']) ?>"
             data-section="process" data-field="title" />
    </div>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="process_desc">Process Description</label>
    <textarea id="process_desc" class="cms-textarea" style="min-height:75px;" data-section="process" data-field="desc"><?= htmlspecialchars($process['desc']) ?></textarea>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="process_cta_label">CTA Button Label</label>
      <input type="text" id="process_cta_label" class="cms-input" value="<?= htmlspecialchars($process['cta_label']) ?>"
             data-section="process" data-field="cta_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="process_cta_url">CTA Button URL</label>
      <input type="text" id="process_cta_url" class="cms-input" value="<?= htmlspecialchars($process['cta_url']) ?>"
             data-section="process" data-field="cta_url" />
    </div>
  </div>

  <div class="cms-section-divider">Sequential Process Step Cards (01 to 04)</div>
  <?php for ($step = 1; $step <= 4; $step++): ?>
  <div style="background:#f9fbf9;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px 16px;margin-bottom:14px;">
    <div class="cms-input-row">
      <div class="cms-form-group" style="max-width:120px;">
        <label class="cms-label">Step Number</label>
        <input type="text" class="cms-input" value="<?= htmlspecialchars($process["step{$step}_num"]) ?>"
               data-section="process" data-field="step<?= $step ?>_num" />
      </div>
      <div class="cms-form-group">
        <label class="cms-label">Step <?= $step ?> Title</label>
        <input type="text" class="cms-input" value="<?= htmlspecialchars($process["step{$step}_title"]) ?>"
               data-section="process" data-field="step<?= $step ?>_title" />
      </div>
    </div>
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">Step <?= $step ?> Description</label>
      <textarea class="cms-textarea" style="min-height:65px;" data-section="process" data-field="step<?= $step ?>_text"><?= htmlspecialchars($process["step{$step}_text"]) ?></textarea>
    </div>
  </div>
  <?php endfor; ?>
</div>

<!-- ═══════════════════════════════════════════════════════════
     5. WHY CHOOSE US / FEATURES BENTO
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-features">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        7. Why Choose Us (Bento Grid)
      </div>
      <div class="cms-card-subtitle">Why Choose Visabuz bento grid — 6 differentiator cards and background photos</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('features', this)">Save Bento Features</button>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="feat_eyebrow">Section Eyebrow</label>
      <input type="text" id="feat_eyebrow" class="cms-input" value="<?= htmlspecialchars($features['eyebrow']) ?>"
             data-section="features" data-field="eyebrow" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="feat_title">Section Title</label>
      <input type="text" id="feat_title" class="cms-input" value="<?= htmlspecialchars($features['title']) ?>"
             data-section="features" data-field="title" />
    </div>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="feat_intro">Intro Paragraph</label>
    <textarea id="feat_intro" class="cms-textarea" style="min-height:75px;" data-section="features" data-field="intro"><?= htmlspecialchars($features['intro']) ?></textarea>
  </div>

  <div class="cms-section-divider">Bento Cards (Row 1)</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Card 1 Title (Certified Advisors)</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card1_title']) ?>"
             data-section="features" data-field="card1_title" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card 1 Description</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card1_desc']) ?>"
             data-section="features" data-field="card1_desc" />
    </div>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Card 2 Title (SOP Excellence)</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card2_title']) ?>"
             data-section="features" data-field="card2_title" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card 2 Description</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card2_desc']) ?>"
             data-section="features" data-field="card2_desc" />
    </div>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Card 3 Stat Number (e.g. 98%)</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card3_stat']) ?>"
             data-section="features" data-field="card3_stat" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card 3 Caption</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card3_caption']) ?>"
             data-section="features" data-field="card3_caption" />
    </div>
  </div>
  <?php render_home_image_input('Card 3 Background Photo (Success Rate Card)', 'features', 'card3_img', $features['card3_img'], 'feat_c3', 'Background photo for Card 3 stat box'); ?>

  <div class="cms-section-divider">Bento Cards (Row 2)</div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Card 4 Title (Span-2 Card)</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card4_title']) ?>"
             data-section="features" data-field="card4_title" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card 4 Caption</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card4_caption']) ?>"
             data-section="features" data-field="card4_caption" />
    </div>
  </div>
  <?php render_home_image_input('Card 4 Background Photo (End-to-End Support Card)', 'features', 'card4_img', $features['card4_img'], 'feat_c4', 'Background photo for Card 4 double-span banner'); ?>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Card 5 Title (Housing Support)</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card5_title']) ?>"
             data-section="features" data-field="card5_title" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card 5 Description</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card5_desc']) ?>"
             data-section="features" data-field="card5_desc" />
    </div>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Card 6 Title (100% Ethical)</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card6_title']) ?>"
             data-section="features" data-field="card6_title" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card 6 Description</label>
      <input type="text" class="cms-input" value="<?= htmlspecialchars($features['card6_desc']) ?>"
             data-section="features" data-field="card6_desc" />
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     6. CLIENT SUCCESS RIBBON / POLAROID CAROUSEL
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-gallery">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        8. Client Success Ribbon
      </div>
      <div class="cms-card-subtitle">Tilted Polaroid photo carousel strip — editorial heading, social handle, and 7 photos</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('gallery', this)">Save Ribbon</button>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="gal_eyebrow">Section Eyebrow</label>
      <input type="text" id="gal_eyebrow" class="cms-input" value="<?= htmlspecialchars($gallery['eyebrow']) ?>"
             data-section="gallery" data-field="eyebrow" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="gal_title">Section Title</label>
      <input type="text" id="gal_title" class="cms-input" value="<?= htmlspecialchars($gallery['title']) ?>"
             data-section="gallery" data-field="title" />
    </div>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="gal_subtitle">Section Subtitle</label>
    <textarea id="gal_subtitle" class="cms-textarea" style="min-height:65px;" data-section="gallery" data-field="subtitle"><?= htmlspecialchars($gallery['subtitle']) ?></textarea>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="gal_handle_text">Social Handle Text</label>
      <input type="text" id="gal_handle_text" class="cms-input" value="<?= htmlspecialchars($gallery['handle_text']) ?>"
             data-section="gallery" data-field="handle_text" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="gal_handle_url">Social Handle URL</label>
      <input type="text" id="gal_handle_url" class="cms-input" value="<?= htmlspecialchars($gallery['handle_url']) ?>"
             data-section="gallery" data-field="handle_url" />
    </div>
  </div>

  <div class="cms-section-divider">7 Tilted Polaroid Carousel Photos</div>
  <?php for ($p = 1; $p <= 7; $p++): ?>
    <?php render_home_image_input("Polaroid Photo $p", 'gallery', "photo_$p", $gallery["photo_$p"], "gal_p$p", "Carousel slide photo $p"); ?>
  <?php endfor; ?>
</div>

<!-- ═══════════════════════════════════════════════════════════
     7. FINAL CALL-TO-ACTION (CTA) BANNER
     ═══════════════════════════════════════════════════════════ -->
<div class="cms-card cms-home-section" id="sec-cta">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        9. Final CTA Banner
      </div>
      <div class="cms-card-subtitle">Bottom consultation banner — headline, description, background image, and marquee ticker</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveSection('cta', this)">Save CTA Banner</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="cta_title">Banner Headline</label>
    <textarea id="cta_title" class="cms-textarea" style="min-height:65px;" data-section="cta" data-field="title"><?= htmlspecialchars($cta['title']) ?></textarea>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="cta_subtitle">Banner Subtitle / Description</label>
    <textarea id="cta_subtitle" class="cms-textarea" style="min-height:75px;" data-section="cta" data-field="subtitle"><?= htmlspecialchars($cta['subtitle']) ?></textarea>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="cta_cta_label">Button Label</label>
      <input type="text" id="cta_cta_label" class="cms-input" value="<?= htmlspecialchars($cta['cta_label']) ?>"
             data-section="cta" data-field="cta_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="cta_cta_url">Button URL</label>
      <input type="text" id="cta_cta_url" class="cms-input" value="<?= htmlspecialchars($cta['cta_url']) ?>"
             data-section="cta" data-field="cta_url" />
    </div>
  </div>

  <div class="cms-section-divider">CTA Background Visual Image</div>
  <?php render_home_image_input('CTA Section Background Visual', 'cta', 'bg_image', $cta['bg_image'], 'cta_bg', 'Full-width cinematic background photo for the bottom consultation section'); ?>

  <div class="cms-section-divider">Infinite Auto-Scroll Marquee Ticker</div>
  <div class="cms-form-group">
    <label class="cms-label" for="cta_marquee">Marquee Items</label>
    <textarea id="cta_marquee" class="cms-textarea" style="min-height:70px;" data-section="cta" data-field="marquee_items"><?= htmlspecialchars($cta['marquee_items']) ?></textarea>
    <p style="font-size:11.5px;color:var(--text-muted);margin-top:4px;">Separate ticker items with bullet points (&bull;) or vertical bars (|).</p>
  </div>
</div>

<script>
function cmsScrollTabs(wrapOrId, dir) {
    const wrap = typeof wrapOrId === 'string' ? document.getElementById(wrapOrId) : wrapOrId;
    if (!wrap) return;
    const amount = (dir || 1) * 280;
    wrap.scrollLeft += amount;
}
window.cmsScrollTabs = cmsScrollTabs;

function switchHomeTab(secName, btn) {
    document.querySelectorAll('#homeTabsWrap .dest-tab-btn').forEach(b => b.classList.remove('active'));
    const activeBtn = btn || document.querySelector(`#homeTabsWrap .dest-tab-btn[data-sec="${secName}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
        if (typeof activeBtn.scrollIntoView === 'function') {
            activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
        }
    }

    const sections = ['hero', 'services', 'dest_showcase', 'about', 'story', 'process', 'features', 'gallery', 'cta'];
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

    if (history.replaceState) {
        history.replaceState(null, '', secName === 'all' ? '#all' : `#sec-${secName}`);
    }

    window.dispatchEvent(new Event('resize'));

    const card = document.querySelector('.dest-header-card');
    if (card) {
        const topPos = card.getBoundingClientRect().top + window.scrollY - 10;
        if (window.scrollY > topPos + 80) {
            window.scrollTo({ top: topPos, behavior: 'smooth' });
        }
    }
}

// ── Destination 3D Showcase Dynamic Management ─────────────
const CURRENT_ACTIVE_SHOWCASE = <?= json_encode(array_values($activeCardKeys)) ?>;

function switchDestShowcaseCard(cardKey, btn) {
    document.querySelectorAll('.dest-showcase-pane').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.showcase-country-pill, .dest-showcase-tab-btn').forEach(b => b.classList.remove('active'));
    const pane = document.getElementById('dest-pane-' + cardKey);
    if (pane) pane.style.display = 'block';
    const targetBtn = btn || document.querySelector(`.showcase-country-pill[data-card="${cardKey}"]`);
    if (targetBtn) targetBtn.classList.add('active');
}
window.switchDestShowcaseCard = switchDestShowcaseCard;

async function saveShowcaseActiveList(newList, activeKeyToSelect) {
    const data = new FormData();
    data.append('_csrf', CMS_CSRF);
    data.append('action', 'save_page_field');
    data.append('page_slug', 'home');
    data.append('section_key', 'dest_showcase_header');
    data.append('field_key', 'active_countries');
    data.append('field_value', JSON.stringify(newList));

    try {
        const res = await fetch('../api/save.php', { method: 'POST', body: data });
        const json = await res.json();
        if (json.ok) {
            Toast.success('Destinations showcase updated!');
            if (activeKeyToSelect) {
                sessionStorage.setItem('active_dest_card', activeKeyToSelect);
            }
            setTimeout(() => {
                window.location.hash = '#sec-dest_showcase';
                window.location.reload();
            }, 400);
        } else {
            Toast.error(json.error || 'Failed to update destinations showcase.');
        }
    } catch (err) {
        Toast.error('Network error while updating destinations.');
    }
}
window.saveShowcaseActiveList = saveShowcaseActiveList;

function moveShowcaseCountry(key, delta) {
    const list = [...CURRENT_ACTIVE_SHOWCASE];
    const idx = list.indexOf(key);
    if (idx === -1) return;
    const targetIdx = idx + delta;
    if (targetIdx < 0 || targetIdx >= list.length) return;

    const temp = list[idx];
    list[idx] = list[targetIdx];
    list[targetIdx] = temp;

    saveShowcaseActiveList(list, key);
}
window.moveShowcaseCountry = moveShowcaseCountry;

function removeShowcaseCountry(key, countryName) {
    if (CURRENT_ACTIVE_SHOWCASE.length <= 2) {
        alert('You must have at least 2 destination cards active for the 3D scroll showcase to work smoothly on the homepage.');
        return;
    }
    if (!confirm(`Are you sure you want to remove ${countryName} from the Homepage 3D Showcase?\n\n(Note: Any custom text and uploaded images for this country are preserved safely in the database if you ever add it back.)`)) {
        return;
    }

    const list = CURRENT_ACTIVE_SHOWCASE.filter(k => k !== key);
    const nextKey = list[0] || '';
    saveShowcaseActiveList(list, nextKey);
}
window.removeShowcaseCountry = removeShowcaseCountry;

function addShowcaseCountry(key) {
    if (!key) return;
    const cleanKey = key.toLowerCase().replace(/[^a-z0-9_-]/g, '');
    if (!cleanKey) return;
    if (CURRENT_ACTIVE_SHOWCASE.includes(cleanKey)) {
        Toast.error('This country is already active in your 3D Showcase!');
        return;
    }
    const list = [...CURRENT_ACTIVE_SHOWCASE, cleanKey];
    saveShowcaseActiveList(list, cleanKey);
}
window.addShowcaseCountry = addShowcaseCountry;

function addCustomShowcaseCountry() {
    const nameInput = document.getElementById('custom_dest_name');
    const slugInput = document.getElementById('custom_dest_slug');
    const name = (nameInput ? nameInput.value : '').trim();
    let slug = (slugInput ? slugInput.value : '').trim().toLowerCase().replace(/[^a-z0-9_-]/g, '');
    if (!slug && name) {
        slug = name.toLowerCase().replace(/[^a-z0-9]/g, '');
    }
    if (!name || !slug) {
        Toast.error('Please enter at least a Country Name.');
        return;
    }
    addShowcaseCountry(slug);
}
window.addCustomShowcaseCountry = addCustomShowcaseCountry;

function openAddCountryModal() {
    const m = document.getElementById('destAddCountryModal');
    if (m) m.style.display = 'flex';
}
window.openAddCountryModal = openAddCountryModal;

function closeAddCountryModal() {
    const m = document.getElementById('destAddCountryModal');
    if (m) m.style.display = 'none';
}
window.closeAddCountryModal = closeAddCountryModal;

// ── Tab ScrollSpy in "All Sections" Mode ──────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const sectionIds = ['hero', 'services', 'dest_showcase', 'about', 'story', 'process', 'features', 'gallery', 'cta'];
    const sections = sectionIds.map(id => document.getElementById(`sec-${id}`)).filter(Boolean);
    window.addEventListener('scroll', () => {
        const allBtn = document.querySelector('#homeTabsWrap .dest-tab-btn[data-sec="all"]');
        if (!allBtn || !allBtn.classList.contains('active')) return;

        const scrollPos = window.scrollY + 130;
        let currentSec = sections[0];
        for (const sec of sections) {
            if (sec.offsetTop <= scrollPos) currentSec = sec;
        }
        if (currentSec) {
            const secKey = currentSec.id.replace('sec-', '');
            document.querySelectorAll('#homeTabsWrap .dest-tab-btn').forEach(b => {
                b.classList.toggle('is-scrolled-active', b.dataset.sec === secKey);
            });
        }
    }, { passive: true });

    // Handle deep-link
    const hash = (window.location.hash || '').replace('#sec-', '').replace('#', '');
    const valid = ['hero', 'services', 'dest_showcase', 'about', 'story', 'process', 'features', 'gallery', 'cta', 'all'];
    const initialSec = valid.includes(hash) ? hash : 'hero';
    const targetBtn = document.querySelector(`#homeTabsWrap .dest-tab-btn[data-sec="${initialSec}"]`);
    if (targetBtn) {
        switchHomeTab(initialSec, targetBtn);
    }

    // Restore active destination card if navigated or updated
    const savedCard = sessionStorage.getItem('active_dest_card');
    if (savedCard) {
        sessionStorage.removeItem('active_dest_card');
        const pill = document.querySelector(`.showcase-country-pill[data-card="${savedCard}"]`);
        if (pill) switchDestShowcaseCard(savedCard, pill);
    }
});

// ── Save Section Handler with Feedback ───────────────────────
async function saveSection(section, btn) {
    window.cmsSyncEditors?.();
    const fields = {};
    document.querySelectorAll(`[data-section="${section}"]`).forEach(el => {
        fields[el.dataset.field] = el.value;
    });

    const origBtnHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.classList.add('is-saving');
        btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cms-spin"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> <span>Saving...</span>';
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
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('is-saving');
            btn.innerHTML = origBtnHtml;
        }
    }
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
