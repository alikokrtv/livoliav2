<?php
/**
 * config.php — Proje Yapılandırması
 * Tüm dosyaların en başında dahil edilmeli.
 */

// ─── Hata Raporlama ───────────────────────────────────────────────────
$isVercel = !empty($_SERVER['VERCEL']) || getenv('VERCEL') === '1';
$appEnv = getenv('APP_ENV') ?: ($isVercel ? 'production' : 'development');
define('ENVIRONMENT', $appEnv); // 'development' | 'production'

if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ─── Yol Sabitleri ────────────────────────────────────────────────────
define('ROOT', realpath(__DIR__ . '/..'));
define('INC_PATH', ROOT . '/inc');
define('ADMIN_PATH', ROOT . '/admin');
define('THEME_PATH', ROOT . '/theme');

// ─── URL Sabitleri ────────────────────────────────────────────────────
// Sunucuya göre otomatik algılama (localhost / canlı)
$forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
$isHttps = $forwardedProto === 'https' || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$protocol = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? ($_SERVER['HTTP_HOST'] ?? 'localhost');
$script = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim(str_replace(['/admin', '/api'], '', $script), '/');

define('BASE_URL', $protocol . '://' . $host . $basePath);
define('ADMIN_URL', BASE_URL . '/admin');
define('THEME_URL', BASE_URL . '/theme');

// ─── Veritabanı ───────────────────────────────────────────────────────
// Vercel dosya sistemi yazma için kalıcı değildir; /tmp geçici fakat yazılabilir.
$rootDbPath = ROOT . '/database.sqlite';
$dbPath = $rootDbPath;

if ($isVercel) {
    $tmpDbPath = sys_get_temp_dir() . '/database.sqlite';

    if (!file_exists($tmpDbPath) && file_exists($rootDbPath)) {
        @copy($rootDbPath, $tmpDbPath);
    }

    $dbPath = file_exists($tmpDbPath) ? $tmpDbPath : $rootDbPath;
}

define('DB_DSN', 'sqlite:' . $dbPath);
define('DB_USER', '');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ─── Oturum ───────────────────────────────────────────────────────────
define('SESSION_LIFETIME', 3600); // saniye
define('CSRF_TOKEN_NAME', '_csrf_token');

// ─── Site Ayarları ────────────────────────────────────────────────────
define('SITE_TITLE', 'LIVOLIA');
define('ADMIN_TITLE', 'LIVOLIA Admin Panel');
define('ITEMS_PER_PAGE', 20);

// ─── Zaman Dilimi ─────────────────────────────────────────────────────
date_default_timezone_set('Europe/Istanbul');
