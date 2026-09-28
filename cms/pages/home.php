<?php
/**
 * home.php — Home Page Section Editor
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Home Page Editor';
$pageSlug     = 'home';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit hero, about, and stats sections';
$cmsRoot      = '../';

// ── Fetch existing values ──────────────────────────────────
function get_field(PDO $pdo, string $section, string $field, string $default = ''): string
{
    $stmt = $pdo->prepare("SELECT field_value FROM cms_pages WHERE page_slug='home' AND section_key=? AND field_key=? LIMIT 1");
    $stmt->execute([$section, $field]);
    return $stmt->fetchColumn() ?: $default;
}

$hero = [
    'eyebrow'   => get_field($pdo, 'hero', 'eyebrow',   'Global Study, Work & Travel Visa Experts'),
    'title_1'   => get_field($pdo, 'hero', 'title_1',   'Study, Work &'),
    'title_2'   => get_field($pdo, 'hero', 'title_2',   'Settle Abroad'),
    'cta_label' => get_field($pdo, 'hero', 'cta_label', 'Book Free Consultation'),
    'cta_url'   => get_field($pdo, 'hero', 'cta_url',   '#book'),
];

$about = [
    'title'       => get_field($pdo, 'about', 'title',       'Study, Work & Settle Abroad — Made Simple'),
    'paragraph'   => get_field($pdo, 'about', 'paragraph',   'At Visabuz, we believe borders should never limit ambition. We are a trusted overseas education and immigration consultancy, helping individuals and families access global opportunities through expert guidance in student, work, tourist, and permanent residency visas.'),
    'cta_label'   => get_field($pdo, 'about', 'cta_label',   'Request Consultation'),
    'cta_url'     => get_field($pdo, 'about', 'cta_url',     '#book'),
    'stat1_label' => get_field($pdo, 'about', 'stat1_label', 'Success Rate'),
    'stat1_value' => get_field($pdo, 'about', 'stat1_value', '98% visa approval'),
    'stat2_label' => get_field($pdo, 'about', 'stat2_label', 'Students Guided'),
    'stat2_value' => get_field($pdo, 'about', 'stat2_value', '176+ placed'),
    'stat3_label' => get_field($pdo, 'about', 'stat3_label', 'Global Destinations'),
    'stat3_value' => get_field($pdo, 'about', 'stat3_value', '10+ countries'),
    'review_count'=> get_field($pdo, 'about', 'review_count','176+'),
    'rating'      => get_field($pdo, 'about', 'rating',      '4.9/5'),
];

$story = [
    'title' => get_field($pdo, 'story', 'title', 'Every journey, a new future'),
    'desc'  => get_field($pdo, 'story', 'desc',  'From university shortlisting to visa approval — we guide every single step.'),
];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Hero Section
      </div>
      <div class="cms-card-subtitle">Main landing banner — eyebrow text, title, and CTA button</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveSection('hero')">Save Hero</button>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="hero_eyebrow">Eyebrow Text</label>
      <input type="text" id="hero_eyebrow" class="cms-input" value="<?= htmlspecialchars($hero['eyebrow']) ?>"
             data-section="hero" data-field="eyebrow" data-maxlength="80" />
    </div>
    <div></div>
  </div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="hero_title_1">H1 Line 1</label>
      <input type="text" id="hero_title_1" class="cms-input" value="<?= htmlspecialchars($hero['title_1']) ?>"
             data-section="hero" data-field="title_1" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="hero_title_2">H1 Line 2</label>
      <input type="text" id="hero_title_2" class="cms-input" value="<?= htmlspecialchars($hero['title_2']) ?>"
             data-section="hero" data-field="title_2" />
    </div>
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
</div>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        About / Who We Are
      </div>
      <div class="cms-card-subtitle">Title, paragraph, CTA, and stats</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveSection('about')">Save About</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label" for="about_title">Section Title</label>
    <input type="text" id="about_title" class="cms-input" value="<?= htmlspecialchars($about['title']) ?>"
           data-section="about" data-field="title" />
  </div>
  <div class="cms-form-group">
    <label class="cms-label" for="about_paragraph">Paragraph</label>
    <textarea id="about_paragraph" class="cms-textarea" data-section="about" data-field="paragraph"><?= htmlspecialchars($about['paragraph']) ?></textarea>
  </div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label" for="about_cta_label">CTA Label</label>
      <input type="text" id="about_cta_label" class="cms-input" value="<?= htmlspecialchars($about['cta_label']) ?>"
             data-section="about" data-field="cta_label" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label" for="about_cta_url">CTA URL</label>
      <input type="text" id="about_cta_url" class="cms-input" value="<?= htmlspecialchars($about['cta_url']) ?>"
             data-section="about" data-field="cta_url" />
    </div>
  </div>

  <div style="border-top:1px solid var(--border-muted);padding-top:18px;margin-top:4px;">
    <div class="cms-card-subtitle" style="margin-bottom:14px">Stats (right column)</div>
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

    <div class="cms-input-row">
      <div class="cms-form-group">
        <label class="cms-label">Review Count Badge (e.g. "176+")</label>
        <input type="text" id="about_review_count" class="cms-input" value="<?= htmlspecialchars($about['review_count']) ?>"
               data-section="about" data-field="review_count" />
      </div>
      <div class="cms-form-group">
        <label class="cms-label">Rating Score (e.g. "4.9/5")</label>
        <input type="text" id="about_rating" class="cms-input" value="<?= htmlspecialchars($about['rating']) ?>"
               data-section="about" data-field="rating" />
      </div>
    </div>
  </div>
</div>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
        Story Card
      </div>
      <div class="cms-card-subtitle">The "Every journey, a new future" card inside the About section</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveSection('story')">Save Story</button>
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
</div>

<script>
async function saveSection(section) {
    window.cmsSyncEditors?.();
    const fields = {};
    document.querySelectorAll(`[data-section="${section}"]`).forEach(el => {
        fields[el.dataset.field] = el.value;
    });

    const data = new FormData();
    data.append('_csrf',        CMS_CSRF);
    data.append('action',       'save_page_fields');
    data.append('page_slug',    'home');
    data.append('section_key',  section);
    for (const [k, v] of Object.entries(fields)) data.append(`fields[${k}]`, v);

    const res  = await fetch('../api/save.php', { method: 'POST', body: data });
    const json = await res.json();
    json.ok ? Toast.success('Section saved!') : Toast.error(json.error ?? 'Error');
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
