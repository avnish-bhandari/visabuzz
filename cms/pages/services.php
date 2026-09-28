<?php
/**
 * services.php — Visa Services Editor
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Visa Services Editor';
$pageSlug     = 'services';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit the Offerings and Platform tabs on the homepage';
$cmsRoot      = '../';

function get_svc(PDO $pdo, string $section, string $field, string $default = ''): string
{
    $stmt = $pdo->prepare("SELECT field_value FROM cms_pages WHERE page_slug='home' AND section_key=? AND field_key=? LIMIT 1");
    $stmt->execute([$section, $field]);
    return $stmt->fetchColumn() ?: $default;
}

// Offerings tab — 3 service cards
$offerings = [];
for ($i = 1; $i <= 3; $i++) {
    $offerings[$i] = [
        'title' => get_svc($pdo, "offering_$i", 'title', ''),
        'desc'  => get_svc($pdo, "offering_$i", 'desc',  ''),
        'cta'   => get_svc($pdo, "offering_$i", 'cta',   '#book'),
    ];
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        Feature Tabs Header
      </div>
      <div class="cms-card-subtitle">The main heading above the tabs section</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveSvcSection('tabs_header')">Save</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Section Title</label>
    <input type="text" id="tabs_header_title" class="cms-input"
           value="<?= htmlspecialchars(get_svc($pdo, 'tabs_header', 'title', 'Comprehensive Visa Services & Pathways')) ?>"
           data-section="tabs_header" data-field="title" />
  </div>
</div>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        Offerings Tab — Service Cards
      </div>
      <div class="cms-card-subtitle">Three service cards shown under the "Offerings" tab</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveOfferings()">Save Offerings</button>
  </div>

  <?php for ($i = 1; $i <= 3; $i++): ?>
  <div style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:18px 20px;margin-bottom:16px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
      <span style="font-size:13.5px;font-weight:500;color:var(--text-primary);">Service Pathway <?= $i ?></span>
      <span class="cms-badge cms-badge-green">Card #<?= $i ?></span>
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Card Title</label>
      <input type="text" id="offering_<?= $i ?>_title" class="cms-input" placeholder="e.g. Student Visa Guidance" value="<?= htmlspecialchars($offerings[$i]['title']) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Description</label>
      <textarea id="offering_<?= $i ?>_desc" class="cms-textarea" style="min-height:75px" placeholder="Summary of service benefits..."><?= htmlspecialchars($offerings[$i]['desc']) ?></textarea>
    </div>
    <div class="cms-form-group" style="margin-bottom:0;">
      <label class="cms-label">CTA Target URL</label>
      <input type="text" id="offering_<?= $i ?>_cta" class="cms-input" placeholder="#book or /services.php" value="<?= htmlspecialchars($offerings[$i]['cta']) ?>" />
    </div>
  </div>
  <?php endfor; ?>
</div>

<script>
async function saveSvcSection(section) {
    window.cmsSyncEditors?.();
    const fields = {};
    document.querySelectorAll(`[data-section="${section}"]`).forEach(el => {
        fields[el.dataset.field] = el.value;
    });
    const data = new FormData();
    data.append('_csrf', CMS_CSRF);
    data.append('action', 'save_page_fields');
    data.append('page_slug', 'home');
    data.append('section_key', section);
    for (const [k,v] of Object.entries(fields)) data.append(`fields[${k}]`, v);
    const res  = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    json.ok ? Toast.success('Saved!') : Toast.error(json.error ?? 'Error');
}

async function saveOfferings() {
    window.cmsSyncEditors?.();
    const batch = [];
    for (let i = 1; i <= 3; i++) {
        batch.push(['offering_'+i, 'title', document.getElementById(`offering_${i}_title`).value]);
        batch.push(['offering_'+i, 'desc',  document.getElementById(`offering_${i}_desc`).value]);
        batch.push(['offering_'+i, 'cta',   document.getElementById(`offering_${i}_cta`).value]);
    }
    // Save sequentially
    let ok = true;
    for (const [section, field, value] of batch) {
        const data = new FormData();
        data.append('_csrf', CMS_CSRF);
        data.append('action', 'save_page_field');
        data.append('page_slug', 'home');
        data.append('section_key', section);
        data.append('field_key', field);
        data.append('field_value', value);
        const res  = await fetch('../api/save.php', { method:'POST', body:data });
        const json = await res.json();
        if (!json.ok) { ok = false; Toast.error(json.error ?? 'Error'); break; }
    }
    if (ok) Toast.success('Offerings saved!');
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
