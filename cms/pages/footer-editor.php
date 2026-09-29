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

<!-- Footer Editor Header & Section Tabs Bar -->
<div class="dest-header-card">
  <!-- Header Top -->
  <div class="dest-header-bar">
    <div class="dest-header-title">
      <span class="dest-header-flag">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#193822" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      </span>
      <div class="dest-header-text">
        <span class="dest-header-kicker">Global Footer Management</span>
        <div class="dest-header-heading">
          <strong>Footer Sections & Links</strong>
          <span class="cms-badge cms-badge-accent">page_slug=global</span>
          <span class="dest-section-count">3 Sections</span>
        </div>
      </div>
    </div>
    <div class="dest-header-actions">
      <a href="../../index.php#footer" target="_blank" class="cms-btn cms-btn-secondary dest-preview-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        <span>Preview Live Footer</span>
      </a>
    </div>
  </div>

  <!-- Navigation Underline Tabs with Left/Right Scroll Controls -->
  <div class="dest-tabs-bar-outer">
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-prev" id="footerTabsPrev" onclick="cmsScrollTabs('footerTabsWrap', -1)" aria-label="Scroll tabs left" title="Scroll left">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <div class="dest-tabs-wrap" id="footerTabsWrap">
      <ul class="dest-nav-tabs" role="tablist">
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn active" data-sec="contact" onclick="switchFooterTab('contact', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span class="dest-tab-label">1. Contact & Office Info</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="services" onclick="switchFooterTab('services', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span class="dest-tab-label">2. Visa Services Links</span>
          </button>
        </li>
        <li class="dest-tab-item">
          <button type="button" class="dest-tab-btn" data-sec="countries" onclick="switchFooterTab('countries', this)">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
            <span class="dest-tab-label">3. Top Countries Links</span>
          </button>
        </li>
        <li class="dest-tab-item dest-tab-item-all">
          <button type="button" class="dest-tab-btn dest-tab-btn-all" data-sec="all" onclick="switchFooterTab('all', this)" title="Show all sections together">
            <svg class="dest-tab-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            <span class="dest-tab-label">All Sections</span>
          </button>
        </li>
      </ul>
    </div>
    <button type="button" class="dest-tabs-nav-btn dest-tabs-nav-next" id="footerTabsNext" onclick="cmsScrollTabs('footerTabsWrap', 1)" aria-label="Scroll tabs right" title="Scroll right">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  </div>
</div>

<!-- 1. Contact Info -->
<div class="cms-card cms-footer-section" id="sec-contact">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        1. Contact & Office Info
      </div>
      <div class="cms-card-subtitle">Shown in the footer contact column</div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="saveContact(this)">Save Contact</button>
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

<!-- Visa Services & Top Countries Links -->
<?php
$footerCols = [
    'services' => [
        'num'   => '2',
        'title' => 'Visa Services Links',
        'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'
    ],
    'countries' => [
        'num'   => '3',
        'title' => 'Top Countries Links',
        'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>'
    ]
];
foreach ($footerCols as $col => $colInfo): ?>
<div class="cms-card cms-footer-section" id="sec-<?= $col ?>">
  <div class="cms-card-header">
    <div>
      <div class="cms-card-title"><?= $colInfo['icon'] ?> <?= $colInfo['num'] ?>. <?= htmlspecialchars($colInfo['title']) ?></div>
    </div>
    <button type="button" class="cms-btn cms-btn-primary" onclick="openFooterModal(0,'<?= $col ?>')">+ Add Link</button>
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

// ── Footer Tabs Switcher & State ─────────────────────────────
function cmsScrollTabs(wrapOrId, dir) {
    const wrap = typeof wrapOrId === 'string' ? document.getElementById(wrapOrId) : wrapOrId;
    if (!wrap) return;
    const amount = (dir || 1) * 280;
    wrap.scrollLeft += amount;
}
window.cmsScrollTabs = cmsScrollTabs;

function switchFooterTab(secName, btn) {
    document.querySelectorAll('#footerTabsWrap .dest-tab-btn').forEach(b => b.classList.remove('active'));
    const activeBtn = btn || document.querySelector(`#footerTabsWrap .dest-tab-btn[data-sec="${secName}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
        if (typeof activeBtn.scrollIntoView === 'function') {
            activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
        }
    }

    const sections = ['contact', 'services', 'countries'];
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

// ── Tab ScrollSpy in "All Sections" Mode ──────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const sections = ['sec-contact', 'sec-services', 'sec-countries'].map(id => document.getElementById(id)).filter(Boolean);
    window.addEventListener('scroll', () => {
        const allBtn = document.querySelector('#footerTabsWrap .dest-tab-btn[data-sec="all"]');
        if (!allBtn || !allBtn.classList.contains('active')) return;

        const scrollPos = window.scrollY + 130;
        let currentSec = sections[0];
        for (const sec of sections) {
            if (sec.offsetTop <= scrollPos) currentSec = sec;
        }
        if (currentSec) {
            const secKey = currentSec.id.replace('sec-', '');
            document.querySelectorAll('#footerTabsWrap .dest-tab-btn').forEach(b => {
                b.classList.toggle('is-scrolled-active', b.dataset.sec === secKey);
            });
        }
    }, { passive: true });

    // Handle deep-link
    const hash = (window.location.hash || '').replace('#sec-', '').replace('#', '');
    const valid = ['contact', 'services', 'countries', 'all'];
    const initialSec = valid.includes(hash) ? hash : 'contact';
    const targetBtn = document.querySelector(`#footerTabsWrap .dest-tab-btn[data-sec="${initialSec}"]`);
    if (targetBtn) {
        switchFooterTab(initialSec, targetBtn);
    }
});

// ── Save Contact Handler with Feedback ───────────────────────
async function saveContact(btn) {
    const origBtnHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.classList.add('is-saving');
        btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cms-spin"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> <span>Saving...</span>';
    }

    const data = new FormData();
    data.append('_csrf',        CMS_CSRF);
    data.append('action',       'save_page_fields');
    data.append('page_slug',    'global');
    data.append('section_key',  'footer');
    ['phone','email','office1','office2','copy'].forEach(f => {
        data.append(`fields[${f}]`, document.getElementById(`footer_${f}`).value);
    });

    try {
        const res  = await fetch('../api/save.php', { method:'POST', body:data });
        const json = await res.json();
        if (json.ok) {
            Toast.success('Contact info saved successfully!');
            if (btn) {
                btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> <span>Saved!</span>';
                setTimeout(() => {
                    btn.disabled = false;
                    btn.classList.remove('is-saving');
                    btn.innerHTML = origBtnHtml;
                }, 1400);
            }
        } else {
            Toast.error(json.error ?? 'Save failed');
            if (btn) {
                btn.disabled = false;
                btn.classList.remove('is-saving');
                btn.innerHTML = origBtnHtml;
            }
        }
    } catch (e) {
        Toast.error('Network error during save');
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('is-saving');
            btn.innerHTML = origBtnHtml;
        }
    }
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
