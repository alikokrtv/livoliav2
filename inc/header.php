<?php
/**
 * inc/header.php — Tüm sayfalarda kullanılan ortak header
 * $activePage değişkeni ile aktif menü belirlenir
 */
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="<?= $_COOKIE['lang'] ?? 'tr' ?>">
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
    <script src="<?= THEME_URL ?>/assets/js/i18n.js?v=<?= filemtime(THEME_PATH . '/assets/js/i18n.js') ?>"></script>
    <?= $extraHead ?? '' ?>
</head>
<body data-i18n-page="<?= $activePage ?>">
    <div class="cursor-dot"></div>

    <header class="main-nav" id="mainNav">
        <div class="nav-container">
            <a href="<?= BASE_URL ?>" class="nav-brand editorial-heading" style="font-size: 1.8rem; letter-spacing: 0.15em;">
                LIVOLIA
                <span class="nav-brand-sub">HOME TEXTILES</span>
            </a>

            <nav class="nav-menu" id="navMenu">
                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>/koleksiyon.php" class="nav-link <?= $activePage === 'koleksiyon' ? 'active' : '' ?>">
                        <span data-i18n="nav.collection">KOLEKSİYON</span> <span class="nav-arrow">▾</span>
                    </a>
                    <div class="nav-dropdown-menu">
                        <a href="<?= BASE_URL ?>/koleksiyon.php" data-i18n="nav.all_collections">Tüm Koleksiyonlar</a>
                        <a href="<?= BASE_URL ?>/koleksiyon-detay.php?cat=kumas" data-i18n="nav.fabrics">Kumaşlar</a>
                        <a href="<?= BASE_URL ?>/koleksiyon-detay.php?cat=perde" data-i18n="nav.curtains">Perdeler</a>
                        <a href="<?= BASE_URL ?>/koleksiyon-detay.php?cat=masa" data-i18n="nav.tablecloths">Masa Örtüleri</a>
                        <a href="<?= BASE_URL ?>/koleksiyon-detay.php?cat=kirlent" data-i18n="nav.cushions">Kırlentler</a>
                    </div>
                </div>

                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>/hakkimizda.php" class="nav-link <?= $activePage === 'hakkimizda' ? 'active' : '' ?>">
                        <span data-i18n="nav.about">HAKKIMIZDA</span> <span class="nav-arrow">▾</span>
                    </a>
                    <div class="nav-dropdown-menu">
                        <a href="<?= BASE_URL ?>/hakkimizda.php" data-i18n="nav.corporate">Kurumsal</a>
                        <a href="<?= BASE_URL ?>/misyon-vizyon.php" data-i18n="nav.mission">Misyon &amp; Vizyon</a>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/#production" class="nav-link" data-i18n="nav.production">ÜRETİM</a>

                <a href="<?= BASE_URL ?>/blog.php" class="nav-link <?= $activePage === 'blog' ? 'active' : '' ?>" data-i18n="nav.blog">BLOG</a>

                <div class="nav-lang">
                    <button class="lang-btn <?= ($_COOKIE['lang'] ?? 'en') === 'tr' ? 'active' : '' ?>" onclick="setLanguage('tr')" title="Türkçe">
                        <img src="https://flagcdn.com/w40/tr.png" alt="TR" width="20">
                    </button>
                    <button class="lang-btn <?= ($_COOKIE['lang'] ?? 'en') === 'en' ? 'active' : '' ?>" onclick="setLanguage('en')" title="English">
                        <img src="https://flagcdn.com/w40/us.png" alt="EN" width="20">
                    </button>
                </div>

                <a href="<?= BASE_URL ?>/contact.php" class="nav-btn <?= $activePage === 'iletisim' ? 'active' : '' ?>" data-i18n="nav.contact">BİZE ULAŞIN</a>
            </nav>

            <button class="nav-mobile-toggle" id="navMobileToggle" aria-label="Menüyü Aç">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu-inner">
            <a href="<?= BASE_URL ?>/koleksiyon.php" class="mobile-menu-link" data-i18n="nav.collection">Koleksiyon</a>
            <a href="<?= BASE_URL ?>/hakkimizda.php" class="mobile-menu-link" data-i18n="nav.about">Hakkımızda</a>
            <a href="<?= BASE_URL ?>/misyon-vizyon.php" class="mobile-menu-link" data-i18n="nav.mission">Misyon &amp; Vizyon</a>
            <a href="<?= BASE_URL ?>/#production" class="mobile-menu-link" data-i18n="nav.production">Üretim</a>
            <a href="<?= BASE_URL ?>/blog.php" class="mobile-menu-link" data-i18n="nav.blog">Blog</a>
            
            <div class="mobile-lang-switcher" style="display: flex; gap: 20px; justify-content: center; margin: 30px 0;">
                <button class="lang-btn" onclick="setLanguage('tr')">
                    <img src="https://flagcdn.com/w40/tr.png" alt="TR" width="30">
                </button>
                <button class="lang-btn" onclick="setLanguage('en')">
                    <img src="https://flagcdn.com/w40/us.png" alt="EN" width="30">
                </button>
            </div>

            <a href="<?= BASE_URL ?>/contact.php" class="mobile-menu-link mobile-menu-cta" data-i18n="nav.contact">Bize Ulaşın</a>
        </div>
    </div>

    <script>
        function setLanguage(lang) {
            document.cookie = "lang=" + lang + "; path=/; max-age=" + (60*60*24*30);
            location.reload();
        }
    </script>
