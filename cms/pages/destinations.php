<?php
/**
 * destinations.php — Destinations Manager
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Destinations Manager';
$pageSlug     = 'destinations';
cms_require_permission($pageSlug);
$pageSubtitle = 'Manage study-abroad destination cards and features';
$cmsRoot      = '../';

$destinations = $pdo->query("SELECT * FROM cms_destinations ORDER BY sort_order ASC")->fetchAll();

// Fetch features per destination
$featuresMap = [];
$featRows    = $pdo->query("SELECT * FROM cms_destination_features ORDER BY destination_id, sort_order")->fetchAll();
foreach ($featRows as $f) {
    $featuresMap[$f['destination_id']][] = $f;
}

$countryMeta = [
    'uk'      => ['code' => 'GB', 'bg' => '#eff6ff', 'border' => '#bfdbfe', 'color' => '#1d4ed8'],
    'usa'     => ['code' => 'US', 'bg' => '#fef2f2', 'border' => '#fecaca', 'color' => '#b91c1c'],
    'ireland' => ['code' => 'IE', 'bg' => '#f0fdf4', 'border' => '#bbf7d0', 'color' => '#15803d'],
    'canada'  => ['code' => 'CA', 'bg' => '#fef2f2', 'border' => '#fecaca', 'color' => '#dc2626'],
    'germany' => ['code' => 'DE', 'bg' => '#fefce8', 'border' => '#fde68a', 'color' => '#b45309'],
    'dubai'   => ['code' => 'AE', 'bg' => '#faf5ff', 'border' => '#e9d5ff', 'color' => '#7e22ce'],
    'france'  => ['code' => 'FR', 'bg' => '#eff6ff', 'border' => '#bfdbfe', 'color' => '#2563eb'],
    'europe'  => ['code' => 'EU', 'bg' => '#ecfeff', 'border' => '#a5f3fc', 'color' => '#0e7490'],
    'italy'   => ['code' => 'IT', 'bg' => '#f0fdf4', 'border' => '#bbf7d0', 'color' => '#16a34a'],
];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- Notice: Homepage 3D Destinations Showcase -->
<div class="cms-card" style="margin-bottom:20px;background:linear-gradient(135deg,#0a192f,#0f2d4a);border:1px solid #1e3a8a;color:#fff;">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;padding:4px 6px;">
    <div style="display:flex;align-items:center;gap:14px;">
      <div style="width:42px;height:42px;border-radius:10px;background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);display:flex;align-items:center;justify-content:center;color:#4ade80;flex-shrink:0;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
      </div>
      <div>
        <div style="font-weight:600;font-size:14px;color:#fff;">Looking to edit the Homepage 3D Destinations Showcase?</div>
        <div style="font-size:12.5px;color:#94a3b8;margin-top:2px;">Customize &ldquo;Explore The World&rsquo;s Leading Study &amp; Visa Hubs&rdquo; &mdash; Canada, UK, Germany, and Australia 3D perspective flip cards with fullscreen crossfading photos.</div>
      </div>
    </div>
    <a href="home.php#sec-dest_showcase" class="cms-btn cms-btn-primary" style="font-size:12.5px;padding:8px 16px;gap:6px;white-space:nowrap;">
      <span>Edit Homepage 3D Showcase &rarr;</span>
    </a>
  </div>
</div>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>
        All Destinations <span class="cms-badge cms-badge-green" id="destCountBadge" style="margin-left:8px"><?= count($destinations) ?> Destinations</span>
      </div>
      <div class="cms-card-subtitle">Drag rows to reorder. Click Content to update study page sections or Edit for card details.</div>
    </div>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
      <div class="cms-table-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="destFilterInput" placeholder="Quick filter..." oninput="filterDestinations(this.value)" />
      </div>
      <button type="button" class="cms-btn cms-btn-primary" onclick="openDestModal(0)" style="gap:8px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Destination
      </button>
    </div>
  </div>

  <?php if (empty($destinations)): ?>
    <div class="cms-empty">
      <p>No destinations yet. Click "+ Add Destination" to create one.</p>
    </div>
  <?php else: ?>
  <div class="cms-table-wrap">
    <table class="cms-table">
      <thead>
        <tr>
          <th style="width:36px;text-align:center;"></th>
          <th style="min-width:180px;">Destination</th>
          <th style="width:105px;">Page Route</th>
          <th style="width:185px;">Call To Action</th>
          <th style="width:125px;">Status</th>
          <th style="text-align:right;width:170px;">Actions</th>
        </tr>
      </thead>
      <tbody id="destTableBody" data-sortable="cms_destinations">
        <?php foreach ($destinations as $dest): 
            $featCount = count($featuresMap[$dest['id']] ?? []);
            $slugKey   = strtolower($dest['country_slug']);
            $meta      = $countryMeta[$slugKey] ?? [
                'code'   => strtoupper(substr($slugKey, 0, 2)),
                'bg'     => '#f1f5f9',
                'border' => '#e2e8f0',
                'color'  => '#475569'
            ];
        ?>
        <tr data-sort-id="<?= $dest['id'] ?>">
          <td style="text-align:center;">
            <span class="cms-drag-handle" title="Drag to reorder destination">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="9" cy="6" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="18" r="1"/><circle cx="15" cy="6" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="18" r="1"/></svg>
            </span>
          </td>
          <td>
            <div class="cms-country-cell">
              <div class="cms-country-avatar" style="background:<?= $meta['bg'] ?>;border-color:<?= $meta['border'] ?>;color:<?= $meta['color'] ?>;">
                <?= $meta['code'] ?>
              </div>
              <div>
                <div class="cms-country-name"><?= htmlspecialchars($dest['country_name']) ?></div>
                <div class="cms-country-sub">
                  <?= $featCount > 0 ? ($featCount . ' feature' . ($featCount === 1 ? '' : 's') . ' configured') : 'Active Pathway' ?>
                </div>
              </div>
            </div>
          </td>
          <td>
            <span class="cms-slug-pill">/<?= htmlspecialchars($dest['country_slug']) ?></span>
          </td>
          <td>
            <a href="<?= htmlspecialchars($dest['cta_url']) ?>" target="_blank" class="cms-cta-link" title="<?= htmlspecialchars($dest['cta_label']) ?>">
              <span><?= htmlspecialchars($dest['cta_label']) ?></span>
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
          </td>
          <td>
            <div class="cms-status-cell">
              <label class="cms-toggle" title="Toggle active status">
                <input type="checkbox" <?= $dest['is_active'] ? 'checked' : '' ?>
                       data-table="cms_destinations" data-id="<?= $dest['id'] ?>" data-field="is_active" />
                <span class="cms-toggle-track"></span>
              </label>
              <span class="cms-status-tag <?= $dest['is_active'] ? 'active' : 'inactive' ?>">
                <?= $dest['is_active'] ? 'Active' : 'Disabled' ?>
              </span>
            </div>
          </td>
          <td style="text-align:right;">
            <div class="cms-table-actions" style="justify-content:flex-end;">
              <a href="destination-content.php?id=<?= $dest['id'] ?>" class="cms-action-pill-btn" title="Manage Study Page Content">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span>Content</span>
              </a>
              <button type="button" class="cms-action-icon-btn-sm" onclick='openDestModal(<?= $dest["id"] ?>)' title="Edit Destination Details">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
              </button>
              <button type="button" class="cms-action-icon-btn-sm danger"
                data-confirm="Delete '<?= htmlspecialchars($dest['country_name']) ?>'? This cannot be undone."
                onclick="deleteRow('cms_destinations', <?= $dest['id'] ?>, this.closest('tr'))"
                title="Delete Destination">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
              </button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- ═══════════════════ EDIT MODAL ════════════════════════ -->
<div class="cms-modal-backdrop" id="destModal">
  <div class="cms-modal">
    <div class="cms-modal-header">
      <div class="cms-modal-title" id="destModalTitle">Add Destination</div>
      <button class="cms-modal-close" aria-label="Close">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="cms-modal-body">
      <input type="hidden" id="dest_id" value="0" />

      <div class="cms-input-row">
        <div class="cms-form-group">
          <label class="cms-label">Country Name</label>
          <input type="text" id="dest_country_name" class="cms-input" placeholder="Study in UK" />
        </div>
        <div class="cms-form-group">
          <label class="cms-label">Slug (unique ID)</label>
          <input type="text" id="dest_country_slug" class="cms-input" placeholder="uk" />
        </div>
      </div>
      <div class="cms-form-group">
        <label class="cms-label">Hero Image</label>
        <div class="cms-image-upload-wrap">
          <div class="cms-image-preview-box" id="box_dest_hero">
            <img id="prev_dest_hero" src="" alt="Preview" style="display:none;" />
            <div class="cms-upload-empty" id="empty_dest_hero">No Image</div>
          </div>
          <div class="cms-upload-content" style="flex:1;">
            <div class="cms-upload-actions">
              <label class="cms-upload-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span id="lbl_dest_hero">Upload Image</span>
                <input type="file" accept="image/*" style="display:none;" onchange="cmsUploadFile(this, 'dest_hero_image', 'prev_dest_hero')" />
              </label>
              <button type="button" class="cms-remove-img-btn" onclick="cmsRemoveImage('dest_hero_image', 'prev_dest_hero')">Remove</button>
            </div>
            <div style="font-size:12px; color:var(--text-muted); margin-top:6px;">Upload hero destination card photo (JPG, PNG, WebP)</div>
          </div>
          <input type="hidden" id="dest_hero_image" class="cms-input" />
        </div>
      </div>
      <div class="cms-input-row">
        <div class="cms-form-group">
          <label class="cms-label">CTA Button Label</label>
          <input type="text" id="dest_cta_label" class="cms-input" placeholder="Explore UK Programs" />
        </div>
        <div class="cms-form-group">
          <label class="cms-label">CTA URL</label>
          <input type="text" id="dest_cta_url" class="cms-input" placeholder="study-global.php?country=uk or #book" />
        </div>
      </div>

      <!-- Features -->
      <div style="border-top:1px solid var(--border-muted);margin:18px 0 14px;padding-top:16px;">
        <div class="cms-card-subtitle" style="margin-bottom:12px;font-size:12.5px;font-weight:500">Feature Highlights (up to 3)</div>
        <div id="featuresContainer">
          <?php foreach ([0,1,2] as $i): ?>
          <div class="feature-row" style="background:#f8fafc;border:1px solid var(--border-muted);border-radius:var(--radius-md);padding:14px 16px;margin-bottom:12px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
              <span style="font-size:12px;font-weight:500;color:var(--text-primary);letter-spacing:0.02em;">Highlight <?= $i+1 ?></span>
              <select class="cms-select feat-icon" style="width:145px;padding:4px 10px;font-size:12.5px;">
                <option value="green">Green Accent</option>
                <option value="purple">Purple Accent</option>
                <option value="blue">Blue Accent</option>
              </select>
            </div>
            <div class="cms-form-group" style="margin-bottom:10px">
              <input type="text" class="cms-input feat-title" placeholder="Highlight title (e.g. World-Class Education)" />
            </div>
            <div class="cms-form-group" style="margin-bottom:0">
              <textarea class="cms-textarea feat-desc" style="min-height:55px;font-size:13.5px;" placeholder="Short highlight description..."></textarea>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="cms-modal-footer">
      <button class="cms-btn cms-btn-secondary" onclick="Modal.close('destModal')">Cancel</button>
      <button class="cms-btn cms-btn-primary" onclick="saveDest()">Save Destination</button>
    </div>
  </div>
</div>

<script>
// Destinations JSON for the modal
const DEST_DATA = <?= json_encode(array_combine(
    array_column($destinations, 'id'),
    $destinations
)) ?>;
const FEAT_DATA = <?= json_encode($featuresMap) ?>;

function openDestModal(id) {
    document.getElementById('destModalTitle').textContent = id ? 'Edit Destination' : 'Add Destination';
    document.getElementById('dest_id').value = id;

    const d = DEST_DATA[id] ?? {};
    document.getElementById('dest_country_name').value  = d.country_name  ?? '';
    const imgUrl = d.hero_image_url ?? '';
    document.getElementById('dest_hero_image').value = imgUrl;
    const prev = document.getElementById('prev_dest_hero');
    const empty = document.getElementById('empty_dest_hero');
    const lbl = document.getElementById('lbl_dest_hero');
    if (imgUrl) {
        prev.src = (imgUrl.startsWith('http') || imgUrl.startsWith('/') || imgUrl.startsWith('data:')) ? imgUrl : (window.CMS_SITE_ROOT || '../../') + imgUrl;
        prev.style.display = 'block';
        if (empty) empty.style.display = 'none';
        if (lbl) lbl.textContent = 'Change Image';
    } else {
        prev.src = '';
        prev.style.display = 'none';
        if (empty) empty.style.display = 'block';
        if (lbl) lbl.textContent = 'Upload Image';
    }
    document.getElementById('dest_cta_label').value     = d.cta_label     ?? '';
    document.getElementById('dest_cta_url').value       = d.cta_url       ?? '';

    const feats = (FEAT_DATA[id] ?? []).slice(0, 3);
    document.querySelectorAll('.feature-row').forEach((row, i) => {
        const f = feats[i] ?? {};
        row.querySelector('.feat-icon').value  = f.icon_type    ?? ['green','purple','blue'][i];
        row.querySelector('.feat-title').value = f.title        ?? '';
        const descTa = row.querySelector('.feat-desc');
        const descVal = f.description ?? '';
        descTa.value = descVal;
        const ed = window.cmsRichEditors?.get(descTa);
        if (ed) ed.setData(descVal);
    });

    Modal.open('destModal');
}

async function saveDest() {
    window.cmsSyncEditors?.();
    const features = [];
    document.querySelectorAll('.feature-row').forEach(row => {
        features.push({
            icon_type:   row.querySelector('.feat-icon').value,
            title:       row.querySelector('.feat-title').value,
            description: row.querySelector('.feat-desc').value,
        });
    });

    const data = new FormData();
    data.append('_csrf',           CMS_CSRF);
    data.append('action',          'save_destination');
    data.append('id',              document.getElementById('dest_id').value);
    data.append('country_name',    document.getElementById('dest_country_name').value);
    data.append('country_slug',    document.getElementById('dest_country_slug').value);
    data.append('hero_image_url',  document.getElementById('dest_hero_image').value);
    data.append('cta_label',       document.getElementById('dest_cta_label').value);
    data.append('cta_url',         document.getElementById('dest_cta_url').value);
    data.append('features',        JSON.stringify(features));

    const res  = await fetch('../api/save.php', { method: 'POST', body: data });
    const json = await res.json();
    if (json.ok) {
        Toast.success('Destination saved!');
        Modal.close('destModal');
        setTimeout(() => location.reload(), 800);
    } else {
        Toast.error(json.error ?? 'Error');
    }
}

async function deleteRow(table, id, row) {
    const data = new FormData();
    data.append('_csrf',  CMS_CSRF);
    data.append('action', 'delete');
    data.append('table',  table);
    data.append('id',     id);

    const res  = await fetch('../api/save.php', { method: 'POST', body: data });
    const json = await res.json();
    if (json.ok) { row?.remove(); Toast.success('Deleted.'); }
    else Toast.error(json.error ?? 'Delete failed.');
}

// Real-time table search filter
function filterDestinations(q) {
    const term = (q || '').trim().toLowerCase();
    const rows = document.querySelectorAll('#destTableBody tr');
    let matchCount = 0;
    rows.forEach(tr => {
        const text = tr.innerText.toLowerCase();
        const match = !term || text.includes(term);
        tr.style.display = match ? '' : 'none';
        if (match) matchCount++;
    });
    const badge = document.getElementById('destCountBadge');
    if (badge) {
        badge.textContent = term ? `${matchCount} of ${rows.length}` : `${rows.length} Destinations`;
    }
}

// Auto-fill slug from country name in Add mode
document.addEventListener('DOMContentLoaded', () => {
    const nameEl = document.getElementById('dest_country_name');
    const slugEl = document.getElementById('dest_country_slug');
    if (nameEl && slugEl) {
        nameEl.addEventListener('input', () => {
            if (document.getElementById('dest_id').value === '0') {
                const s = nameEl.value
                    .toLowerCase()
                    .replace(/^study\s+in\s+/i, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugEl.value = s;
            }
        });
    }
});
</script>

<!-- SortableJS for drag-to-reorder -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const destBody = document.getElementById('destTableBody');
if (destBody) {
    Sortable.create(destBody, {
        handle: '.cms-drag-handle',
        animation: 150,
        onEnd: async () => {
            const ids = [...destBody.querySelectorAll('[data-sort-id]')].map(r => r.dataset.sortId);
            const data = new FormData();
            data.append('_csrf',  CMS_CSRF);
            data.append('action', 'reorder');
            data.append('table',  'cms_destinations');
            data.append('ids',    JSON.stringify(ids));
            await fetch('../api/save.php', { method: 'POST', body: data });
            Toast.success('Order updated.');
        }
    });
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
