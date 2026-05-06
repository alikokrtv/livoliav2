<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$pageTitle = "Koleksiyonlar";
$activePage = "koleksiyon";

$category = $_GET['cat'] ?? 'all';

include 'inc/header.php';
?>

<main>
    <section class="collections-hero">
        <div class="statement-container gsap-reveal" style="text-align: center;">
            <span class="section-label" data-i18n="collection.label">KOLEKSİYONLAR</span>
            <h1 class="editorial-heading" style="margin-bottom: 1.5rem;" data-i18n="collection.title">Zarafetin Koleksiyonu</h1>
            <p style="color: var(--c-gray-text); max-width: 700px; margin: 0 auto; font-weight: 300;" data-i18n="collection.desc">Trendleri takip eden değil, trendleri belirleyen tasarımlarımızla lüksün her halini keşfedin.</p>
        </div>
    </section>

    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>" data-i18n="breadcrumb.home">Ana Sayfa</a> / <span data-i18n="collection.label">Koleksiyonlar</span>
    </div>

    <section class="page-content" style="padding-top: 4vw;">
        <div class="collections-grid">
            
            <a href="koleksiyon-detay.php?cat=kumas" class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/fabrics.jpg" alt="Fabric Collection">
                <div class="collection-card-overlay">
                    <h3 data-i18n="collection.c1_title">Premium Kumaş</h3>
                    <p data-i18n="collection.c1_sub">İplikten Sanata</p>
                </div>
            </a>

            <a href="koleksiyon-detay.php?cat=perde" class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/curtains.jpg" alt="Curtain Collection">
                <div class="collection-card-overlay">
                    <h3 data-i18n="collection.c2_title">Lüks Perdelik</h3>
                    <p data-i18n="collection.c2_sub">Mekanlara Derinlik</p>
                </div>
            </a>

            <a href="koleksiyon-detay.php?cat=masa" class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/table_linen.jpg" alt="Table Linen Collection">
                <div class="collection-card-overlay">
                    <h3 data-i18n="collection.c3_title">Masa Grubu</h3>
                    <p data-i18n="collection.c3_sub">Ziyafet Şıklığı</p>
                </div>
            </a>

            <a href="koleksiyon-detay.php?cat=kirlent" class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/cushions.jpg" alt="Cushion Collection">
                <div class="collection-card-overlay">
                    <h3 data-i18n="collection.c4_title">Kırlent & Dekoratif</h3>
                    <p data-i18n="collection.c4_sub">Küçük Detaylar, Büyük Farklar</p>
                </div>
            </a>

            <a href="koleksiyon-detay.php?cat=yatak" class="collection-card gsap-reveal">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=800&auto=format&fit=crop" alt="Bed Collection">
                <div class="collection-card-overlay">
                    <h3 data-i18n="collection.c5_title">Yatak Grubu</h3>
                    <p data-i18n="collection.c5_sub">Konfor ve Lüks</p>
                </div>
            </a>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="newsletter-section" style="background: var(--c-light); color: var(--c-dark); border-top: 1px solid var(--c-gray-border);">
        <div class="newsletter-container">
            <h2 class="editorial-heading gsap-reveal" style="font-size: 2.5rem;" data-i18n="collection_cta.title">Kataloğumuzu İndirmek İster Misiniz?</h2>
            <p class="gsap-reveal" style="margin-bottom: 3rem;" data-i18n="collection_cta.desc">Tüm koleksiyonlarımızı ve teknik detayları içeren dijital kataloğumuza erişmek için bize ulaşın.</p>
            <a href="contact.php" class="nav-btn gsap-reveal" style="background: var(--c-dark); color: white; border: none; padding: 18px 45px;" data-i18n="collection_cta.button">İLETİŞİME GEÇİN</a>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
