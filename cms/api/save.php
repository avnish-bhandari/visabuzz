<?php
/**
 * save.php — Unified CMS POST / AJAX Save Handler
 * Handles all content saves from the CMS pages.
 */

require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';

// Must be logged in
if (!cms_is_logged_in()) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized.']);
    exit;
}

// Verify CSRF
cms_verify_csrf();

header('Content-Type: application/json');

$action = trim($_POST['action'] ?? '');

// ── Helpers ────────────────────────────────────────────────
function respond(bool $ok, string $message = '', array $extra = []): void
{
    echo json_encode(array_merge(['ok' => $ok, $ok ? 'message' : 'error' => $message], $extra));
    exit;
}

function require_post(string ...$keys): array
{
    $values = [];
    foreach ($keys as $key) {
        if (!isset($_POST[$key])) respond(false, "Missing field: $key");
        $values[] = $_POST[$key];
    }
    return $values;
}

// ── Allowed tables whitelist ───────────────────────────────
const ALLOWED_TABLES = [
    'cms_pages', 'cms_destinations', 'cms_destination_features',
    'cms_testimonials', 'cms_nav_links', 'cms_footer_links',
    'cms_destination_sections',
];

function validate_table(string $table): void
{
    if (!in_array($table, ALLOWED_TABLES, true)) {
        respond(false, "Invalid table: $table");
    }
}

// ══════════════════════════════════════════════════════════
// ACTIONS
// ══════════════════════════════════════════════════════════

// Permission check: View-only users cannot perform mutation actions
$allowedSelfActions = ['update_profile', 'change_password'];
if (!in_array($action, $allowedSelfActions, true) && !cms_can_edit()) {
    respond(false, 'Your account has view-only access. You do not have permission to make changes.');
}

// ── 0. Image Upload ────────────────────────────────────────
if ($action === 'upload_image') {
    $fileKey = isset($_FILES['image']) ? 'image' : (isset($_FILES['file']) ? 'file' : '');
    if (!$fileKey || empty($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        respond(false, 'No image file uploaded or upload error.');
    }

    $file = $_FILES[$fileKey];
    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExts, true)) {
        respond(false, 'Invalid image format. Allowed formats: ' . implode(', ', $allowedExts));
    }

    if ($file['size'] > 12 * 1024 * 1024) {
        respond(false, 'File is too large. Maximum size is 12MB.');
    }

    $uploadDir = dirname(dirname(__DIR__)) . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $safeName = substr($safeName, 0, 30);
    $filename = 'img_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . ($safeName ? '_' . $safeName : '') . '.' . $ext;
    $targetPath = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        respond(false, 'Failed to save uploaded image.');
    }

    respond(true, 'Image uploaded successfully.', [
        'url'      => 'uploads/' . $filename,
        'filename' => $filename,
    ]);
}

