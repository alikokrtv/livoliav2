<?php
/**
 * admin/ajax.php — Merkezi AJAX Endpoint
 * Tüm admin AJAX istekleri buradan işlenir.
 */

require_once __DIR__ . '/../inc/config.php';
require_once INC_PATH . '/autoload.php';
require_once INC_PATH . '/functions.php';

Auth::start();

header('Content-Type: application/json; charset=utf-8');

// Sadece POST kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::error('Geçersiz istek yöntemi.', 405);
}

// Giriş kontrolü
if (!Auth::isLoggedIn()) {
    Response::error('Oturumunuz sona erdi. Lütfen tekrar giriş yapın.', 401);
}

// CSRF token doğrulama
csrf_check();

// Modül ve aksiyon al
$module = sanitize($_POST['module'] ?? '');
$action = sanitize($_POST['action'] ?? '');

if (empty($module) || empty($action)) {
    Response::error('Geçersiz parametre.');
}

// İzin verilen modüller: modules/ klasöründe ajax.php dosyası olan klasörler
$modulesDir = ADMIN_PATH . '/modules';
$allowedModules = [];
foreach (glob($modulesDir . '/*/ajax.php') as $ajaxFile) {
    $allowedModules[] = basename(dirname($ajaxFile));
}

if (!in_array($module, $allowedModules)) {
    Response::error('Bu modül bulunamadı.', 404);
}

// Modül ajax dosyasını yükle
$ajaxFile = ADMIN_PATH . '/modules/' . $module . '/ajax.php';

if (!file_exists($ajaxFile)) {
    Response::error('AJAX handler bulunamadı.', 404);
}

require_once $ajaxFile;

// İlgili aksiyonu çalıştır
$fnName = $module . '_' . $action; // örn: members_store, blog_delete

if (!function_exists($fnName)) {
    Response::error('Bu aksiyon tanımlı değil.', 404);
}

$fnName();
