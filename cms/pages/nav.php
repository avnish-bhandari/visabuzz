<?php
/**
 * nav.php — Navigation Link Manager
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Navigation Editor';
$pageSlug     = 'nav';
cms_require_permission($pageSlug);
$pageSubtitle = 'Edit navbar links, order, and CTA';
$cmsRoot      = '../';

$navLinks = $pdo->query("SELECT * FROM cms_nav_links ORDER BY sort_order ASC")->fetchAll();

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        Navigation Links
      </div>
      <div class="cms-card-subtitle">Drag to reorder. CTA links appear as a highlighted "Book" button.</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="openNavModal(0)">+ Add Link</button>
  </div>

  <div class="cms-table-wrap">
    <table class="cms-table">
      <thead><tr>
        <th style="width:36px"></th>
        <th>Label</th>
        <th>URL</th>
        <th>CTA Style</th>
        <th>Status</th>
        <th style="width:110px;text-align:right;">Actions</th>
      </tr></thead>
      <tbody id="navTableBody" data-sortable="cms_nav_links">
        <?php foreach ($navLinks as $link): ?>
        <tr data-sort-id="<?= $link['id'] ?>">
          <td style="text-align:center;"><span class="cms-drag-handle" title="Drag to reorder menu link">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="9" cy="6" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="18" r="1"/><circle cx="15" cy="6" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="18" r="1"/></svg>
          </span></td>
          <td style="font-weight:500;color:var(--text-primary);font-size:15px;"><?= htmlspecialchars($link['label']) ?></td>
          <td><span class="cms-slug-pill"><?= htmlspecialchars($link['url']) ?></span></td>
          <td><?= $link['is_cta'] ? '<span class="cms-badge cms-badge-green">CTA Button</span>' : '<span class="cms-badge cms-badge-inactive">Standard Link</span>' ?></td>
          <td>
            <div class="cms-status-cell">
              <label class="cms-toggle" title="Toggle active status">
                <input type="checkbox" <?= $link['is_active'] ? 'checked' : '' ?>
                       data-table="cms_nav_links" data-id="<?= $link['id'] ?>" data-field="is_active" />
                <span class="cms-toggle-track"></span>
              </label>
              <span class="cms-status-tag <?= $link['is_active'] ? 'active' : 'inactive' ?>">
                <?= $link['is_active'] ? 'Active' : 'Disabled' ?>
              </span>
            </div>
          </td>
          <td style="text-align:right;">
            <div class="cms-table-actions" style="justify-content:flex-end;">
              <button type="button" class="cms-action-icon-btn-sm" onclick='openNavModal(<?= $link["id"] ?>)' title="Edit Nav Link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
              </button>
              <button type="button" class="cms-action-icon-btn-sm danger"
                data-confirm="Delete '<?= htmlspecialchars($link['label']) ?>'?"
                onclick="deleteNav(<?= $link['id'] ?>, this.closest('tr'))"
                title="Delete Nav Link">
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

<!-- Modal -->
<div class="cms-modal-backdrop" id="navModal">
  <div class="cms-modal">
    <div class="cms-modal-header">
      <div class="cms-modal-title" id="navModalTitle">Add Nav Link</div>
      <button class="cms-modal-close" aria-label="Close">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="cms-modal-body">
      <input type="hidden" id="nav_id" value="0" />
      <div class="cms-form-group">
        <label class="cms-label">Label</label>
        <input type="text" id="nav_label" class="cms-input" placeholder="About Us" />
      </div>
      <div class="cms-form-group">
        <label class="cms-label">URL</label>
        <input type="text" id="nav_url" class="cms-input" placeholder="#about or /page.php" />
      </div>
      <div class="cms-form-group" style="display:flex;align-items:center;gap:12px">
        <label class="cms-toggle">
          <input type="checkbox" id="nav_is_cta" />
          <span class="cms-toggle-track"></span>
        </label>
        <span class="cms-label" style="margin:0">CTA button style (Book Consultation)</span>
      </div>
    </div>
    <div class="cms-modal-footer">
      <button class="cms-btn cms-btn-secondary" onclick="Modal.close('navModal')">Cancel</button>
      <button class="cms-btn cms-btn-primary" onclick="saveNavLink()">Save Link</button>
    </div>
  </div>
</div>

<script>
const NAV_DATA = <?= json_encode(array_combine(array_column($navLinks,'id'), $navLinks)) ?>;

function openNavModal(id) {
    document.getElementById('navModalTitle').textContent = id ? 'Edit Nav Link' : 'Add Nav Link';
    document.getElementById('nav_id').value = id;
    const l = NAV_DATA[id] ?? {};
    document.getElementById('nav_label').value  = l.label  ?? '';
    document.getElementById('nav_url').value    = l.url    ?? '';
    document.getElementById('nav_is_cta').checked = !!+l.is_cta;
    Modal.open('navModal');
}

async function saveNavLink() {
    const data = new FormData();
    data.append('_csrf',   CMS_CSRF);
    data.append('action',  'save_nav_link');
    data.append('id',      document.getElementById('nav_id').value);
    data.append('label',   document.getElementById('nav_label').value);
    data.append('url',     document.getElementById('nav_url').value);
    data.append('is_cta',  document.getElementById('nav_is_cta').checked ? '1' : '0');
    const res  = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    if (json.ok) { Toast.success('Saved!'); Modal.close('navModal'); setTimeout(() => location.reload(), 800); }
    else Toast.error(json.error ?? 'Error');
}

async function deleteNav(id, row) {
    const data = new FormData();
    data.append('_csrf', CMS_CSRF); data.append('action','delete');
    data.append('table','cms_nav_links'); data.append('id', id);
    const res = await fetch('../api/save.php', { method:'POST', body:data });
    const json = await res.json();
    if (json.ok) { row?.remove(); Toast.success('Deleted.'); }
    else Toast.error(json.error ?? 'Error');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const nb = document.getElementById('navTableBody');
if (nb) Sortable.create(nb, { handle:'.cms-drag-handle', animation:150,
    onEnd: async () => {
        const ids = [...nb.querySelectorAll('[data-sort-id]')].map(r => r.dataset.sortId);
        const d = new FormData();
        d.append('_csrf', CMS_CSRF); d.append('action','reorder');
        d.append('table','cms_nav_links'); d.append('ids', JSON.stringify(ids));
        await fetch('../api/save.php', {method:'POST', body:d});
        Toast.success('Order saved.');
    }
});
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
