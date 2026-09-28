<?php
/**
 * db.php — Database Connection
 * Parses the .env file once and returns a shared PDO instance.
 * Include this file anywhere you need DB access: require_once __DIR__ . '/../config/db.php';
 */

if (!function_exists('cms_load_env')) {

    function cms_load_env(string $path): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException(".env file not found at: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comment lines
            if (str_starts_with(trim($line), '#')) continue;

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key   = trim($key);
                $value = trim($value);

                // Strip surrounding quotes if present
                if (preg_match('/^"(.*)"$/', $value, $m) || preg_match("/^'(.*)'$/", $value, $m)) {
                    $value = $m[1];
                }

                if (!array_key_exists($key, $_ENV)) {
                    $_ENV[$key]       = $value;
                    putenv("$key=$value");
                }
            }
        }
    }

}

// Load .env once (guard against double-loading)
if (empty($_ENV['DB_HOST'])) {
    cms_load_env(dirname(__DIR__) . '/.env');
}

// Set application timezone
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Kolkata');

// ---------------------------------------------------------------------------
// Shared PDO instance (singleton pattern via static variable)
// ---------------------------------------------------------------------------
function cms_pdo(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $hostRaw = $_ENV['DB_HOST']    ?? 'localhost';
        $dbname  = $_ENV['DB_NAME']    ?? 'visabuz_cms';
        $user    = $_ENV['DB_USER']    ?? 'root';
        $pass    = $_ENV['DB_PASS']    ?? '';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        // Support host:port format (e.g. 127.0.0.1:3307)
        if (str_contains($hostRaw, ':')) {
            [$host, $port] = explode(':', $hostRaw, 2);
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
        } else {
            $dsn = "mysql:host=$hostRaw;dbname=$dbname;charset=$charset";
        }

        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);

        cms_ensure_schema($pdo);
    }

    return $pdo;
}

function cms_ensure_schema(PDO $pdo): void
{
    static $ensured = false;
    if ($ensured) return;
    $ensured = true;

    try {
        $existingCols = $pdo->query("DESCRIBE cms_users")->fetchAll(PDO::FETCH_COLUMN);
        $newCols = [
            'full_name'   => "VARCHAR(120) DEFAULT 'Admin'",
            'email'       => "VARCHAR(180) DEFAULT 'admin@visabuz.com'",
            'phone'       => "VARCHAR(50) DEFAULT '+91 23456 78910'",
            'position'    => "VARCHAR(100) DEFAULT 'Super Administrator'",
            'education'   => "VARCHAR(150) DEFAULT 'Stanford Univercity'",
            'languages'   => "VARCHAR(150) DEFAULT 'English, French, Spanish'",
            'bio'         => "TEXT NULL",
            'skills'      => "VARCHAR(255) DEFAULT 'Leadership, Management, Visa Consulting'",
            'birth_date'  => "VARCHAR(50) DEFAULT '06 June 1989'",
            'avatar_url'  => "VARCHAR(255) DEFAULT 'assets/profile_avatar.jpg'",
            'role'        => "VARCHAR(20) DEFAULT 'user'",
            'permissions' => "TEXT NULL",
            'can_edit'    => "TINYINT(1) DEFAULT 1",
            'status'      => "VARCHAR(20) DEFAULT 'active'",
        ];

        foreach ($newCols as $col => $colDef) {
            if (!in_array($col, $existingCols, true)) {
                $pdo->exec("ALTER TABLE cms_users ADD COLUMN `$col` $colDef");
            }
        }

        // Ensure Admin user has full access and name 'Admin'
        $pdo->exec("
            UPDATE cms_users 
            SET username = 'admin', full_name = 'Admin', role = 'admin', position = 'Super Administrator', permissions = '[\"*\"]', can_edit = 1, status = 'active'
            WHERE id = 1 OR username = 'admin'
        ");

        // Ensure cms_otps table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS cms_otps (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(180) NOT NULL,
                otp_code VARCHAR(10) NOT NULL,
                expires_at DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX(email),
                INDEX(expires_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
    } catch (Exception $e) {
        // Schema check non-blocking
    }
}

// Convenience alias — makes code reads cleanly: $pdo = cms_pdo();
$pdo = cms_pdo();

