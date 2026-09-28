<?php
/**
 * setup.php — One-time database installer
 * Visit: http://localhost/Personal/visabuz/cms/setup.php
 * DELETE THIS FILE after running it.
 */

define('SETUP_KEY', 'visabuz-setup-2026'); // Change or remove after use

// Simple key-based protection
if (($_GET['key'] ?? '') !== SETUP_KEY) {
    http_response_code(403);
    die('403 Forbidden — append ?key=visabuz-setup-2026 to run setup.');
}

require_once __DIR__ . '/config/db.php';

$errors   = [];
$success  = [];

// ---------------------------------------------------------------------------
// 1. Create database (if not exists) — connect without dbname first
// ---------------------------------------------------------------------------
try {
    $host    = $_ENV['DB_HOST']    ?? 'localhost';
    $user    = $_ENV['DB_USER']    ?? 'root';
    $pass    = $_ENV['DB_PASS']    ?? '';
    $dbname  = $_ENV['DB_NAME']    ?? 'visabuz_cms';
    $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

    $rootPdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $success[] = "Database `$dbname` ready.";
} catch (Exception $e) {
    $errors[] = 'DB create failed: ' . $e->getMessage();
}

// ---------------------------------------------------------------------------
// 2. Create tables
// ---------------------------------------------------------------------------
$tables = [

    'cms_users' => "
        CREATE TABLE IF NOT EXISTS `cms_users` (
            `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `username`     VARCHAR(80)  NOT NULL UNIQUE,
            `password_hash` VARCHAR(255) NOT NULL,
            `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    'cms_pages' => "
        CREATE TABLE IF NOT EXISTS `cms_pages` (
            `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `page_slug`    VARCHAR(80)  NOT NULL,
            `section_key`  VARCHAR(120) NOT NULL,
            `field_key`    VARCHAR(120) NOT NULL,
            `field_value`  TEXT         NOT NULL,
            `updated_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_field` (`page_slug`, `section_key`, `field_key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    'cms_destinations' => "
        CREATE TABLE IF NOT EXISTS `cms_destinations` (
            `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `country_slug`   VARCHAR(80)  NOT NULL UNIQUE,
            `country_name`   VARCHAR(120) NOT NULL,
            `hero_image_url` TEXT,
            `cta_label`      VARCHAR(120) DEFAULT 'Learn More',
            `cta_url`        VARCHAR(255) DEFAULT '#',
            `sort_order`     INT          NOT NULL DEFAULT 0,
            `is_active`      TINYINT(1)   NOT NULL DEFAULT 1,
            `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    'cms_destination_features' => "
        CREATE TABLE IF NOT EXISTS `cms_destination_features` (
            `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `destination_id` INT UNSIGNED NOT NULL,
            `icon_type`      VARCHAR(50)  NOT NULL DEFAULT 'green',
            `title`          VARCHAR(255) NOT NULL,
            `description`    TEXT         NOT NULL,
            `sort_order`     INT          NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`destination_id`) REFERENCES `cms_destinations`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    'cms_testimonials' => "
        CREATE TABLE IF NOT EXISTS `cms_testimonials` (
            `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `client_name` VARCHAR(120) NOT NULL,
            `photo_url`   TEXT,
            `rating`      TINYINT      NOT NULL DEFAULT 5,
            `review_text` TEXT         NOT NULL,
            `country`     VARCHAR(100) DEFAULT '',
            `is_active`   TINYINT(1)   NOT NULL DEFAULT 1,
            `sort_order`  INT          NOT NULL DEFAULT 0,
            `updated_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    'cms_nav_links' => "
        CREATE TABLE IF NOT EXISTS `cms_nav_links` (
            `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `label`     VARCHAR(80)  NOT NULL,
            `url`       VARCHAR(255) NOT NULL,
            `is_cta`    TINYINT(1)   NOT NULL DEFAULT 0,
            `sort_order` INT         NOT NULL DEFAULT 0,
            `is_active` TINYINT(1)   NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    'cms_footer_links' => "
        CREATE TABLE IF NOT EXISTS `cms_footer_links` (
            `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `column_key` VARCHAR(50)  NOT NULL,
            `label`      VARCHAR(120) NOT NULL,
            `url`        VARCHAR(255) NOT NULL DEFAULT '#',
            `sort_order` INT          NOT NULL DEFAULT 0,
            `is_active`  TINYINT(1)   NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

];

foreach ($tables as $name => $sql) {
    try {
        $pdo->exec($sql);
        $success[] = "Table `$name` created (or already exists).";
    } catch (Exception $e) {
        $errors[] = "Table `$name` failed: " . $e->getMessage();
    }
}

// ---------------------------------------------------------------------------
// 3. Seed admin user (password: visabuz2026)
// ---------------------------------------------------------------------------
try {
    $stmt = $pdo->prepare("SELECT id FROM cms_users WHERE username = 'admin' LIMIT 1");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $hash = password_hash('visabuz2026', PASSWORD_BCRYPT);
        $pdo->prepare("INSERT INTO cms_users (username, password_hash) VALUES ('admin', ?)")
            ->execute([$hash]);
        $success[] = "Admin user seeded — username: <strong>admin</strong>, password: <strong>visabuz2026</strong>. Change after first login.";
    } else {
        $success[] = "Admin user already exists — skipped.";
    }
} catch (Exception $e) {
    $errors[] = 'Admin seed failed: ' . $e->getMessage();
}

// ---------------------------------------------------------------------------
// 4. Seed default nav links
// ---------------------------------------------------------------------------
try {
    $count = $pdo->query("SELECT COUNT(*) FROM cms_nav_links")->fetchColumn();
    if ($count == 0) {
        $navLinks = [
            ['Home',               '#hero',          0, 0],
            ['About Us',           '#about',         0, 1],
            ['Visa Services',      '#feature-tabs',  0, 2],
            ['Destinations',       '#destinations',  0, 3],
            ['How It Works',       '#how-it-works',  0, 4],
            ['Book Consultation',  '#book',          1, 5],
        ];
        $stmt = $pdo->prepare("INSERT INTO cms_nav_links (label, url, is_cta, sort_order) VALUES (?, ?, ?, ?)");
        foreach ($navLinks as $link) {
            $stmt->execute($link);
        }
        $success[] = "Default nav links seeded.";
    } else {
        $success[] = "Nav links already seeded — skipped.";
    }
} catch (Exception $e) {
    $errors[] = 'Nav seed failed: ' . $e->getMessage();
}

// ---------------------------------------------------------------------------
// 5. Seed default destinations
// ---------------------------------------------------------------------------
try {
    $count = $pdo->query("SELECT COUNT(*) FROM cms_destinations")->fetchColumn();
    if ($count == 0) {
        $destinations = [
            ['uk',      'Study in UK',      'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=900&q=80', 'Explore UK Programs',   'study-global.php?country=uk', 0],
            ['usa',     'Study in USA',     'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=900&q=80', 'Explore US Programs',   '#book',         1],
            ['ireland', 'Study in Ireland', 'https://images.unsplash.com/photo-1590089415032-5fdcc8ef7f69?auto=format&fit=crop&w=900&q=80', 'Explore Ireland',       '#book',         2],
            ['canada',  'Study in Canada',  'https://images.unsplash.com/photo-1609010905180-64f8fad7a3f0?auto=format&fit=crop&w=900&q=80', 'Explore Canada',        '#book',         3],
            ['germany', 'Study in Germany', 'https://images.unsplash.com/photo-1449468512861-1a67a1bef05d?auto=format&fit=crop&w=900&q=80', 'Explore Germany',       '#book',         4],
            ['dubai',   'Study in Dubai',   'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=900&q=80', 'Explore Dubai',         '#book',         5],
            ['france',  'Study in France',  'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=900&q=80', 'Explore France',        '#book',         6],
            ['europe',  'Study in Europe',  'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=900&q=80', 'Explore Europe',        '#book',         7],
            ['italy',   'Study in Italy',   'https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?auto=format&fit=crop&w=900&q=80', 'Explore Italy',         '#book',         8],
        ];
        $stmt = $pdo->prepare("INSERT INTO cms_destinations (country_slug, country_name, hero_image_url, cta_label, cta_url, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($destinations as $d) {
            $stmt->execute($d);
        }
        $success[] = "Default destinations seeded (9 countries).";
    } else {
        $success[] = "Destinations already seeded — skipped.";
    }
} catch (Exception $e) {
    $errors[] = 'Destinations seed failed: ' . $e->getMessage();
}

// ---------------------------------------------------------------------------
// 6. Seed default footer links
// ---------------------------------------------------------------------------
try {
    $count = $pdo->query("SELECT COUNT(*) FROM cms_footer_links")->fetchColumn();
    if ($count == 0) {
        $footerLinks = [
            // Visa Services column
            ['services', 'Student Visa',  '#activities', 0],
            ['services', 'Work Permit',   '#activities', 1],
            ['services', 'Canada PR',     '#activities', 2],
            ['services', 'Tourist Visa',  '#activities', 3],
            ['services', 'Schengen Visa', '#activities', 4],
            // Countries column
            ['countries', 'Canada',         '#destinations', 0],
            ['countries', 'United Kingdom', '#destinations', 1],
            ['countries', 'Germany',        '#destinations', 2],
            ['countries', 'Australia',      '#destinations', 3],
            ['countries', 'USA & France',   '#destinations', 4],
        ];
        $stmt = $pdo->prepare("INSERT INTO cms_footer_links (column_key, label, url, sort_order) VALUES (?, ?, ?, ?)");
        foreach ($footerLinks as $f) {
            $stmt->execute($f);
        }
        $success[] = "Default footer links seeded.";
    } else {
        $success[] = "Footer links already seeded — skipped.";
    }
} catch (Exception $e) {
    $errors[] = 'Footer seed failed: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visabuz CMS Setup</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #0d1117; color: #e6edf3; display: flex; justify-content: center; padding: 60px 20px; }
        .card { background: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 40px; max-width: 640px; width: 100%; }
        h1 { margin: 0 0 8px; font-size: 1.5rem; }
        p.sub { color: #8b949e; margin: 0 0 32px; }
        .item { padding: 10px 14px; border-radius: 8px; margin-bottom: 8px; font-size: 0.92rem; }
        .item.ok { background: #0d2a1a; border: 1px solid #238636; color: #3fb950; }
        .item.err { background: #2d0a0a; border: 1px solid #f85149; color: #f85149; }
        .action { display: inline-block; margin-top: 28px; padding: 12px 24px; background: #238636; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
<div class="card">
    <h1>Visabuz CMS Setup</h1>
    <p class="sub">Database initialization results</p>

    <?php foreach ($success as $msg): ?>
        <div class="item ok">[OK] <?= $msg ?></div>
    <?php endforeach; ?>
    <?php foreach ($errors as $msg): ?>
        <div class="item err">[ERROR] <?= htmlspecialchars($msg) ?></div>
    <?php endforeach; ?>

    <?php if (empty($errors)): ?>
        <a href="./index.php" class="action">Go to CMS Dashboard →</a>
        <p style="margin-top:20px; color:#8b949e; font-size:0.85rem;">Note: Delete <code>setup.php</code> after confirming everything works.</p>
    <?php endif; ?>
</div>
</body>
</html>