// ── 1. Upsert a page field ─────────────────────────────────
if ($action === 'save_page_field') {
    [$page_slug, $section_key, $field_key, $field_value] = require_post('page_slug', 'section_key', 'field_key', 'field_value');

    $stmt = $pdo->prepare("
        INSERT INTO cms_pages (page_slug, section_key, field_key, field_value)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE field_value = VALUES(field_value), updated_at = NOW()
    ");
    $stmt->execute([$page_slug, $section_key, $field_key, $field_value]);
    respond(true, 'Field saved.');
}

// ── 2. Save multiple page fields at once ───────────────────
if ($action === 'save_page_fields') {
    [$page_slug, $section_key] = require_post('page_slug', 'section_key');
    $fields = $_POST['fields'] ?? [];

    if (!is_array($fields)) respond(false, 'fields must be an array.');

    $stmt = $pdo->prepare("
        INSERT INTO cms_pages (page_slug, section_key, field_key, field_value)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE field_value = VALUES(field_value), updated_at = NOW()
    ");

    $pdo->beginTransaction();
    try {
        foreach ($fields as $field_key => $field_value) {
            $stmt->execute([$page_slug, $section_key, $field_key, $field_value]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        respond(false, 'Save failed: ' . $e->getMessage());
    }
    respond(true, 'Section saved.');
}

// ── 2b. Save destination section fields ────────────────────
if ($action === 'save_dest_section') {
    [$dest_id, $section_key] = require_post('destination_id', 'section_key');
    $dest_id = (int)$dest_id;
    $fields  = $_POST['fields'] ?? [];

    if ($dest_id <= 0) respond(false, 'Invalid destination ID.');
    if (!is_array($fields)) respond(false, 'fields must be an array.');

    $stmt = $pdo->prepare("
        INSERT INTO cms_destination_sections (destination_id, section_key, field_key, field_value)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE field_value = VALUES(field_value)
    ");

    $pdo->beginTransaction();
    try {
        foreach ($fields as $field_key => $field_value) {
            $stmt->execute([$dest_id, $section_key, $field_key, $field_value]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        respond(false, 'Save failed: ' . $e->getMessage());
    }
    respond(true, 'Destination section saved.');
}

// ── 3. Toggle active/inactive ──────────────────────────────
if ($action === 'toggle') {
    $table = $_POST['table'] ?? '';
    validate_table($table);
    [$id, $value] = require_post('id', 'value');
    $field = preg_replace('/[^a-z_]/', '', $_POST['field'] ?? 'is_active');

    $pdo->prepare("UPDATE `$table` SET `$field` = ? WHERE id = ?")->execute([(int)$value, (int)$id]);
    respond(true, 'Status updated.');
}

// ── 4. Reorder rows ────────────────────────────────────────
if ($action === 'reorder') {
    $table = $_POST['table'] ?? '';
    validate_table($table);
    $ids = json_decode($_POST['ids'] ?? '[]', true);

    if (!is_array($ids)) respond(false, 'ids must be a JSON array.');

    $stmt = $pdo->prepare("UPDATE `$table` SET sort_order = ? WHERE id = ?");
    $pdo->beginTransaction();
    try {
        foreach (array_values($ids) as $order => $id) {
            $stmt->execute([$order, (int)$id]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        respond(false, 'Reorder failed: ' . $e->getMessage());
    }
    respond(true, 'Order saved.');
}

// ── 5. Save / upsert a destination ────────────────────────
if ($action === 'save_destination') {
    $id           = (int)($_POST['id'] ?? 0);
    $country_slug = trim($_POST['country_slug'] ?? '');
    $country_name = trim($_POST['country_name'] ?? '');
    $hero_image   = trim($_POST['hero_image_url'] ?? '');
    $cta_label    = trim($_POST['cta_label'] ?? 'Learn More');
    $cta_url      = trim($_POST['cta_url'] ?? '#');
    $is_active    = (int)($_POST['is_active'] ?? 1);

    if ($country_slug === '' || $country_name === '') respond(false, 'Slug and name are required.');

    if ($id > 0) {
        $pdo->prepare("
            UPDATE cms_destinations
            SET country_slug=?, country_name=?, hero_image_url=?, cta_label=?, cta_url=?, is_active=?
            WHERE id=?
        ")->execute([$country_slug, $country_name, $hero_image, $cta_label, $cta_url, $is_active, $id]);
    } else {
        $maxOrder = $pdo->query("SELECT MAX(sort_order) FROM cms_destinations")->fetchColumn();
        $pdo->prepare("
            INSERT INTO cms_destinations (country_slug, country_name, hero_image_url, cta_label, cta_url, is_active, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ")->execute([$country_slug, $country_name, $hero_image, $cta_label, $cta_url, $is_active, (int)$maxOrder + 1]);
        $id = (int)$pdo->lastInsertId();
    }

    // Save features
    $features = json_decode($_POST['features'] ?? '[]', true);
    if (is_array($features)) {
        $pdo->prepare("DELETE FROM cms_destination_features WHERE destination_id = ?")->execute([$id]);
        $stmt = $pdo->prepare("
            INSERT INTO cms_destination_features (destination_id, icon_type, title, description, sort_order)
            VALUES (?, ?, ?, ?, ?)
        ");
        foreach (array_values($features) as $i => $f) {
            $stmt->execute([$id, $f['icon_type'] ?? 'green', $f['title'] ?? '', $f['description'] ?? '', $i]);
        }
    }

    respond(true, 'Destination saved.', ['id' => $id]);
}

// ── 6. Delete a row ────────────────────────────────────────
if ($action === 'delete') {
    $table = $_POST['table'] ?? '';
    validate_table($table);
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) respond(false, 'Invalid ID.');

    $pdo->prepare("DELETE FROM `$table` WHERE id = ?")->execute([$id]);
    respond(true, 'Deleted.');
}

// ── 7. Save testimonial ────────────────────────────────────
if ($action === 'save_testimonial') {
    $id          = (int)($_POST['id'] ?? 0);
    $client_name = trim($_POST['client_name'] ?? '');
    $photo_url   = trim($_POST['photo_url'] ?? '');
    $rating      = max(1, min(5, (int)($_POST['rating'] ?? 5)));
    $review_text = trim($_POST['review_text'] ?? '');
    $country     = trim($_POST['country'] ?? '');
    $is_active   = (int)($_POST['is_active'] ?? 1);

    if ($client_name === '' || $review_text === '') respond(false, 'Name and review text are required.');

    if ($id > 0) {
        $pdo->prepare("
            UPDATE cms_testimonials
            SET client_name=?, photo_url=?, rating=?, review_text=?, country=?, is_active=?
            WHERE id=?
        ")->execute([$client_name, $photo_url, $rating, $review_text, $country, $is_active, $id]);
    } else {
        $maxOrder = $pdo->query("SELECT MAX(sort_order) FROM cms_testimonials")->fetchColumn();
        $pdo->prepare("
            INSERT INTO cms_testimonials (client_name, photo_url, rating, review_text, country, is_active, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ")->execute([$client_name, $photo_url, $rating, $review_text, $country, $is_active, (int)$maxOrder + 1]);
    }

    respond(true, 'Testimonial saved.');
}

// ── 8. Save nav link ───────────────────────────────────────
if ($action === 'save_nav_link') {
    $id     = (int)($_POST['id'] ?? 0);
    $label  = trim($_POST['label'] ?? '');
    $url    = trim($_POST['url'] ?? '');
    $is_cta = (int)($_POST['is_cta'] ?? 0);

    if ($label === '' || $url === '') respond(false, 'Label and URL are required.');

    if ($id > 0) {
        $pdo->prepare("UPDATE cms_nav_links SET label=?, url=?, is_cta=? WHERE id=?")
            ->execute([$label, $url, $is_cta, $id]);
    } else {
        $max = $pdo->query("SELECT MAX(sort_order) FROM cms_nav_links")->fetchColumn();
        $pdo->prepare("INSERT INTO cms_nav_links (label, url, is_cta, sort_order) VALUES (?, ?, ?, ?)")
            ->execute([$label, $url, $is_cta, (int)$max + 1]);
    }
    respond(true, 'Nav link saved.');
}

// ── 9. Save footer link ────────────────────────────────────
if ($action === 'save_footer_link') {
    $id         = (int)($_POST['id'] ?? 0);
    $column_key = trim($_POST['column_key'] ?? '');
    $label      = trim($_POST['label'] ?? '');
    $url        = trim($_POST['url'] ?? '#');

    if ($label === '') respond(false, 'Label is required.');

    if ($id > 0) {
        $pdo->prepare("UPDATE cms_footer_links SET column_key=?, label=?, url=? WHERE id=?")
            ->execute([$column_key, $label, $url, $id]);
    } else {
        $max = $pdo->query("SELECT MAX(sort_order) FROM cms_footer_links")->fetchColumn();
        $pdo->prepare("INSERT INTO cms_footer_links (column_key, label, url, sort_order) VALUES (?, ?, ?, ?)")
            ->execute([$column_key, $label, $url, (int)$max + 1]);
    }
    respond(true, 'Footer link saved.');
}

// ── 10. Update Profile ─────────────────────────────────────
if ($action === 'update_profile') {
    $userId = (int)($_SESSION['cms_user_id'] ?? 1);

    // Auto-ensure columns exist in cms_users
    $existingCols = $pdo->query("SHOW COLUMNS FROM cms_users")->fetchAll(PDO::FETCH_COLUMN);
    $profileCols = [
        'full_name'   => "VARCHAR(120) NULL DEFAULT 'Rosa Dodson'",
        'email'       => "VARCHAR(150) NULL DEFAULT 'admin@visabuz.com'",
        'phone'       => "VARCHAR(60) NULL DEFAULT '+91 23456 78910'",
        'position'    => "VARCHAR(120) NULL DEFAULT 'Full Stack Developer'",
        'education'   => "VARCHAR(120) NULL DEFAULT 'Stanford University'",
        'languages'   => "VARCHAR(150) NULL DEFAULT 'English, French, Spanish'",
        'bio'         => "TEXT NULL",
        'avatar_url'  => "VARCHAR(255) NULL DEFAULT ''",
        'birth_date'  => "VARCHAR(60) NULL DEFAULT '06 June 1989'",
        'skills'      => "VARCHAR(255) NULL DEFAULT 'Javascript, Python, Angular, Reactjs, Flutter'"
    ];
    foreach ($profileCols as $col => $colDef) {
        if (!in_array($col, $existingCols, true)) {
            $pdo->exec("ALTER TABLE cms_users ADD COLUMN `$col` $colDef");
        }
    }

    $fullName   = trim($_POST['full_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $position   = trim($_POST['position'] ?? '');
    $education  = trim($_POST['education'] ?? '');
    $languages  = trim($_POST['languages'] ?? '');
    $bio        = trim($_POST['bio'] ?? '');
    $skills     = trim($_POST['skills'] ?? '');
    $birthDate  = trim($_POST['birth_date'] ?? '');
    $avatarUrl  = trim($_POST['avatar_url'] ?? '');

    $stmt = $pdo->prepare("
        UPDATE cms_users SET
            full_name = ?, email = ?, phone = ?, position = ?,
            education = ?, languages = ?, bio = ?, skills = ?,
            birth_date = ?, avatar_url = ?
        WHERE id = ?
    ");
    $stmt->execute([
        $fullName, $email, $phone, $position,
        $education, $languages, $bio, $skills,
        $birthDate, $avatarUrl, $userId
    ]);

    respond(true, 'Profile updated successfully.');
}

// ── 11. Change Password ────────────────────────────────────
if ($action === 'change_password') {
    $userId       = (int)($_SESSION['cms_user_id'] ?? 1);
    $currentPass  = $_POST['current_password'] ?? '';
    $newPass      = $_POST['new_password'] ?? '';
    $confirmPass  = $_POST['confirm_password'] ?? '';

    if ($newPass === '' || strlen($newPass) < 6) {
        respond(false, 'New password must be at least 6 characters.');
    }
    if ($newPass !== $confirmPass) {
        respond(false, 'New password and confirmation do not match.');
    }

    $stmt = $pdo->prepare("SELECT password_hash FROM cms_users WHERE id = ?");
    $stmt->execute([$userId]);
    $hash = $stmt->fetchColumn();

    if (!$hash || !password_verify($currentPass, $hash)) {
        respond(false, 'Current password is incorrect.');
    }

    $newHash = password_hash($newPass, PASSWORD_BCRYPT);
    $pdo->prepare("UPDATE cms_users SET password_hash = ? WHERE id = ?")->execute([$newHash, $userId]);
    respond(true, 'Password changed successfully.');
}

// ── 12. Save User Permissions (Admin Only) ─────────────────
if ($action === 'save_user_permissions') {
    if (!cms_is_admin()) {
        respond(false, 'Unauthorized. Only Administrator can manage user permissions.');
    }

    $targetUserId = (int)($_POST['user_id'] ?? 0);
    if ($targetUserId <= 0) respond(false, 'Invalid user ID.');

    // Fetch target user
    $stmt = $pdo->prepare("SELECT id, role FROM cms_users WHERE id = ?");
    $stmt->execute([$targetUserId]);
    $targetUser = $stmt->fetch();
    if (!$targetUser) respond(false, 'User not found.');

    // If target is primary admin (id 1), keep admin privileges
    if ($targetUserId === 1) {
        $pdo->prepare("UPDATE cms_users SET role = 'admin', permissions = '[\"*\"]', can_edit = 1, status = 'active' WHERE id = 1")->execute();
        respond(true, 'Admin privileges preserved.');
    }

    $rawPerms = json_decode($_POST['permissions'] ?? '[]', true);
    if (!is_array($rawPerms)) $rawPerms = ['dashboard'];

    $canEdit = !empty($_POST['can_edit']) ? 1 : 0;
    $status  = ($_POST['status'] ?? 'active') === 'disabled' ? 'disabled' : 'active';
    $role    = ($_POST['role'] ?? 'user') === 'admin' ? 'admin' : 'user';

    // If promoted to admin, give full wildcard access
    if ($role === 'admin') {
        $rawPerms = ['*'];
        $canEdit = 1;
    }

    $permsJson = json_encode(array_values(array_unique($rawPerms)));

    $stmt = $pdo->prepare("
        UPDATE cms_users 
        SET role = ?, permissions = ?, can_edit = ?, status = ?
        WHERE id = ?
    ");
    $stmt->execute([$role, $permsJson, $canEdit, $status, $targetUserId]);

    respond(true, 'User permissions updated successfully.');
}

// ── 13. Add / Invite Member (Admin Only) ────────────────────
if ($action === 'add_user') {
    if (!cms_is_admin()) {
        respond(false, 'Unauthorized. Only Administrator can invite users.');
    }

    $email    = strtolower(trim($_POST['email'] ?? ''));
    $fullName = trim($_POST['full_name'] ?? '');
    $role     = ($_POST['role'] ?? 'user') === 'admin' ? 'admin' : 'user';
    $position = trim($_POST['position'] ?? 'Team Member');
    $canEdit  = !empty($_POST['can_edit']) ? 1 : 0;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond(false, 'Please provide a valid email address.');
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM cms_users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        respond(false, "A user with email $email already exists.");
    }

    if (!$fullName) {
        $fullName = ucwords(str_replace(['.', '_', '-'], ' ', strstr($email, '@', true) ?: 'Team Member'));
    }

    $baseUsername = strtolower(preg_replace('/[^a-z0-9_]/i', '', strstr($email, '@', true) ?: 'user'));
    // Ensure unique username
    $username = $baseUsername;
    $idx = 1;
    while ($pdo->query("SELECT id FROM cms_users WHERE username = '$username'")->fetch()) {
        $username = $baseUsername . $idx++;
    }

    $rawPerms = json_decode($_POST['permissions'] ?? '["dashboard"]', true);
    if ($role === 'admin') $rawPerms = ['*'];
    $permsJson = json_encode(array_values(array_unique((array)$rawPerms)));

    $stmt = $pdo->prepare("
        INSERT INTO cms_users (username, password_hash, full_name, email, role, permissions, can_edit, status, position)
        VALUES (?, '', ?, ?, ?, ?, ?, 'active', ?)
    ");
    $stmt->execute([$username, $fullName, $email, $role, $permsJson, $canEdit, $position]);

    respond(true, "Team member $fullName ($email) added successfully.", ['user_id' => $pdo->lastInsertId()]);
}

// ── 14. Delete Member (Admin Only) ──────────────────────────
if ($action === 'delete_user') {
    if (!cms_is_admin()) {
        respond(false, 'Unauthorized. Only Administrator can delete users.');
    }

    $targetUserId = (int)($_POST['user_id'] ?? 0);
    if ($targetUserId <= 1) {
        respond(false, 'Cannot delete the primary Administrator account.');
    }

    $pdo->prepare("DELETE FROM cms_users WHERE id = ?")->execute([$targetUserId]);
    respond(true, 'User deleted successfully.');
}

// ── Unknown action ─────────────────────────────────────────
respond(false, "Unknown action: $action");

