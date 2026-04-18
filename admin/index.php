<?php
/**
 * admin/index.php — Admin Panel Ana Giriş Noktası
 */

require_once __DIR__ . '/../inc/config.php';
require_once INC_PATH . '/autoload.php';
require_once INC_PATH . '/functions.php';

Auth::start();

// URL'den modül ve aksiyonu çöz
$route = Router::parseAdminUrl();
$module = $route['module'];
$action = $route['action'];
$id = $route['id'];

// Login sayfası (auth gerektirmez)
if ($module === 'login') {
    if (Auth::isLoggedIn()) {
        redirect(ADMIN_URL . '/dashboard');
    }
    require_once ADMIN_PATH . '/views/login.php';
    exit;
}

if ($module === 'logout') {
    Auth::logout();
    redirect(ADMIN_URL . '/login');
}

// Diğer tüm sayfalar auth gerektirir
Auth::check();

// İzin verilen modüller
$allowedModules = ['dashboard', 'members', 'roles', 'pages', 'blog', 'media', 'settings', 'fabrics', 'production', 'contacts', 'newsletter'];

if (!in_array($module, $allowedModules)) {
    http_response_code(404);
    require_once ADMIN_PATH . '/views/404.php';
    exit;
}

// Modül dosyasını yükle
$moduleFile = ADMIN_PATH . '/modules/' . $module . '/' . $action . '.php';

if (!file_exists($moduleFile)) {
    // Fallback: index.php
    $moduleFile = ADMIN_PATH . '/modules/' . $module . '/index.php';
}

if (!file_exists($moduleFile)) {
    http_response_code(404);
    require_once ADMIN_PATH . '/views/404.php';
    exit;
}

require_once $moduleFile;
