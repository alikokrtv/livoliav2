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
            <span class="section-label" style="color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.3);" data-i18n="about.hero_label">KURUMSAL</span>
            <h1 style="color: #fff; margin-top: 1.5rem;" data-i18n="about.hero_title">Geleceği Dokuyoruz</h1>
            <p style="color: rgba(255,255,255,0.75); margin-top: 1rem;" data-i18n="about.hero_desc">1994 yılından bu yana, Bursa'nın tekstil mirasını modern teknoloji ve estetikle harmanlayarak dünyaya taşıyoruz.</p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>" data-i18n="breadcrumb.home">Ana Sayfa</a> &nbsp;/&nbsp; <span data-i18n="nav.about">Hakkımızda</span>
    </div>

    <!-- Hikaye Section -->
    <section class="page-content">
        <div class="two-col-grid">
            <div class="gsap-reveal">
                <span class="section-label" data-i18n="about.story_label">HİKAYEMİZ</span>
                <h2 class="editorial-heading" style="margin: 1.5rem 0 2rem; font-size: clamp(2rem, 3.5vw, 3rem);" data-i18n="about.story_title">Lüksün Doğuşu</h2>
                <p style="color: var(--c-gray-text); line-height: 1.95; margin-bottom: 1.5rem;" data-i18n="about.story_p1">Livolia Tekstil, 1994 yılında Bursa'da küçük bir dokuma atölyesi olarak yolculuğuna başladı. Kurucularımızın vizyonu, sadece kumaş üretmek değil, dünya çapındaki markalar için özel bir çözüm ortağı olmaktı.</p>
                <p style="color: var(--c-gray-text); line-height: 1.95;" data-i18n="about.story_p2">Geçen otuz yıl içinde kapasitemizi artırırken kalitemizden asla ödün vermedik. Bugün 50'den fazla ülkeye ihracat yapan, modern tesislerinde butik hassasiyetiyle üretim yapan bir dünya markası haline geldik.</p>
            </div>
            <div class="parallax-container gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/fabrics.jpg" alt="Livolia Üretim" class="parallax-img" style="width: 100%; display: block;">
            </div>
        </div>
    </section>

    <!-- Değerler Section -->
    <section style="padding: 10vw 5%; background: var(--c-dark);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <span class="section-label gsap-reveal" style="color: var(--c-accent); border-color: rgba(181,154,124,0.3);" data-i18n="about.values_label">DEĞERLERİMİZ</span>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 4rem;">
                <div class="gsap-reveal" style="padding: 3rem 2.5rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);">
                    <span style="font-family: var(--font-display); font-size: 13px; letter-spacing: 0.2em; color: var(--c-accent); display: block; margin-bottom: 1.5rem;">01</span>
                    <h4 style="color: #ffffff; font-size: 14px; letter-spacing: 0.15em; margin-bottom: 1rem;" data-i18n="about.v1_title">ZANAATKARLIK</h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.85;" data-i18n="about.v1_desc">Her iplik, otuz yıllık tecrübemizin ve zanaatkarlığımıza olan bağlılığımızın bir yansımasıdır.</p>
                </div>
                <div class="gsap-reveal" style="padding: 3rem 2.5rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);">
                    <span style="font-family: var(--font-display); font-size: 13px; letter-spacing: 0.2em; color: var(--c-accent); display: block; margin-bottom: 1.5rem;">02</span>
                    <h4 style="color: #ffffff; font-size: 14px; letter-spacing: 0.15em; margin-bottom: 1rem;" data-i18n="about.v2_title">İNOVASYON</h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.85;" data-i18n="about.v2_desc">Ar-Ge merkezimizde geliştirdiğimiz yeni dokuma teknikleriyle tekstil dünyasına yön veriyoruz.</p>
                </div>
                <div class="gsap-reveal" style="padding: 3rem 2.5rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);">
                    <span style="font-family: var(--font-display); font-size: 13px; letter-spacing: 0.2em; color: var(--c-accent); display: block; margin-bottom: 1.5rem;">03</span>
                    <h4 style="color: #ffffff; font-size: 14px; letter-spacing: 0.15em; margin-bottom: 1rem;" data-i18n="about.v3_title">GÜVEN</h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 14px; line-height: 1.85;" data-i18n="about.v3_desc">Küresel ortaklarımızla kurduğumuz şeffaf ve sürdürülebilir ilişkiler başarımızın temelidir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Rakamlar Section -->
    <section style="padding: 8vw 5%; background: white; border-top: 1px solid var(--c-gray-border);">
        <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
            <span class="section-label gsap-reveal" data-i18n="about.stats_label">RAKAMLARLA LİVOLİA</span>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 3rem; margin-top: 5rem;">
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">30+</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;" data-i18n="about.stat1_label">Yıl Tecrübe</div>
                </div>
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">50+</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;" data-i18n="about.stat2_label">İhracat Ülkesi</div>
                </div>
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">20M</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;" data-i18n="about.stat3_label">m² Yıllık Kapasite</div>
                </div>
                <div class="gsap-reveal">
                    <div style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--c-dark); letter-spacing: 0.05em;">200+</div>
                    <div style="font-size: 11px; letter-spacing: 0.2em; color: var(--c-gray-text); margin-top: 0.75rem; text-transform: uppercase;" data-i18n="about.stat4_label">Uzman Çalışan</div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section style="padding: 10vw 5%; background: var(--c-dark); text-align: center;">
        <span class="section-label gsap-reveal" style="color: var(--c-accent); border-color: rgba(181,154,124,0.3);" data-i18n="about.cta_label">İŞBİRLİĞİ</span>
        <h2 class="editorial-heading gsap-reveal" style="color: white; font-size: clamp(2rem, 4vw, 3.5rem); margin: 2rem 0 1.5rem;" data-i18n="about.cta_title">Birlikte Bir Şeyler Üretelim</h2>
        <p class="gsap-reveal" style="color: rgba(255,255,255,0.6); max-width: 500px; margin: 0 auto 3rem;" data-i18n="about.cta_desc">Markanız için özel koleksiyon, fason üretim veya hızlı teslimat çözümleri için bizimle iletişime geçin.</p>
        <a href="<?= BASE_URL ?>/contact.php" class="gsap-reveal" style="display: inline-block; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 18px 50px; font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; transition: all 0.4s;" data-i18n="about.cta_btn">BİZE ULAŞIN</a>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
