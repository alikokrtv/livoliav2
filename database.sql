-- ============================================================
-- Livolia V2 — Veritabanı Şeması
-- Oluşturma: 2026-02-24
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ─── Roller ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `roles` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(100)  NOT NULL,
    `slug`        VARCHAR(100)  NOT NULL UNIQUE,
    `description` VARCHAR(255)  NULL,
    `created_at`  DATETIME      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Üyeler ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `role_id`    INT UNSIGNED NOT NULL,
    `name`       VARCHAR(150) NOT NULL,
    `email`      VARCHAR(200) NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `status`     TINYINT(1)   NOT NULL DEFAULT 1 COMMENT '1=Aktif, 0=Pasif',
    `created_at` DATETIME     DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── İzinler ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `permissions` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `role_id`    INT UNSIGNED NOT NULL,
    `module`     VARCHAR(100) NOT NULL,
    `can_view`   TINYINT(1)   NOT NULL DEFAULT 0,
    `can_add`    TINYINT(1)   NOT NULL DEFAULT 0,
    `can_edit`   TINYINT(1)   NOT NULL DEFAULT 0,
    `can_delete` TINYINT(1)   NOT NULL DEFAULT 0,
    UNIQUE KEY `uq_role_module` (`role_id`, `module`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Sayfalar ────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `pages` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`      VARCHAR(255) NOT NULL,
    `slug`       VARCHAR(255) NOT NULL UNIQUE,
    `content`    LONGTEXT     NULL,
    `meta_title` VARCHAR(255) NULL,
    `meta_desc`  VARCHAR(500) NULL,
    `status`     TINYINT(1)   NOT NULL DEFAULT 1 COMMENT '1=Yayında, 0=Taslak',
    `created_at` DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Blog Kategorileri ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `blog_categories` (
    `id`   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Blog Yazıları ────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT UNSIGNED  NULL,
    `title`       VARCHAR(255)  NOT NULL,
    `slug`        VARCHAR(255)  NOT NULL UNIQUE,
    `content`     LONGTEXT      NULL,
    `image`       VARCHAR(255)  NULL COMMENT 'Dosya adı; theme/assets/img/blog/ altında',
    `status`      TINYINT(1)    NOT NULL DEFAULT 1,
    `created_at`  DATETIME      DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `blog_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Site Ayarları ────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `settings` (
    `id`    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key`   VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT         NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Varsayılan Veriler ───────────────────────────────────────────────

-- Admin rolü
INSERT INTO `roles` (`name`, `slug`, `description`) VALUES
    ('Admin', 'admin', 'Tam yetkili yönetici'),
    ('Editör', 'editor', 'İçerik düzenleyici'),
    ('Üye', 'member', 'Standart üye')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Admin kullanıcı (şifre: Admin@1234)
INSERT INTO `users` (`role_id`, `name`, `email`, `password`, `status`) VALUES
    (1, 'Site Yöneticisi', 'admin@livolia.com', '$2y$12$AiKyFxfTvD8GLTQ5XXRWUO.WDdJWt7x17e3CkQ3mJ3zqn0/pvL5ma', 1)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Editör rolü izinleri
INSERT INTO `permissions` (`role_id`, `module`, `can_view`, `can_add`, `can_edit`, `can_delete`) VALUES
    (2, 'members', 0, 0, 0, 0),
    (2, 'roles',   0, 0, 0, 0),
    (2, 'pages',   1, 1, 1, 0),
    (2, 'blog',    1, 1, 1, 1)
ON DUPLICATE KEY UPDATE `can_view`=VALUES(`can_view`), `can_add`=VALUES(`can_add`),
    `can_edit`=VALUES(`can_edit`), `can_delete`=VALUES(`can_delete`);

-- Örnek blog kategorileri
INSERT INTO `blog_categories` (`name`, `slug`) VALUES
    ('Genel', 'genel'),
    ('Haberler', 'haberler'),
    ('Duyurular', 'duyurular')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Örnek ayarlar
INSERT INTO `settings` (`key`, `value`) VALUES
    ('site_title', 'Livolia'),
    ('site_email', 'info@livolia.com'),
    ('site_phone', '+90 555 000 00 00')
ON DUPLICATE KEY UPDATE `value`=VALUES(`value`);

SET FOREIGN_KEY_CHECKS = 1;
