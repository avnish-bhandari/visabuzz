<?php
/**
 * auth.php — Session Authentication Helper
 * Include at the top of every protected CMS page.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_name($_ENV['ADMIN_SESSION_NAME'] ?? 'visabuz_cms_admin');
    session_start();
}

function cms_is_logged_in(): bool
{
    return !empty($_SESSION['cms_user_id']);
}

function cms_require_auth(): void
{
    if (!cms_is_logged_in()) {
        header('Location: ' . cms_base_url() . '/login.php');
        exit;
    }
}

function cms_current_user(): array
{
    return [
        'id'          => $_SESSION['cms_user_id']     ?? null,
        'username'    => $_SESSION['cms_username']    ?? 'Admin',
        'full_name'   => $_SESSION['cms_full_name']   ?? ($_SESSION['cms_username'] ?? 'Admin'),
        'role'        => $_SESSION['cms_role']        ?? 'admin',
        'permissions' => $_SESSION['cms_permissions'] ?? ['*'],
        'can_edit'    => (bool)($_SESSION['cms_can_edit'] ?? true),
    ];
}

function cms_is_admin(): bool
{
    $u = cms_current_user();
    return ($u['role'] === 'admin' || in_array('*', (array)$u['permissions'], true));
}

function cms_can_edit(): bool
{
    if (cms_is_admin()) return true;
    return (bool)($_SESSION['cms_can_edit'] ?? false);
}

function cms_has_permission(string $slug): bool
{
    if (cms_is_admin()) return true;
    if ($slug === 'profile') return true; // All authenticated users can access their profile
    $perms = (array)($_SESSION['cms_permissions'] ?? []);
    return in_array($slug, $perms, true);
}

function cms_require_permission(string $slug): void
{
    cms_require_auth();
    if (!cms_has_permission($slug)) {
        http_response_code(403);
        $pageTitle = 'Access Denied';
        $cmsRoot = str_repeat('../', max(substr_count($_SERVER['PHP_SELF'], '/') - 3, 0));
        require_once __DIR__ . '/header.php';
        ?>
        <div class="cms-card" style="text-align:center;padding:56px 24px;margin-top:16px;">
          <div style="width:68px;height:68px;border-radius:50%;background:#fee2e2;color:#dc2626;display:inline-flex;align-items:center;justify-content:center;margin-bottom:18px;">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>
          <h2 style="font-size:22px;font-weight:500;color:var(--text-primary);margin-bottom:8px;">Access Restricted</h2>
          <p style="font-size:15px;color:var(--text-secondary);max-width:480px;margin:0 auto 24px auto;line-height:1.6;">
            You do not have permission to view or manage this section. Please contact the Administrator to request access to this tab.
          </p>
          <a href="<?= $cmsRoot ?>index.php" class="cms-btn cms-btn-primary">Return to Dashboard</a>
        </div>
        <?php
        require_once __DIR__ . '/footer.php';
        exit;
    }
}

function cms_base_url(): string
{
    $appUrl = $_ENV['CMS_URL'] ?? '';
    if ($appUrl) return rtrim($appUrl, '/');

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $dir    = dirname($_SERVER['SCRIPT_NAME']);
    return $scheme . '://' . $host . rtrim($dir, '/');
}

/**
 * Generate or retrieve a CSRF token for the current session.
 */
function cms_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate the CSRF token from a POST request.
 */
function cms_verify_csrf(): void
{
    $token = $_POST['_csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die(json_encode(['ok' => false, 'error' => 'Invalid CSRF token.']));
    }
}
