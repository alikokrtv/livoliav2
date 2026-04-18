<?php
/**
 * newsletter_subscribe.php — Public newsletter abone endpoint
 * Ana sayfadaki form bu dosyaya POST atar.
 */
require_once 'inc/config.php';
require_once 'inc/Database.php';
require_once 'inc/functions.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
    exit;
}

$email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Geçerli bir e-posta adresi girin.']);
    exit;
}

$db = Database::getInstance();

// Tablo yoksa oluştur (fallback)
$db->execute("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE,
    status INTEGER NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Zaten kayıtlı mı?
$existing = $db->fetchOne('SELECT id FROM newsletter_subscribers WHERE email = ?', [$email]);
if ($existing) {
    echo json_encode(['success' => true, 'message' => 'Bu e-posta adresi zaten kayıtlı.']);
    exit;
}

$db->execute('INSERT INTO newsletter_subscribers (email) VALUES (?)', [$email]);
echo json_encode(['success' => true, 'message' => 'Bültenimize başarıyla abone oldunuz!']);
