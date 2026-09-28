/* ============================================================
   Visabuz CMS — JavaScript
   AJAX saves, CSRF injection, toast notifications, modals
   ============================================================ */

'use strict';

// ── CSRF ───────────────────────────────────────────────────
const CMS_CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// ── Toast system ───────────────────────────────────────────
const Toast = (() => {
    let container = null;

    function getContainer() {
        if (!container) {
            container = document.createElement('div');
            container.id = 'cms-toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    function show(message, type = 'success', duration = 3200) {
        const el = document.createElement('div');
        el.className = `cms-toast ${type}`;
        const icons = {
            success: '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>',
            error:   '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
            warning: '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
            info:    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
        };
        const icon = icons[type] || icons.info;
        el.innerHTML = `<span class="cms-toast-icon">${icon}</span><span style="font-weight:500">${type === 'success' ? 'Well done!' : (type === 'error' ? 'Oh snap!' : '')}</span> <span>${message}</span>`;
        getContainer().appendChild(el);

        setTimeout(() => {
            el.style.animation = 'toastOut 0.24s ease forwards';
            el.addEventListener('animationend', () => el.remove());
        }, duration);
    }

    return { show, success: m => show(m, 'success'), error: m => show(m, 'error') };
})();

window.Toast = Toast;

// ── AJAX Save Helper ───────────────────────────────────────
/**
 * cms_save(formOrData, url, successMsg)
 * Sends a POST with CSRF token and shows a toast on completion.
 */
async function cms_save(formOrData, url = '../api/save.php', successMsg = 'Changes saved.') {
    window.cmsSyncEditors?.();
    let body;

    if (formOrData instanceof HTMLFormElement) {
        body = new FormData(formOrData);
        body.append('_csrf', CMS_CSRF);
    } else if (formOrData instanceof FormData) {
        body = formOrData;
        body.append('_csrf', CMS_CSRF);
    } else {
        // Plain object
        body = new FormData();
        body.append('_csrf', CMS_CSRF);
        Object.entries(formOrData).forEach(([k, v]) => body.append(k, v));
    }

    try {
        const res  = await fetch(url, { method: 'POST', body });
        const json = await res.json();

        if (json.ok) {
            Toast.success(successMsg);
        } else {
            Toast.error(json.error ?? 'Something went wrong.');
        }

        return json;
    } catch (err) {
        Toast.error('Network error — could not save.');
        console.error(err);
        return { ok: false, error: err.message };
    }
}

window.cms_save = cms_save;

// ── Auto-save forms with [data-autosave] ───────────────────
document.querySelectorAll('form[data-autosave]').forEach(form => {
    form.addEventListener('submit', async e => {
        e.preventDefault();
        window.cmsSyncEditors?.();
        const btn = form.querySelector('[type=submit]');
        if (btn) { btn.disabled = true; btn.textContent = 'Saving…'; }

        const msg = form.dataset.autosave || 'Saved successfully.';
        await cms_save(form, form.action || '../api/save.php', msg);

        if (btn) { btn.disabled = false; btn.textContent = btn.dataset.label ?? 'Save Changes'; }
    });
});

// ── Modal system ───────────────────────────────────────────
const Modal = (() => {
    function open(id)  {
        const el = document.getElementById(id);
        el?.classList.add('open');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            if (el) {
                window.initCmsCKEditors?.(el);
                el.querySelectorAll('textarea').forEach(ta => {
                    const editor = window.cmsRichEditors?.get(ta);
                    if (editor && editor.getData() !== ta.value) {
                        editor.setData(ta.value || '');
                    }
                });
            }
        }, 80);
    }
    function close(id) {
        const el = document.getElementById(id);
        el?.classList.remove('open');
        document.body.style.overflow = '';
    }
    function closeAll() {
        document.querySelectorAll('.cms-modal-backdrop.open')
            .forEach(el => { el.classList.remove('open'); });
        document.body.style.overflow = '';
    }
    return { open, close, closeAll };
})();

window.Modal = Modal;

// Close modal on backdrop click
document.addEventListener('click', e => {
    if (e.target.classList.contains('cms-modal-backdrop')) Modal.closeAll();
    if (e.target.closest('.cms-modal-close')) {
        const backdrop = e.target.closest('.cms-modal-backdrop');
        if (backdrop) backdrop.classList.remove('open'), document.body.style.overflow = '';
    }
});

// ── CKEditor 5 Rich Text Integration ───────────────────────
window.cmsRichEditors = new Map();

