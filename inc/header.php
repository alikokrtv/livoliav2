<?php
/**
 * inc/header.php — Tüm sayfalarda kullanılan ortak header
 * $activePage değişkeni ile aktif menü belirlenir
 */
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? SITE_TITLE ?> | Premium B2B Home Textiles</title>
    <meta name="description" content="<?= $pageDesc ?? 'Livolia Tekstil — 1994\'ten bu yana global markalar için lüks ev tekstili üretimi.' ?>">
    <meta name="keywords" content="livolia, tekstil, lüks kumaş, perde, fason üretim, ev tekstili, bursa tekstil">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $pageTitle ?? SITE_TITLE ?> | Premium B2B Home Textiles">
    <meta property="og:description" content="<?= $pageDesc ?? 'Global markalar için lüks ev tekstili üretimi. Bursa, Türkiye.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= BASE_URL ?>">
    <meta property="og:image" content="<?= THEME_URL ?>/assets/img/hero.jpg">

    <!-- Canonical -->
    <link rel="canonical" href="<?= BASE_URL ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= THEME_URL ?>/assets/css/style.css?v=<?= filemtime(ROOT . '/theme/assets/css/style.css') ?>">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <?= $extraHead ?? '' ?>
</head>
<body>
    <div class="cursor-dot"></div>

    <header class="main-nav" id="mainNav">
        <div class="nav-container">
            <a href="<?= BASE_URL ?>" class="nav-brand">
                LIVOLIA
                <span class="nav-brand-sub">HOME TEXTILES</span>
            </a>

            <nav class="nav-menu" id="navMenu">
                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>/koleksiyon.php" class="nav-link <?= $activePage === 'koleksiyon' ? 'active' : '' ?>">
                        KOLEKSİYON <span class="nav-arrow">▾</span>
                    </a>
                    <div class="nav-dropdown-menu">
                        <a href="<?= BASE_URL ?>/koleksiyon.php">Tüm Koleksiyonlar</a>
                        <a href="<?= BASE_URL ?>/koleksiyon.php?cat=kumas">Kumaşlar</a>
                        <a href="<?= BASE_URL ?>/koleksiyon.php?cat=perde">Perdeler</a>
                        <a href="<?= BASE_URL ?>/koleksiyon.php?cat=masa">Masa Örtüleri</a>
                        <a href="<?= BASE_URL ?>/koleksiyon.php?cat=kirlent">Kırlentler</a>
                    </div>
                </div>

                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>/hakkimizda.php" class="nav-link <?= $activePage === 'hakkimizda' ? 'active' : '' ?>">
                        HAKKIMIZDA <span class="nav-arrow">▾</span>
                    </a>
                    <div class="nav-dropdown-menu">
                        <a href="<?= BASE_URL ?>/hakkimizda.php">Kurumsal</a>
                        <a href="<?= BASE_URL ?>/misyon-vizyon.php">Misyon &amp; Vizyon</a>
                        <a href="<?= BASE_URL ?>/hakkimizda.php#ekip">Ekibimiz</a>
                        <a href="<?= BASE_URL ?>/hakkimizda.php#sertifikalar">Sertifikalarımız</a>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/#production" class="nav-link">ÜRETİM</a>

                <a href="<?= BASE_URL ?>/blog.php" class="nav-link <?= $activePage === 'blog' ? 'active' : '' ?>">BLOG</a>

                <a href="<?= BASE_URL ?>/contact.php" class="nav-btn <?= $activePage === 'iletisim' ? 'active' : '' ?>">BİZE ULAŞIN</a>
            </nav>

            <button class="nav-mobile-toggle" id="navMobileToggle" aria-label="Menüyü Aç">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu-inner">
            <a href="<?= BASE_URL ?>/koleksiyon.php" class="mobile-menu-link">Koleksiyon</a>
            <a href="<?= BASE_URL ?>/hakkimizda.php" class="mobile-menu-link">Hakkımızda</a>
            <a href="<?= BASE_URL ?>/misyon-vizyon.php" class="mobile-menu-link">Misyon &amp; Vizyon</a>
            <a href="<?= BASE_URL ?>/#production" class="mobile-menu-link">Üretim</a>
            <a href="<?= BASE_URL ?>/blog.php" class="mobile-menu-link">Blog</a>
            <a href="<?= BASE_URL ?>/contact.php" class="mobile-menu-link mobile-menu-cta">Bize Ulaşın</a>
        </div>
    </div>
