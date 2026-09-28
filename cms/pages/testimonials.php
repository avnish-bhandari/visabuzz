<?php
/**
 * testimonials.php — Testimonials Manager
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pageTitle    = 'Testimonials';
$pageSlug     = 'testimonials';
cms_require_permission($pageSlug);
$pageSubtitle = 'Add, edit, or remove client reviews';
$cmsRoot      = '../';

$testimonials = $pdo->query("SELECT * FROM cms_testimonials ORDER BY sort_order ASC, id DESC")->fetchAll();

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="cms-card">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        Testimonials <span class="cms-badge cms-badge-accent" style="margin-left:8px"><?= count($testimonials) ?></span>
      </div>
      <div class="cms-card-subtitle">Reviews shown on the homepage</div>
    </div>
    <button class="cms-btn cms-btn-primary" onclick="openModal(0)">+ Add Review</button>
  </div>

  <?php if (empty($testimonials)): ?>
    <div class="cms-empty"><p>No testimonials yet. Add your first review.</p></div>
  <?php else: ?>
  <div class="cms-table-wrap">
    <table class="cms-table">
      <thead>
        <tr>
          <th style="width:36px"></th>
          <th>Client</th>
          <th>Country / Visa</th>
          <th>Rating</th>
          <th>Status</th>
          <th style="width:110px;text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody id="testimTableBody" data-sortable="cms_testimonials">
        <?php foreach ($testimonials as $t): ?>
        <tr data-sort-id="<?= $t['id'] ?>">
          <td style="text-align:center;"><span class="cms-drag-handle" title="Drag to reorder review">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="9" cy="6" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="18" r="1"/><circle cx="15" cy="6" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="18" r="1"/></svg>
          </span></td>
          <td>
            <div style="display:flex;align-items:center;gap:12px;">
              <?php if ($t['photo_url']): ?>
                <img src="<?= htmlspecialchars($t['photo_url']) ?>" alt=""
                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1.5px solid var(--border)" />
              <?php else: ?>
                <div style="width:36px;height:36px;border-radius:50%;background:#ecfdf5;border:1.5px solid #22c55e;display:flex;align-items:center;justify-content:center;font-weight:500;color:#16a34a;font-size:14px;">
                  <?= strtoupper(substr($t['client_name'], 0, 1)) ?>
                </div>
              <?php endif; ?>
              <div>
                <div style="font-weight:500;color:var(--text-primary);font-size:14.5px;"><?= htmlspecialchars($t['client_name']) ?></div>
                <div style="font-size:12px;color:var(--text-muted);"><?= htmlspecialchars($t['client_role'] ?? 'Client') ?></div>
              </div>
            </div>
          </td>
          <td><span class="cms-badge cms-badge-blue"><?= htmlspecialchars($t['country'] ?: 'Global') ?></span></td>
          <td>
            <span style="display:inline-flex;align-items:center;gap:3px;color:#f59e0b;">
              <?php for ($s = 0; $s < (int)$t['rating']; $s++): ?>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <?php endfor; ?>
            </span>
            <span style="color:var(--text-muted);font-size:12.5px;margin-left:4px;font-weight:500"><?= $t['rating'] ?>.0</span>
          </td>
          <td>
            <div class="cms-status-cell">
              <label class="cms-toggle" title="Toggle active status">
                <input type="checkbox" <?= $t['is_active'] ? 'checked' : '' ?>
                       data-table="cms_testimonials" data-id="<?= $t['id'] ?>" data-field="is_active" />
                <span class="cms-toggle-track"></span>
              </label>
              <span class="cms-status-tag <?= $t['is_active'] ? 'active' : 'inactive' ?>">
                <?= $t['is_active'] ? 'Active' : 'Disabled' ?>
              </span>
            </div>
          </td>
          <td style="text-align:right;">
            <div class="cms-table-actions" style="justify-content:flex-end;">
              <button type="button" class="cms-action-icon-btn-sm" onclick='openModal(<?= $t["id"] ?>)' title="Edit Testimonial">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
              </button>
              <button type="button" class="cms-action-icon-btn-sm danger"
                data-confirm="Delete this testimonial?"
                onclick="deleteTestim(<?= $t['id'] ?>, this.closest('tr'))"
                title="Delete Testimonial">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
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

<!-- Modal -->
<div class="cms-modal-backdrop" id="testimModal">
  <div class="cms-modal">
    <div class="cms-modal-header">
      <div class="cms-modal-title" id="testimModalTitle">Add Testimonial</div>
      <button class="cms-modal-close" aria-label="Close">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="cms-modal-body">
      <input type="hidden" id="testim_id" value="0" />
      <div class="cms-input-row">
        <div class="cms-form-group">
          <label class="cms-label">Client Name</label>
          <input type="text" id="testim_name" class="cms-input" placeholder="Priya R." />
        </div>
        <div class="cms-form-group">
          <label class="cms-label">Country / Visa Type</label>
          <input type="text" id="testim_country" class="cms-input" placeholder="Canada PR" />
        </div>
      </div>
      <div class="cms-form-group">
        <label class="cms-label">Client Photo</label>
        <div class="cms-image-upload-wrap">
          <div class="cms-image-preview-box is-avatar" id="box_testim_photo" style="width:48px;height:48px;">
            <img id="prev_testim_photo" src="" alt="Avatar" style="display:none;" />
            <div class="cms-upload-empty" id="empty_testim_photo">No Img</div>
          </div>
          <div class="cms-upload-content" style="flex:1;">
            <div class="cms-upload-actions">
              <label class="cms-upload-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span id="lbl_testim_photo">Upload Photo</span>
                <input type="file" accept="image/*" style="display:none;" onchange="cmsUploadFile(this, 'testim_photo', 'prev_testim_photo')" />
              </label>
              <button type="button" class="cms-remove-img-btn" onclick="cmsRemoveImage('testim_photo', 'prev_testim_photo')">Remove</button>
            </div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Client profile photo (JPG, PNG, WebP)</div>
          </div>
          <input type="hidden" id="testim_photo" class="cms-input" />
        </div>
      </div>
      <div class="cms-form-group">
        <label class="cms-label">Rating (1–5)</label>
        <select id="testim_rating" class="cms-select">
          <?php foreach ([5,4,3,2,1] as $r): ?>
            <option value="<?= $r ?>"><?= $r ?> Stars (<?= $r ?>/5)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="cms-form-group">
        <label class="cms-label">Review Text</label>
        <textarea id="testim_review" class="cms-textarea" placeholder="Write the client's review here…"></textarea>
      </div>
    </div>
    <div class="cms-modal-footer">
      <button class="cms-btn cms-btn-secondary" onclick="Modal.close('testimModal')">Cancel</button>
      <button class="cms-btn cms-btn-primary" onclick="saveTestim()">Save Review</button>
    </div>
  </div>
</div>

<script>
const TESTIM_DATA = <?= json_encode(array_combine(array_column($testimonials,'id'), $testimonials)) ?>;

function openModal(id) {
    document.getElementById('testimModalTitle').textContent = id ? 'Edit Testimonial' : 'Add Testimonial';
    document.getElementById('testim_id').value = id;
    const t = TESTIM_DATA[id] ?? {};
    document.getElementById('testim_name').value    = t.client_name ?? '';
    document.getElementById('testim_country').value = t.country     ?? '';
    const photoUrl = t.photo_url ?? '';
    document.getElementById('testim_photo').value = photoUrl;
    const prev = document.getElementById('prev_testim_photo');
    const empty = document.getElementById('empty_testim_photo');
    const lbl = document.getElementById('lbl_testim_photo');
    if (photoUrl) {
        prev.src = (photoUrl.startsWith('http') || photoUrl.startsWith('/') || photoUrl.startsWith('data:')) ? photoUrl : (window.CMS_SITE_ROOT || '../../') + photoUrl;
        prev.style.display = 'block';
        if (empty) empty.style.display = 'none';
        if (lbl) lbl.textContent = 'Change Photo';
    } else {
        prev.src = '';
        prev.style.display = 'none';
        if (empty) empty.style.display = 'block';
        if (lbl) lbl.textContent = 'Upload Photo';
    }
    document.getElementById('testim_rating').value  = t.rating      ?? 5;
    const reviewVal = t.review_text ?? '';
    document.getElementById('testim_review').value  = reviewVal;
    const editor = window.cmsRichEditors?.get(document.getElementById('testim_review'));
    if (editor) editor.setData(reviewVal);
    Modal.open('testimModal');
}

async function saveTestim() {
    window.cmsSyncEditors?.();
    const data = new FormData();
    data.append('_csrf',       CMS_CSRF);
    data.append('action',      'save_testimonial');
    data.append('id',          document.getElementById('testim_id').value);
    data.append('client_name', document.getElementById('testim_name').value);
    data.append('country',     document.getElementById('testim_country').value);
    data.append('photo_url',   document.getElementById('testim_photo').value);
    data.append('rating',      document.getElementById('testim_rating').value);
    data.append('review_text', document.getElementById('testim_review').value);

    const res  = await fetch('../api/save.php', { method: 'POST', body: data });
    const json = await res.json();
    if (json.ok) { Toast.success('Saved!'); Modal.close('testimModal'); setTimeout(() => location.reload(), 800); }
    else Toast.error(json.error ?? 'Error');
}

async function deleteTestim(id, row) {
    const data = new FormData();
    data.append('_csrf',  CMS_CSRF);
    data.append('action', 'delete');
    data.append('table',  'cms_testimonials');
    data.append('id',     id);
    const res  = await fetch('../api/save.php', { method: 'POST', body: data });
    const json = await res.json();
    if (json.ok) { row?.remove(); Toast.success('Deleted.'); }
    else Toast.error(json.error ?? 'Error');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const tb = document.getElementById('testimTableBody');
if (tb) Sortable.create(tb, { handle: '.cms-drag-handle', animation: 150,
    onEnd: async () => {
        const ids  = [...tb.querySelectorAll('[data-sort-id]')].map(r => r.dataset.sortId);
        const data = new FormData();
        data.append('_csrf', CMS_CSRF); data.append('action','reorder');
        data.append('table','cms_testimonials'); data.append('ids', JSON.stringify(ids));
        await fetch('../api/save.php', { method:'POST', body:data });
        Toast.success('Order updated.');
    }
});
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
