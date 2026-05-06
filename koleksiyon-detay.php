<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$cat = $_GET['cat'] ?? 'kumas';
$validCats = ['kumas', 'perde', 'masa', 'kirlent', 'yatak'];

if (!in_array($cat, $validCats)) {
    header('Location: koleksiyon.php');
    exit;
}

$pageTitle = "Koleksiyon Detayı";
$activePage = "koleksiyon";

// Map categories to images
$catImages = [
    'kumas'   => 'fabrics.jpg',
    'perde'   => 'curtains.jpg',
    'masa'    => 'table_linen.jpg',
    'kirlent' => 'cushions.jpg',
    'yatak'   => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=1200&auto=format&fit=crop'
];

$heroImg = (strpos($catImages[$cat], 'http') === 0) ? $catImages[$cat] : THEME_URL . '/assets/img/' . $catImages[$cat];

include 'inc/header.php';
?>

<main>
    <!-- Page Hero -->
    <section class="page-hero">
        <div class="page-hero-bg" style="background-image: url('<?= $heroImg ?>');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content gsap-reveal">
            <span class="section-label" style="color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.3);" data-i18n="collection.label">KOLEKSİYONLAR</span>
            <h1 style="color: #fff; margin-top: 1.5rem;" data-i18n="collection_detail.<?= $cat ?>.title">Koleksiyon Detayı</h1>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>" data-i18n="breadcrumb.home">Ana Sayfa</a> / 
        <a href="koleksiyon.php" data-i18n="collection.label">Koleksiyonlar</a> / 
        <span data-i18n="collection_detail.<?= $cat ?>.title">Detay</span>
    </div>

    <!-- Content Section -->
    <section class="page-content">
        <div class="two-col-grid" style="max-width: 1200px; margin: 0 auto; gap: 80px; align-items: start;">
            
            <div class="gsap-reveal">
                <a href="koleksiyon.php" style="display: inline-flex; align-items: center; gap: 10px; font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--c-gray-text); text-decoration: none; margin-bottom: 30px;" data-i18n="collection_detail.back_btn">← Koleksiyonlara Dön</a>
                
                <h2 class="editorial-heading" style="margin-bottom: 2rem; font-size: clamp(1.8rem, 3.5vw, 2.8rem);" data-i18n="collection_detail.<?= $cat ?>.title">Başlık</h2>
                
                <div style="font-size: 1.1rem; line-height: 1.9; color: var(--c-gray-text); margin-bottom: 3rem;" data-i18n="collection_detail.<?= $cat ?>.desc">
                    Açıklama metni buraya gelecek.
                </div>

                <div style="background: #f9f8f6; padding: 2.5rem; border-left: 3px solid var(--c-accent); margin-bottom: 3rem;">
                    <p style="font-size: 0.9rem; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-dark); margin-bottom: 0.8rem;" data-i18n="mission.values_label">ÖZELLİKLER</p>
                    <p style="font-size: 1.05rem; color: var(--c-dark); font-style: italic;" data-i18n="collection_detail.<?= $cat ?>.features">Özellikler...</p>
                </div>

                <a href="contact.php?subject=<?= ucfirst($cat) ?> Inquiry" class="nav-btn" style="background: var(--c-dark); color: white; border: none; padding: 20px 50px; font-size: 11px; letter-spacing: 0.3em; text-decoration: none; display: inline-block;" data-i18n="collection_detail.inquiry_btn">İLETİŞİME GEÇİN / TEKLİF ALIN</a>
            </div>

            <div class="gsap-reveal">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <img src="<?= $heroImg ?>" alt="Gallery 1" style="width: 100%; aspect-ratio: 1; object-fit: cover; border: 1px solid var(--c-gray-border);">
                    <img src="<?= THEME_URL ?>/assets/img/fabrics.jpg" alt="Gallery 2" style="width: 100%; aspect-ratio: 1; object-fit: cover; border: 1px solid var(--c-gray-border);">
                    <img src="<?= THEME_URL ?>/assets/img/curtains.jpg" alt="Gallery 3" style="width: 100%; aspect-ratio: 1; object-fit: cover; border: 1px solid var(--c-gray-border);">
                    <img src="<?= THEME_URL ?>/assets/img/table_linen.jpg" alt="Gallery 4" style="width: 100%; aspect-ratio: 1; object-fit: cover; border: 1px solid var(--c-gray-border);">
                </div>
            </div>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="newsletter-section" style="background: var(--c-dark); color: white;">
        <div class="newsletter-container">
            <h2 class="editorial-heading gsap-reveal" style="font-size: 2.5rem; color: white;" data-i18n="collection_cta.title">Özel Üretim Çözümleri</h2>
            <p class="gsap-reveal" style="margin-bottom: 3rem; color: rgba(255,255,255,0.7);" data-i18n="collection_cta.desc">Markanıza özel doku, desen ve ürün geliştirme süreçlerimiz hakkında detaylı bilgi alın.</p>
            <a href="contact.php" class="nav-btn gsap-reveal" style="background: var(--c-accent); color: white; border: none; padding: 18px 45px;" data-i18n="collection_detail.inquiry_btn">TEKLİF ALIN</a>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
