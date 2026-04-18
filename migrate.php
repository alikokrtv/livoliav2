<?php
/**
 * migrate.php — Yeni tablolar ekle (newsletter_subscribers, contact_messages)
 * Tarayıcıdan bir kez çalıştırın: http://localhost/livoliav2/migrate.php
 */
require_once 'inc/config.php';
require_once 'inc/Database.php';

$db = Database::getInstance();

$queries = [
    "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id          INTEGER PRIMARY KEY AUTOINCREMENT,
        email       TEXT NOT NULL UNIQUE,
        status      INTEGER NOT NULL DEFAULT 1,
        created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS contact_messages (
        id          INTEGER PRIMARY KEY AUTOINCREMENT,
        name        TEXT NOT NULL,
        email       TEXT NOT NULL,
        subject     TEXT NOT NULL,
        message     TEXT NOT NULL,
        is_read     INTEGER NOT NULL DEFAULT 0,
        replied_at  DATETIME DEFAULT NULL,
        reply_text  TEXT DEFAULT NULL,
        created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
];

$ok = [];
$fail = [];
foreach ($queries as $q) {
    try {
        $db->execute($q);
        $ok[] = substr($q, 0, 60) . '…';
    } catch (Exception $e) {
        $fail[] = $e->getMessage();
    }
}

header('Content-Type: text/html; charset=utf-8');
echo '<pre style="font-family:monospace;padding:20px;background:#1a1a1a;color:#ccc;">';
echo "<b style='color:#10b981'>✔ Başarılı:</b>\n";
foreach ($ok as $l) echo "  {$l}\n";
if ($fail) {
    echo "\n<b style='color:#ef4444'>✘ Hatalı:</b>\n";
    foreach ($fail as $e) echo "  {$e}\n";
}
echo "\n<b style='color:#A88C6F'>Migration tamamlandı.</b></pre>";
