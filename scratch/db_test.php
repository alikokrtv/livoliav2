<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

try {
    $db = Database::getInstance();
    $db->execute("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        status INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Success: Table created or exists.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
