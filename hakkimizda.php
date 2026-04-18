<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$pageTitle = "Hakkımızda";
$pageDesc  = "Livolia Tekstil — 1994'ten bu yana Bursa'dan dünyaya lüks ev tekstili.";
$activePage = "hakkimizda";

include 'inc/header.php';
?>

<main>
    <!-- Page Hero -->
    <section class="page-hero">
        <div class="page-hero-bg" style="background-image: url('<?= THEME_URL ?>/assets/img/about.jpg');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content gsap-reveal">
            <span class="section-label" style="color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.3);">KURUMSAL</span>
            <h1 style="color: #fff; margin-top: 1.5rem;">Geleceği Dokuyoruz</h1>
            <p style="color: rgba(255,255,255,0.75); margin-top: 1rem;">1994 yılından bu yana, Bursa'nın tekstil mirasını modern teknoloji ve estetikle harmanlayarak dünyaya taşıyoruz.</p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>">Ana Sayfa</a> &nbsp;/&nbsp; Hakkımızda
    </div>

    <!-- Hikaye Section -->
    <section class="page-content">
        <div class="two-col-grid">
            <div class="gsap-reveal">
                <span class="section-label">HİKAYEMİZ</span>
                <h2 class="editorial-heading" style="margin: 1.5rem 0 2rem; font-size: clamp(2rem, 3.5vw, 3rem);">Lüksün Doğuşu</h2>
                <p style="color: var(--c-gray-text); line-height: 1.95; margin-bottom: 1.5rem;">Livolia Tekstil, 1994 yılında Bursa'da küçük bir dokuma atölyesi olarak yolculuğuna başladı. Kurucularımızın vizyonu, sadece kumaş üretmek değil, dünya çapındaki markalar için özel bir çözüm ortağı olmaktı.</p>
                <p style="color: var(--c-gray-text); line-height: 1.95;">Geçen otuz yıl içinde kapasitemizi artırırken kalitemizden asla ödün vermedik. Bugün 50'den fazla ülkeye ihracat yapan, modern tesislerinde butik hassasiyetiyle üretim yapan bir dünya markası haline geldik.</p>
            </div>
            <div class="parallax-container gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/fabrics.jpg" alt="Livolia Üretim" class="parallax-img" style="width: 100%; display: block;">
            </div>
        </div>
    </section>

    <!-- Değerler Section -->
    <section style="padding: 10vw 5%; background: var(--c-dark);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <span class="section-label gsap-reveal" style="color: var(--c-accent); border-color: rgba(181,154,124,0.3);">DEĞERLERİMİZ</span>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 4rem;">
                <div class="gsap-reveal" style="padding: 3rem 2.5rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);">
                    <span style="font-family: var(--font-display); font-size: 13px; letter-spacing: 0.2em; color: var(--c-accent); display: block; margin-bottom: 1.5rem;">01</span>
                    <h4 style="color: #ffffff; font-size: 14px; letter-spacing: 0.15em; margin-bottom: 1rem;">ZANAATKARLIK</h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.85;">Her iplik, otuz yıllık tecrübemizin ve zanaatkarlığımıza olan bağlılığımızın bir yansımasıdır.</p>
                </div>
                <div class="gsap-reveal" style="padding: 3rem 2.5rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);">
                    <span style="font-family: var(--font-display); font-size: 13px; letter-spacing: 0.2em; color: var(--c-accent); display: block; margin-bottom: 1.5rem;">02</span>
                    <h4 style="color: #ffffff; font-size: 14px; letter-spacing: 0.15em; margin-bottom: 1rem;">İNOVASYON</h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.85;">Ar-Ge merkezimizde geliştirdiğimiz yeni dokuma teknikleriyle tekstil dünyasına yön veriyoruz.</p>
                </div>
                <div class="gsap-reveal" style="padding: 3rem 2.5rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);">
                    <span style="font-family: var(--font-display); font-size: 13px; letter-spacing: 0.2em; color: var(--c-accent); display: block; margin-bottom: 1.5rem;">03</span>
                    <h4 style="color: #ffffff; font-size: 14px; letter-spacing: 0.15em; margin-bottom: 1rem;">GÜVEN</h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.85;">Küresel ortaklarımızla kurduğumuz şeffaf ve sürdürülebilir ilişkiler başarımızın temelidir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Rakamlar Section -->
    <section style="padding: 8vw 5%; background: white; border-top: 1px solid var(--c-gray-border);">
        <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
            <span class="section-label gsap-reveal">RAKAMLARLA LİVOLİA</span>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 3rem; margin-top: 5rem;">
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">30+</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;">Yıl Tecrübe</div>
                </div>
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">50+</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;">İhracat Ülkesi</div>
                </div>
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">20M</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;">m² Yıllık Kapasite</div>
                </div>
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">200+</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;">Uzman Çalışan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sertifikalar & Çalışma Section -->
    <section id="sertifikalar" style="padding: 8vw 5%; background: var(--c-light);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div class="two-col-grid">
                <div class="gsap-reveal">
                    <span class="section-label">SERTİFİKALARIMIZ</span>
                    <h2 class="editorial-heading" style="margin: 1.5rem 0 2rem; font-size: clamp(1.8rem, 3vw, 2.5rem);">Uluslararası<br>Standartlarımız</h2>
                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 2rem;">
                        <?php 
                        $sertifikalar = ['ISO 9001', 'OEKO-TEX®', 'GOTS', 'GRS', 'BCI'];
                        foreach ($sertifikalar as $s): ?>
                        <span style="border: 1px solid var(--c-gray-border); padding: 10px 20px; font-size: 12px; letter-spacing: 0.15em; font-weight: 600; color: var(--c-dark); background: white;"><?= $s ?></span>
                        <?php endforeach; ?>
                    </div>
                    <p style="margin-top: 2.5rem; color: var(--c-gray-text); line-height: 1.9;">Uluslararası sertifikalarımız, üretim kalitemizi ve sürdürülebilirlik taahhütlerimizi belgeleyen bağımsız güvencelerdir.</p>
                </div>
                <div class="parallax-container gsap-reveal">
                    <img src="<?= THEME_URL ?>/assets/img/curtains.jpg" alt="Üretim Tesisi" class="parallax-img" style="width: 100%; display: block;">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 10vw 5%; background: var(--c-dark); text-align: center;">
        <span class="section-label gsap-reveal" style="color: var(--c-accent); border-color: rgba(181,154,124,0.3);">İŞBİRLİĞİ</span>
        <h2 class="editorial-heading gsap-reveal" style="color: white; font-size: clamp(2rem, 4vw, 3.5rem); margin: 2rem 0 1.5rem;">Birlikte Bir Şeyler Üretelim</h2>
        <p class="gsap-reveal" style="color: rgba(255,255,255,0.6); max-width: 500px; margin: 0 auto 3rem;">Markanız için özel koleksiyon, fason üretim veya hızlı teslimat çözümleri için bizimle iletişime geçin.</p>
        <a href="<?= BASE_URL ?>/contact.php" class="gsap-reveal" style="display: inline-block; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 18px 50px; font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; transition: all 0.4s;">BİZE ULAŞIN</a>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
