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
            <span class="section-label">KOLEKSİYONLAR</span>
            <h1 class="editorial-heading" style="margin-bottom: 1.5rem;">Zarafetin Koleksiyonu</h1>
            <p style="color: var(--c-gray-text); max-width: 700px; margin: 0 auto; font-weight: 300;">Trendleri takip eden değil, trendleri belirleyen tasarımlarımızla lüksün her halini keşfedin.</p>
        </div>
    </section>

    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>">Ana Sayfa</a> / Koleksiyonlar
    </div>

    <section class="page-content" style="padding-top: 4vw;">
        <div class="collections-grid">
            
            <div class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/fabrics.jpg" alt="Kumaş Koleksiyonu">
                <div class="collection-card-overlay">
                    <h3>Premium Kumaş</h3>
                    <p>İplikten Sanata</p>
                </div>
            </div>

            <div class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/curtains.jpg" alt="Perde Koleksiyonu">
                <div class="collection-card-overlay">
                    <h3>Lüks Perdelik</h3>
                    <h3 style="font-size: 1.6rem; color: white;">Işığın Estetiği</h3>
                    <p>Mekanlara Derinlik</p>
                </div>
            </div>

            <div class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/table_linen.jpg" alt="Meyra Koleksiyonu">
                <div class="collection-card-overlay">
                    <h3>Masa Grubu</h3>
                    <p>Ziyafet Şıklığı</p>
                </div>
            </div>

            <div class="collection-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/cushions.jpg" alt="Dekoratif Grup">
                <div class="collection-card-overlay">
                    <h3>Kırlent & Dekoratif</h3>
                    <p>Küçük Detaylar, Büyük Farklar</p>
                </div>
            </div>

            <div class="collection-card gsap-reveal">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=800&auto=format&fit=crop" alt="Yatak Grubu">
                <div class="collection-card-overlay">
                    <h3>Yatak Grubu</h3>
                    <p>Konfor ve Lüks</p>
                </div>
            </div>

            <div class="collection-card gsap-reveal">
                <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?q=80&w=800&auto=format&fit=crop" alt="Banyo Grubu">
                <div class="collection-card-overlay">
                    <h3>Banyo Grubu</h3>
                    <p>Yumuşak Dokunuşlar</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="newsletter-section" style="background: var(--c-light); color: var(--c-dark); border-top: 1px solid var(--c-gray-border);">
        <div class="newsletter-container">
            <h2 class="editorial-heading gsap-reveal" style="font-size: 2.5rem;">Kataloğumuzu İndirmek İster Misiniz?</h2>
            <p class="gsap-reveal" style="margin-bottom: 3rem;">Tüm koleksiyonlarımızı ve teknik detayları içeren dijital kataloğumuza erişmek için bize ulaşın.</p>
            <a href="contact.php" class="nav-btn gsap-reveal" style="background: var(--c-dark); color: white; border: none; padding: 18px 45px;">İLETİŞİME GEÇİN</a>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
