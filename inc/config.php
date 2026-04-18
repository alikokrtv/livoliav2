<?php
/**
 * config.php — Proje Yapılandırması
 * Tüm dosyaların en başında dahil edilmeli.
 */

// ─── Hata Raporlama ───────────────────────────────────────────────────
define('ENVIRONMENT', 'development'); // 'development' | 'production'

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
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim(str_replace('/admin', '', $script), '/');

define('BASE_URL', $protocol . '://' . $host . $basePath);
define('ADMIN_URL', BASE_URL . '/admin');
define('THEME_URL', BASE_URL . '/theme');

// ─── Veritabanı ───────────────────────────────────────────────────────
define('DB_DSN', 'sqlite:' . ROOT . '/database.sqlite');
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
