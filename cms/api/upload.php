<?php
/**
 * upload.php — CMS Image Upload Endpoint
 * Handles file uploads from CMS pages and saves into /uploads directory.
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';

header('Content-Type: application/json');

if (!cms_is_logged_in()) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized.']);
    exit;
}

cms_verify_csrf();

if (!cms_can_edit()) {
    echo json_encode(['ok' => false, 'error' => 'View-only users cannot upload files.']);
    exit;
}

$fileKey = isset($_FILES['image']) ? 'image' : (isset($_FILES['file']) ? 'file' : '');

if (!$fileKey || empty($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['ok' => false, 'error' => 'No image uploaded or upload error.']);
    exit;
}

$file = $_FILES[$fileKey];
$allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowedExts, true)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid file format. Allowed: ' . implode(', ', $allowedExts)]);
    exit;
}

if ($file['size'] > 12 * 1024 * 1024) {
    echo json_encode(['ok' => false, 'error' => 'File size exceeds 12MB limit.']);
    exit;
}

// Determine subfolder inside cms/uploads
$folder = trim($_POST['folder'] ?? $_GET['folder'] ?? '');
if (!$folder) {
    $page = trim($_POST['page_slug'] ?? $_POST['page'] ?? '');
    if ($page === 'home' || $page === '') {
        $folder = 'home page';
    } else {
        $folder = $page;
    }
}

// Sanitize folder name (allow alphanumeric, spaces, dashes, underscores)
$folder = str_replace(['..', '\\', '/', "\0"], '', $folder);
$folder = trim(preg_replace('/[^\w\s\.-]/u', '', $folder));
if ($folder === '') {
    $folder = 'home page';
}

$baseUploadDir = dirname(__DIR__) . '/uploads';
$uploadDir = $baseUploadDir . '/' . $folder;
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
$safeName = substr($safeName, 0, 30);
$filename = 'img_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . ($safeName ? '_' . $safeName : '') . '.' . $ext;
$targetPath = $uploadDir . '/' . $filename;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['ok' => false, 'error' => 'Failed to save uploaded image.']);
    exit;
}

$relativeUrl = 'cms/uploads/' . $folder . '/' . $filename;

echo json_encode([
    'ok'       => true,
    'message'  => 'Image uploaded successfully.',
    'url'      => $relativeUrl,
    'filename' => $filename,
    'folder'   => $folder,
]);
exit;