function initCmsCKEditors(root = document) {
    if (typeof ClassicEditor === 'undefined') return;

    const textareas = root.querySelectorAll('textarea.cms-textarea, textarea.cms-post-textarea, textarea.cms-rich-editor');

    textareas.forEach(ta => {
        if (window.cmsRichEditors.has(ta)) return;
        if (ta.classList.contains('code-editor-textarea') || ta.dataset.noCkeditor !== undefined) return;
        if (ta.style.display === 'none' || ta.hidden) return;

        ClassicEditor.create(ta, {
            toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        }).then(editor => {
            window.cmsRichEditors.set(ta, editor);

            editor.model.document.on('change:data', () => {
                ta.value = editor.getData();
                ta.dispatchEvent(new Event('input', { bubbles: true }));
                ta.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }).catch(err => {
            console.warn('CKEditor initialization notice:', err);
        });
    });
}

window.initCmsCKEditors = initCmsCKEditors;

window.cmsSyncEditors = function() {
    if (!window.cmsRichEditors) return;
    window.cmsRichEditors.forEach((editor, ta) => {
        try {
            ta.value = editor.getData();
        } catch (e) {}
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => initCmsCKEditors());
} else {
    setTimeout(() => initCmsCKEditors(), 60);
}

// ── Sidebar toggle (desktop minimize to icons, mobile drawer) ─
const menuBtn  = document.getElementById('cms-menu-btn');
const sidebar  = document.querySelector('.cms-sidebar');
const shell    = document.getElementById('cmsShell') || document.querySelector('.cms-shell');

// Restore persisted collapsed state on load
if (localStorage.getItem('cms_sidebar_collapsed') === '1' && window.innerWidth > 1024) {
    shell?.classList.add('sidebar-collapsed');
    document.documentElement.classList.add('sidebar-collapsed');
}

menuBtn?.addEventListener('click', () => {
    if (window.innerWidth > 1024) {
        // Desktop: minimize / maximize sidebar to icons
        const collapsed = shell?.classList.toggle('sidebar-collapsed');
        document.documentElement.classList.toggle('sidebar-collapsed', Boolean(collapsed));
        localStorage.setItem('cms_sidebar_collapsed', collapsed ? '1' : '0');
    } else {
        // Mobile / Tablet: open or close slide-out drawer
        sidebar?.classList.toggle('open');
    }
});

// ── Toggle (active/inactive) buttons ──────────────────────
document.addEventListener('change', async e => {
    const toggle = e.target.closest('.cms-toggle input');
    if (!toggle) return;

    const { table, id, field } = toggle.dataset;
    if (!table || !id) return;

    // Instant UI feedback for sibling status tag
    const statusTag = toggle.closest('.cms-status-cell')?.querySelector('.cms-status-tag');
    if (statusTag) {
        statusTag.textContent = toggle.checked ? 'Active' : 'Disabled';
        statusTag.className   = `cms-status-tag ${toggle.checked ? 'active' : 'inactive'}`;
    }

    const data = new FormData();
    data.append('_csrf',  CMS_CSRF);
    data.append('action', 'toggle');
    data.append('table',  table);
    data.append('id',     id);
    data.append('field',  field ?? 'is_active');
    data.append('value',  toggle.checked ? '1' : '0');

    const res = await fetch('../api/save.php', { method: 'POST', body: data });
    const json = await res.json();
    if (!json.ok) {
        toggle.checked = !toggle.checked;  // revert
        if (statusTag) {
            statusTag.textContent = toggle.checked ? 'Active' : 'Disabled';
            statusTag.className   = `cms-status-tag ${toggle.checked ? 'active' : 'inactive'}`;
        }
        Toast.error('Failed to update status.');
    }
});

// ── Confirm before delete ──────────────────────────────────
document.addEventListener('click', e => {
    const btn = e.target.closest('[data-confirm]');
    if (!btn) return;
    if (!confirm(btn.dataset.confirm)) e.preventDefault();
});

// ── Character counters ─────────────────────────────────────
document.querySelectorAll('[data-maxlength]').forEach(input => {
    const max     = +input.dataset.maxlength;
    const counter = document.createElement('span');
    counter.className = 'text-muted';
    counter.style = 'font-size:11px;float:right;';
    input.parentNode.insertBefore(counter, input.nextSibling);

    function update() {
        const left = max - input.value.length;
        counter.textContent = `${left} chars left`;
        counter.style.color = left < 20 ? 'var(--red)' : 'var(--text-muted)';
    }
    input.addEventListener('input', update);
    update();
});

// ── Drag-to-reorder (SortableJS if available) ──────────────
if (typeof Sortable !== 'undefined') {
    document.querySelectorAll('[data-sortable]').forEach(list => {
        Sortable.create(list, {
            handle: '.cms-drag-handle',
            animation: 150,
            onEnd: async () => {
                const table = list.dataset.sortable;
                const ids   = [...list.querySelectorAll('[data-sort-id]')].map(el => el.dataset.sortId);

                const data = new FormData();
                data.append('_csrf',  CMS_CSRF);
                data.append('action', 'reorder');
                data.append('table',  table);
                data.append('ids',    JSON.stringify(ids));

                await fetch('../api/save.php', { method: 'POST', body: data });
                Toast.success('Order updated.');
            }
        });
    });
}

// ── Dynamic Local Time Greeting ───────────────────────────
(() => {
    const greetingEl = document.getElementById('cmsGreeting') || document.querySelector('.cms-greeting');
    if (!greetingEl) return;
    const hour = new Date().getHours();
    let text = 'Good Evening';
    if (hour >= 5 && hour < 12) {
        text = 'Good Morning';
    } else if (hour >= 12 && hour < 17) {
        text = 'Good Afternoon';
    } else {
        text = 'Good Evening';
    }
    const username = greetingEl.dataset.username || '';
    if (username) {
        greetingEl.textContent = `${text}, ${username}!`;
    }
})();

// ── Global Image Upload & Preview Helper ────────────────────
window.cmsUploadFile = async function (input, targetInputOrId, previewImgOrId, callback) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];

    const targetInput = typeof targetInputOrId === 'string' ? document.getElementById(targetInputOrId) : targetInputOrId;
    const previewImg  = typeof previewImgOrId  === 'string' ? document.getElementById(previewImgOrId)  : previewImgOrId;
    const btnLabel    = input.closest('.cms-upload-btn') || input.parentElement;

    // Instant local preview
    if (previewImg) {
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
            const emptyEl = previewImg.parentElement?.querySelector('.cms-upload-empty');
            if (emptyEl) emptyEl.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    if (btnLabel) {
        btnLabel.classList.add('is-uploading');
    }

    const data = new FormData();
    data.append('_csrf', typeof CMS_CSRF !== 'undefined' ? CMS_CSRF : '');
    data.append('action', 'upload_image');
    data.append('image', file);

    const apiSaveUrl = window.CMS_API_SAVE || '../api/save.php';

    try {
        const res = await fetch(apiSaveUrl, { method: 'POST', body: data });
        const json = await res.json();
        if (json.ok && json.url) {
            if (targetInput) {
                targetInput.value = json.url;
                targetInput.dispatchEvent(new Event('change', { bubbles: true }));
                targetInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
            if (previewImg) {
                const previewSrc = (json.url.startsWith('http') || json.url.startsWith('/') || json.url.startsWith('data:'))
                    ? json.url
                    : (window.CMS_SITE_ROOT || '../../') + json.url;
                previewImg.src = previewSrc;
                previewImg.style.display = 'block';
                const emptyEl = previewImg.parentElement?.querySelector('.cms-upload-empty');
                if (emptyEl) emptyEl.style.display = 'none';
            }
            if (btnLabel) {
                const textSpan = btnLabel.querySelector('span');
                if (textSpan) textSpan.textContent = 'Change Image';
            }
            if (typeof callback === 'function') {
                callback(json);
            }
            Toast.success('Image uploaded successfully!');
        } else {
            Toast.error(json.error || 'Upload failed.');
        }
    } catch (err) {
        console.error(err);
        Toast.error('Network error during upload.');
    } finally {
        if (btnLabel) btnLabel.classList.remove('is-uploading');
        input.value = '';
    }
};

window.cmsRemoveImage = function (targetInputOrId, previewImgOrId, callback) {
    const targetInput = typeof targetInputOrId === 'string' ? document.getElementById(targetInputOrId) : targetInputOrId;
    const previewImg  = typeof previewImgOrId  === 'string' ? document.getElementById(previewImgOrId)  : previewImgOrId;

    if (targetInput) {
        targetInput.value = '';
        targetInput.dispatchEvent(new Event('change', { bubbles: true }));
        targetInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
    if (previewImg) {
        previewImg.src = '';
        previewImg.style.display = 'none';
        const emptyEl = previewImg.parentElement?.querySelector('.cms-upload-empty');
        if (emptyEl) emptyEl.style.display = 'block';
    }
    const wrap = targetInput?.closest('.cms-image-upload-wrap') || previewImg?.closest('.cms-image-upload-wrap');
    if (wrap) {
        const textSpan = wrap.querySelector('.cms-upload-btn span');
        if (textSpan) textSpan.textContent = 'Upload Image';
    }
    if (typeof callback === 'function') {
        callback();
    }
    Toast.info('Image removed.');
};

