<?php
/**
 * seo.php — SEO Meta Editor (per page)
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'SEO Manager';
$pageSlug     = 'seo';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit <title> and meta description for each page';
$cmsRoot      = '../';

$pages = [
    'home'     => ['label' => 'Home (index.php)',       'default_title' => 'Visabuz — Study, Work & Settle Abroad | Overseas Visa Consultancy'],
];

function get_seo(PDO $pdo, string $slug, string $field, string $default = ''): string
{
    $stmt = $pdo->prepare("SELECT field_value FROM cms_pages WHERE page_slug=? AND section_key='seo' AND field_key=? LIMIT 1");
    $stmt->execute([$slug, $field]);
    return $stmt->fetchColumn() ?: $default;
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<?php foreach ($pages as $slug => $meta): ?>
<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <?= htmlspecialchars($meta['label']) ?>
      </div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveSeo('<?= $slug ?>')">Save SEO</button>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Page &lt;title&gt;</label>
    <input type="text" id="seo_title_<?= $slug ?>" class="cms-input"
           value="<?= htmlspecialchars(get_seo($pdo, $slug, 'title', $meta['default_title'])) ?>"
           data-maxlength="70"
           placeholder="<?= htmlspecialchars($meta['default_title']) ?>" />
    <p style="font-size:11px;color:var(--text-muted);margin-top:4px">Recommended: 50–70 characters. Displayed in browser tab and Google results.</p>
  </div>

  <div class="cms-form-group">
    <label class="cms-label">Meta Description</label>
    <textarea id="seo_desc_<?= $slug ?>" class="cms-textarea" style="min-height:80px"
              data-maxlength="160"
              placeholder="Write a compelling meta description…"><?= htmlspecialchars(get_seo($pdo, $slug, 'description', '')) ?></textarea>
    <p style="font-size:11px;color:var(--text-muted);margin-top:4px">Recommended: 120–160 characters. Shown in Google search snippets.</p>
  </div>

  <!-- Live Preview -->
  <div style="border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:18px 20px;background:#ffffff;box-shadow:var(--shadow-xs);margin-top:16px;">
    <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
      <span style="font-size:11px;color:var(--text-muted);font-weight:500;letter-spacing:0.04em;text-transform:uppercase;">Search Result Preview</span>
    </div>
    <div style="font-size:12px;color:#4d5156;margin-bottom:4px;">
      visabuz.com &rsaquo; <?= $slug === 'home' ? '' : htmlspecialchars($slug) ?>
    </div>
    <div id="preview_title_<?= $slug ?>" style="font-size:18px;color:#1a0dab;font-family:-apple-system,BlinkMacSystemFont,Roboto,sans-serif;line-height:1.3;margin-bottom:4px;cursor:pointer;">
      <?= htmlspecialchars(get_seo($pdo, $slug, 'title', $meta['default_title'])) ?>
    </div>
    <div id="preview_desc_<?= $slug ?>" style="font-size:13px;color:#4d5156;line-height:1.55;font-family:-apple-system,BlinkMacSystemFont,Roboto,sans-serif;">
      <?= htmlspecialchars(get_seo($pdo, $slug, 'description', '')) ?>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script>
// Live preview update
['home'].forEach(slug => {
    const titleEl = document.getElementById(`seo_title_${slug}`);
    const descEl  = document.getElementById(`seo_desc_${slug}`);
    const pvTitle = document.getElementById(`preview_title_${slug}`);
    const pvDesc  = document.getElementById(`preview_desc_${slug}`);

    titleEl?.addEventListener('input', () => pvTitle.textContent = titleEl.value);
    descEl?.addEventListener('input',  () => pvDesc.textContent  = descEl.value);
});

async function saveSeo(slug) {
    window.cmsSyncEditors?.();
    const data = new FormData();
    data.append('_csrf',       CMS_CSRF);
    data.append('action',      'save_page_fields');
    data.append('page_slug',   slug);
    data.append('section_key', 'seo');
    data.append('fields[title]',       document.getElementById(`seo_title_${slug}`).value);
    data.append('fields[description]', document.getElementById(`seo_desc_${slug}`).value);
    const res  = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    json.ok ? Toast.success('SEO saved!') : Toast.error(json.error ?? 'Error');
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
