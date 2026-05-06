<?php
/**
 * contact_submit.php — Contact form backend
 */
require_once 'inc/config.php';
require_once 'inc/Database.php';
require_once 'inc/functions.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Geçersiz istek metodu.', 405);
    }

    $name    = trim(sanitize($_POST['name']    ?? ''));
    $email   = trim(filter_var($_POST['email']   ?? '', FILTER_SANITIZE_EMAIL));
    $subject = trim(sanitize($_POST['subject'] ?? ''));
    $message = trim(sanitize($_POST['message'] ?? ''));

    if (!$name || !$email || !$subject || !$message) {
        throw new Exception('Lütfen tüm zorunlu alanları (*) doldurun.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Lütfen geçerli bir e-posta adresi girin.');
    }

    $db = Database::getInstance();

    // Tablo yoksa oluştur
    $db->execute("CREATE TABLE IF NOT EXISTS contact_messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        subject TEXT NOT NULL,
        message TEXT NOT NULL,
        is_read INTEGER NOT NULL DEFAULT 0,
        replied_at DATETIME DEFAULT NULL,
        reply_text TEXT DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $db->execute(
        'INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)',
        [$name, $email, $subject, $message]
    );

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
