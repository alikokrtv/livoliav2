<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$pageTitle = "Misyon & Vizyon";
$activePage = "hakkimizda";

include 'inc/header.php';
?>

<main>
    <section class="page-hero">
        <div class="page-hero-bg" style="background-image: url('<?= THEME_URL ?>/assets/img/fabrics.jpg');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content gsap-reveal">
            <span class="section-label" style="color: white; opacity: 0.8;">KURUMSAL</span>
            <h1>Misyon & Vizyon</h1>
            <p>Hedeflerimizi ve varoluş amacımızı belirleyen temel değerlerimiz.</p>
        </div>
    </section>

    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>">Ana Sayfa</a> / Misyon & Vizyon
    </div>

    <section class="page-content">
        <div class="mission-grid" style="max-width: 900px; margin: 0 auto;">
            
            <div class="mission-card gsap-reveal">
                <h3>MİSYONUMUZ</h3>
                <p>Müşterilerimize yüksek kaliteli, yenilikçi ve estetik ev tekstili ürünleri sunarak yaşam alanlarına değer katmak; üretim süreçlerimizde çevreye ve insana saygıyı esas alarak sürdürülebilir bir gelecek inşa etmek ve Türkiye tekstil sektörünün global pazardaki gücünü temsil etmektir.</p>
            </div>

            <div class="mission-card gsap-reveal">
                <h3>VİZYONUMUZ</h3>
                <p>Tasarım ve teknolojiyi harmanlayarak lüks ev tekstili alanında dünya çapında aranan, lider bir B2B markası olmak. Küresel markaların en güvenilir çözüm ortağı olarak anılmak ve sektördeki kalite standartlarını her geçen gün daha yukarıya taşımaktır.</p>
            </div>

            <div class="gsap-reveal" style="text-align: center; margin-top: 6vw;">
                <span class="section-label">TEMEL DEĞERLERİMİZ</span>
                <h2 class="editorial-heading" style="font-size: 2.5rem; margin-top: 2rem;">Etik, Kalite ve Tutku</h2>
                <p style="color: var(--c-gray-text); max-width: 600px; margin: 2rem auto; font-weight: 300;">Attığımız her adımda, dokuduğumuz her santimetrede bu değerleri gözetiyoruz. İşimize duyduğumuz tutku, bizi her gün daha mükemmele yönlendiriyor.</p>
            </div>

        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
