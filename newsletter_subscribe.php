<?php
/**
 * newsletter_subscribe.php — Public newsletter abone endpoint
 * Ana sayfadaki form bu dosyaya POST atar.
 */
require_once 'inc/config.php';
require_once 'inc/Database.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Geçersiz istek metodu.', 405);
    }

    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Lütfen geçerli bir e-posta adresi girin.');
    }

    $db = Database::getInstance();

    // Tablo yoksa oluştur
    $db->execute("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        status INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Zaten kayıtlı mı?
    $existing = $db->fetchOne('SELECT id FROM newsletter_subscribers WHERE email = ?', [$email]);
    if ($existing) {
        echo json_encode(['success' => true, 'message' => 'Bu e-posta adresi zaten bülten listemizde kayıtlı.']);
        exit;
    }

    $db->execute('INSERT INTO newsletter_subscribers (email) VALUES (?)', [$email]);
    
    echo json_encode([
        'success' => true, 
        'message' => 'success'
    ]);

} catch (Exception $e) {
    if ($e->getCode() === 405) {
        http_response_code(405);
    }
    echo json_encode([
        'success' => false, 
        'message' => 'error'
    ]);
}
