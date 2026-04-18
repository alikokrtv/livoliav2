<?php
// install_sqlite.php

require_once 'inc/config.php';
require_once 'inc/Database.php';

$db = Database::getInstance();

$queries = [
    // Roles
    "CREATE TABLE IF NOT EXISTS roles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        description TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",

    // Users
    "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        role_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        status INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
    )",

    // Permissions
    "CREATE TABLE IF NOT EXISTS permissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        role_id INTEGER NOT NULL,
        module TEXT NOT NULL,
        can_view INTEGER NOT NULL DEFAULT 0,
        can_add INTEGER NOT NULL DEFAULT 0,
        can_edit INTEGER NOT NULL DEFAULT 0,
        can_delete INTEGER NOT NULL DEFAULT 0,
        UNIQUE(role_id, module),
        FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
    )",

    // Pages
    "CREATE TABLE IF NOT EXISTS pages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        content TEXT,
        meta_title TEXT,
        meta_desc TEXT,
        status INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",

    // Blog Categories
    "CREATE TABLE IF NOT EXISTS blog_categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE
    )",

    // Blog Posts
    "CREATE TABLE IF NOT EXISTS blog_posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        content TEXT,
        image TEXT,
        status INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
    )",

    // Settings
    "CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        key TEXT NOT NULL UNIQUE,
        value TEXT
    )"
];

foreach ($queries as $q) {
    $db->execute($q);
}

// Default Data (Insert Ignore equivalent via ON CONFLICT IGNORE for SQLite)
$db->execute("INSERT OR IGNORE INTO roles (id, name, slug, description) VALUES 
    (1, 'Admin', 'admin', 'Tam yetkili yönetici'),
    (2, 'Editör', 'editor', 'İçerik düzenleyici'),
    (3, 'Üye', 'member', 'Standart üye')");

$db->execute("INSERT OR IGNORE INTO users (id, role_id, name, email, password, status) VALUES 
    (1, 1, 'Site Yöneticisi', 'admin@livolia.com', '$2y$12\$AiKyFxfTvD8GLTQ5XXRWUO.WDdJWt7x17e3CkQ3mJ3zqn0/pvL5ma', 1)");

$db->execute("INSERT OR IGNORE INTO permissions (role_id, module, can_view, can_add, can_edit, can_delete) VALUES 
    (2, 'members', 0, 0, 0, 0),
    (2, 'roles',   0, 0, 0, 0),
    (2, 'pages',   1, 1, 1, 0),
    (2, 'blog',    1, 1, 1, 1)");

$db->execute("INSERT OR IGNORE INTO blog_categories (id, name, slug) VALUES 
    (1, 'Genel', 'genel'),
    (2, 'Haberler', 'haberler'),
    (3, 'Duyurular', 'duyurular')");

$db->execute("INSERT OR IGNORE INTO settings (key, value) VALUES 
    ('site_title', 'Livolia'),
    ('site_email', 'info@livolia.com'),
    ('site_phone', '+90 555 000 00 00')");

echo "SQLite migration complete.\n";
