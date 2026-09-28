<?php
/**
 * footer-editor.php — Footer Content Editor
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Footer Editor';
$pageSlug     = 'footer-editor';
cms_require_permission($pageSlug);
$pageSubtitle = 'Manage footer columns, links, and contact details';
$cmsRoot      = '../';

// Footer contact fields from cms_pages
function get_footer_field(PDO $pdo, string $field, string $default = ''): string
{
    $stmt = $pdo->prepare("SELECT field_value FROM cms_pages WHERE page_slug='global' AND section_key='footer' AND field_key=? LIMIT 1");
    $stmt->execute([$field]);
    return $stmt->fetchColumn() ?: $default;
}

$contact = [
    'phone'   => get_footer_field($pdo, 'phone',   '+91 73890 40152'),
    'email'   => get_footer_field($pdo, 'email',   'info@visabuz.com'),
    'office1' => get_footer_field($pdo, 'office1', 'Noida: Sector 142, UP'),
    'office2' => get_footer_field($pdo, 'office2', 'France: Paris'),
    'copy'    => get_footer_field($pdo, 'copy',    'All rights reserved for @Visabuz • Global Study, Work & Travel Visa Experts'),
];

$footerLinks = $pdo->query("SELECT * FROM cms_footer_links ORDER BY column_key, sort_order")->fetchAll();
$grouped = ['services' => [], 'countries' => []];
foreach ($footerLinks as $f) $grouped[$f['column_key']][] = $f;

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- Contact Info -->
<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        Contact & Office Info
      </div>
      <div class="cms-card-subtitle">Shown in the footer contact column</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="saveContact()">Save Contact</button>
  </div>

  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Phone</label>
      <input type="text" id="footer_phone" class="cms-input" value="<?= htmlspecialchars($contact['phone']) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Email</label>
      <input type="email" id="footer_email" class="cms-input" value="<?= htmlspecialchars($contact['email']) ?>" />
    </div>
  </div>
  <div class="cms-input-row">
    <div class="cms-form-group">
      <label class="cms-label">Office 1</label>
      <input type="text" id="footer_office1" class="cms-input" value="<?= htmlspecialchars($contact['office1']) ?>" />
    </div>
    <div class="cms-form-group">
      <label class="cms-label">Office 2</label>
      <input type="text" id="footer_office2" class="cms-input" value="<?= htmlspecialchars($contact['office2']) ?>" />
    </div>
  </div>
  <div class="cms-form-group">
    <label class="cms-label">Copyright Text</label>
    <input type="text" id="footer_copy" class="cms-input" value="<?= htmlspecialchars($contact['copy']) ?>" />
  </div>
</div>

<!-- Visa Services Links -->
<?php
$footerCols = [
    'services' => [
        'title' => 'Visa Services Links',
        'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'
    ],
    'countries' => [
        'title' => 'Top Countries Links',
        'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>'
    ]
];
foreach ($footerCols as $col => $colInfo): ?>
<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title"><?= $colInfo['icon'] ?> <?= htmlspecialchars($colInfo['title']) ?></div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="openFooterModal(0,'<?= $col ?>')">+ Add Link</button>
  </div>

  <div class="cms-table-wrap">
    <table class="cms-table">
      <thead><tr><th>Label</th><th>Target Link</th><th>Status</th><th style="width:100px;text-align:right;">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($grouped[$col] as $fl): ?>
        <tr data-sort-id="<?= $fl['id'] ?>">
          <td style="font-weight:500;color:var(--text-primary);font-size:14.5px;"><?= htmlspecialchars($fl['label']) ?></td>
          <td><span class="cms-slug-pill"><?= htmlspecialchars($fl['url']) ?></span></td>
          <td>
            <div class="cms-status-cell">
              <label class="cms-toggle" title="Toggle active status">
                <input type="checkbox" <?= $fl['is_active'] ? 'checked' : '' ?>
                       data-table="cms_footer_links" data-id="<?= $fl['id'] ?>" data-field="is_active" />
                <span class="cms-toggle-track"></span>
              </label>
              <span class="cms-status-tag <?= $fl['is_active'] ? 'active' : 'inactive' ?>">
                <?= $fl['is_active'] ? 'Active' : 'Disabled' ?>
              </span>
            </div>
          </td>
          <td style="text-align:right;">
            <div class="cms-table-actions" style="justify-content:flex-end;">
              <button type="button" class="cms-action-icon-btn-sm" onclick='openFooterModal(<?= $fl["id"] ?>,"<?= $col ?>")' title="Edit Footer Link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
              </button>
              <button type="button" class="cms-action-icon-btn-sm danger"
                data-confirm="Delete '<?= htmlspecialchars($fl['label']) ?>'?"
                onclick="deleteFooterLink(<?= $fl['id'] ?>, this.closest('tr'))"
                title="Delete Footer Link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
              </button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endforeach; ?>

<!-- Footer Link Modal -->
<div class="cms-modal-backdrop" id="footerLinkModal">
  <div class="cms-modal">
    <div class="cms-modal-header">
      <div class="cms-modal-title" id="footerModalTitle">Add Footer Link</div>
      <button class="cms-modal-close" aria-label="Close">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="cms-modal-body">
      <input type="hidden" id="fl_id" value="0" />
      <input type="hidden" id="fl_column" value="services" />
      <div class="cms-form-group">
        <label class="cms-label">Label</label>
        <input type="text" id="fl_label" class="cms-input" placeholder="Student Visa" />
      </div>
      <div class="cms-form-group">
        <label class="cms-label">URL</label>
        <input type="text" id="fl_url" class="cms-input" placeholder="#activities" />
      </div>
    </div>
    <div class="cms-modal-footer">
      <button class="cms-btn cms-btn-secondary" onclick="Modal.close('footerLinkModal')">Cancel</button>
      <button class="cms-btn cms-btn-primary" onclick="saveFooterLink()">Save</button>
    </div>
  </div>
</div>

<script>
const FL_DATA = <?= json_encode(array_combine(array_column($footerLinks,'id'), $footerLinks)) ?>;

async function saveContact() {
    const data = new FormData();
    data.append('_csrf',        CMS_CSRF);
    data.append('action',       'save_page_fields');
    data.append('page_slug',    'global');
    data.append('section_key',  'footer');
    ['phone','email','office1','office2','copy'].forEach(f => {
        data.append(`fields[${f}]`, document.getElementById(`footer_${f}`).value);
    });
    const res  = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    json.ok ? Toast.success('Contact info saved!') : Toast.error(json.error ?? 'Error');
}

function openFooterModal(id, col) {
    document.getElementById('footerModalTitle').textContent = id ? 'Edit Link' : 'Add Link';
    document.getElementById('fl_id').value     = id;
    document.getElementById('fl_column').value = col;
    const f = FL_DATA[id] ?? {};
    document.getElementById('fl_label').value = f.label ?? '';
    document.getElementById('fl_url').value   = f.url   ?? '';
    Modal.open('footerLinkModal');
}

async function saveFooterLink() {
    const data = new FormData();
    data.append('_csrf',       CMS_CSRF);
    data.append('action',      'save_footer_link');
    data.append('id',          document.getElementById('fl_id').value);
    data.append('column_key',  document.getElementById('fl_column').value);
    data.append('label',       document.getElementById('fl_label').value);
    data.append('url',         document.getElementById('fl_url').value);
    const res  = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    if (json.ok) { Toast.success('Saved!'); Modal.close('footerLinkModal'); setTimeout(() => location.reload(), 800); }
    else Toast.error(json.error ?? 'Error');
}

async function deleteFooterLink(id, row) {
    const data = new FormData();
    data.append('_csrf', CMS_CSRF); data.append('action','delete');
    data.append('table','cms_footer_links'); data.append('id', id);
    const res  = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    if (json.ok) { row?.remove(); Toast.success('Deleted.'); }
    else Toast.error(json.error ?? 'Error');
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
