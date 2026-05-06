<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$pageTitle = "Ana Sayfa";
$activePage = "home";

include 'inc/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="hero-cinematic">
        <div class="hero-bg" style="background-image: url('<?= THEME_URL ?>/assets/img/hero.jpg');"></div>
        <div class="hero-overlay"></div>

        <div class="hero-content-wrapper">
            <h1 class="gsap-reveal" data-i18n="hero.title">LIVOLIA<br>HOME TEXTILES</h1>
            <p class="gsap-reveal" data-i18n="hero.desc">Modern ev tekstili koleksiyonları ve butik üretim yaklaşımıyla markalara çözüm sunuyoruz.</p>
            <div class="hero-explore gsap-reveal">
                <a href="#koleksiyon" data-i18n="hero.view_collections">KOLEKSİYONLARI GÖR</a>
                <a href="contact.php" class="hero-cta-secondary" data-i18n="hero.partner">PARTNER OL</a>
            </div>
        </div>
    </section>

    <!-- Statement Section -->
    <section class="editorial-statement" id="about">
        <div class="statement-container">
            <span class="section-label text-reveal" data-i18n="statement.vision">VİZYONUMUZ</span>
            <h2 class="massive-text gsap-reveal" data-i18n="statement.text">Kaliteyi tasarımla birleştirerek,
                koleksiyondan üretime kadar markalara uçtan uca değer sunuyoruz.</h2>
            <div class="statement-meta gsap-reveal">
                <p data-i18n="statement.brand">— LIVOLIA HOME TEXTILES</p>
            </div>
        </div>
    </section>

    <!-- Brand Values Section -->
    <section class="brand-values">
        <div class="values-grid">
            <div class="value-item gsap-reveal">
                <span class="value-num">01</span>
                <h4 data-i18n="values.v1_title">SÜRDÜRÜLEBİLİRLİK</h4>
                <p data-i18n="values.v1_desc">Çevre dostu üretim yaklaşımı ve verimli süreçlerle uzun vadeli değer üretiyoruz.</p>
            </div>
            <div class="value-item gsap-reveal">
                <span class="value-num">02</span>
                <h4 data-i18n="values.v2_title">KİŞİSELLEŞTİRME</h4>
                <p data-i18n="values.v2_desc">Markanızın kimliğine uygun özel desen, doku ve ürün geliştirme desteği sunuyoruz.</p>
            </div>
            <div class="value-item gsap-reveal">
                <span class="value-num">03</span>
                <h4 data-i18n="values.v3_title">KÜRESEL ERİŞİM</h4>
                <p data-i18n="values.v3_desc">Bursa merkezli üretim gücümüzle global pazarlara zamanında ve istikrarlı teslimat sağlıyoruz.</p>
            </div>
        </div>
    </section>

    <!-- Showcase 1: Fabrics -->
    <section class="showcase-section" id="koleksiyon">
        <div class="showcase-grid">
            <div class="showcase-img parallax-container">
                <img src="<?= THEME_URL ?>/assets/img/fabrics.jpg" alt="Premium Fabrics" class="parallax-img">
            </div>
            <div class="showcase-text">
                <span class="section-label" data-i18n="showcase.s1_label">01 // KUMAŞ</span>
                <h3 class="editorial-heading gsap-reveal" data-i18n="showcase.s1_title">Nitelikli<br>Kumaş Koleksiyonları</h3>
                <p class="gsap-reveal" data-i18n="showcase.s1_desc">Farklı segmentlere uygun kumaş koleksiyonlarımız; tasarım esnekliği, kalite standardı ve sürdürülebilir üretim prensibiyle hazırlanır.</p>
                <a href="koleksiyon-detay.php?cat=kumas" class="link-arrow gsap-reveal" data-i18n="showcase.s1_btn">KATALOG TALEP ET</a>
            </div>
        </div>
    </section>

    <!-- Showcase 2: Curtains -->
    <section class="showcase-section">
        <div class="showcase-grid reverse">
            <div class="showcase-img parallax-container">
                <img src="<?= THEME_URL ?>/assets/img/curtains.jpg" alt="Luxury Curtains" class="parallax-img">
            </div>
            <div class="showcase-text">
                <span class="section-label" data-i18n="showcase.s2_label">02 // PERDE</span>
                <h3 class="editorial-heading gsap-reveal" data-i18n="showcase.s2_title">Perdelik Ürünlerde<br>Güvenilir Üretim</h3>
                <p class="gsap-reveal" data-i18n="showcase.s2_desc">Perdelik ürün grubunda estetik, dayanıklılık ve fonksiyonelliği bir araya getiriyor; proje ve marka ihtiyaçlarına göre üretim planlıyoruz.</p>
                <a href="koleksiyon-detay.php?cat=perde" class="link-arrow gsap-reveal" data-i18n="showcase.s2_btn">TEKLİF AL</a>
            </div>
        </div>
    </section>

    <!-- B2B / Production Section -->
    <section class="precision-section" id="production">
        <div class="precision-grid">
            <div class="stats-container">
                <span class="section-label" style="color: var(--c-accent); border-color: rgba(181,154,124,0.3);" data-i18n="precision.label">ÖLÇEKLİ ÜRETİM</span>
                <h2 class="editorial-heading gsap-reveal precision-title" data-i18n="precision.title">Endüstriyel Güç,<br>Butik Hassasiyet</h2>

                <div class="stat-item gsap-reveal">
                    <span class="stat-number" data-i18n="precision.s1_num">Yeni</span>
                    <span class="stat-label" data-i18n="precision.s1_label">Marka Yaklaşımı</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number" data-i18n="precision.s2_num">Butik</span>
                    <span class="stat-label" data-i18n="precision.s2_label">Üretim Modeli</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number" data-i18n="precision.s3_num">Esnek</span>
                    <span class="stat-label" data-i18n="precision.s3_label">Koleksiyon Geliştirme</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number" data-i18n="precision.s4_num">Net</span>
                    <span class="stat-label" data-i18n="precision.s4_label">İletişim ve Süreç</span>
                </div>
            </div>
            <div class="precision-image parallax-container">
                <img src="<?= THEME_URL ?>/assets/img/about.jpg" alt="Production Facility" class="parallax-img">
            </div>
        </div>
    </section>

    <!-- Production Process Section -->
    <section class="process-section">
        <div class="statement-container">
            <span class="section-label" data-i18n="process.label">OPERASYONEL SÜREÇ</span>
            <div class="process-grid">
                <div class="process-step gsap-reveal">
                    <span class="step-icon">01.</span>
                    <h5 data-i18n="process.s1_title">TASARIM & AR-GE</h5>
                    <p data-i18n="process.s1_desc">Koleksiyonlarımızın ruhu olan desen ve dokular, trend analizleri ve yaratıcı vizyonumuzla şekillenir.</p>
                </div>
                <div class="process-step gsap-reveal">
                    <span class="step-icon">02.</span>
                    <h5 data-i18n="process.s2_title">TİTİZ ÜRETİM</h5>
                    <p data-i18n="process.s2_desc">Modern dokuma tezgahlarımızda, her iplik en yüksek kalite standartlarına göre işlenir.</p>
                </div>
                <div class="process-step gsap-reveal">
                    <span class="step-icon">03.</span>
                    <h5 data-i18n="process.s3_title">KALİTE KONTROL</h5>
                    <p data-i18n="process.s3_desc">Üretimin her aşamasında, kusursuzluğu garanti altına almak için uzman ekibimiz tarafından denetlenir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Accents Grid -->
    <section class="accents-section">
        <div class="statement-container" style="text-align: center; margin-bottom: 6vw;">
            <h2 class="editorial-heading gsap-reveal" data-i18n="accents.title">Lüks Detaylar</h2>
        </div>
        <div class="accents-grid">
            <a href="koleksiyon-detay.php?cat=masa" class="accent-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/table_linen.jpg" alt="Table Linen">
                <div class="accent-overlay">
                    <h4 data-i18n="accents.item1">Masa Örtüleri</h4>
                </div>
            </a>
            <a href="koleksiyon-detay.php?cat=kirlent" class="accent-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/cushions.jpg" alt="Cushions">
                <div class="accent-overlay">
                    <h4 data-i18n="accents.item2">Kırlentler</h4>
                </div>
            </a>
        </div>
    </section>

    <!-- Newsletter/CTA Section -->
    <section class="newsletter-section">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <span class="section-label text-reveal" data-i18n="newsletter.label">KOLEKSİYON HABERLERİ</span>
                <h2 class="editorial-heading gsap-reveal" data-i18n="newsletter.title">Livolia Dünyasını Keşfedin</h2>
                <p class="gsap-reveal" data-i18n="newsletter.desc">Yeni koleksiyonlar, üretim güncellemeleri ve B2B iş birlikleri için ekibimizle bağlantıda kalın.</p>
                <form class="newsletter-form gsap-reveal" id="nlForm">
                    <input type="email" name="email" data-i18n="newsletter.placeholder" placeholder="Kurumsal e-posta adresiniz" required>
                    <button type="submit" id="nlBtn" data-i18n="newsletter.button">GÖNDER</button>
                </form>
                <div id="nlStatus" style="margin-top:12px;font-size:0.78rem;letter-spacing:1px;display:none"></div>
            </div>
        </div>
    </section>
</main>

<?php 
$extraScripts = <<<JS
<script>
    // Newsletter form
    const nlForm = document.getElementById('nlForm');
    if (nlForm) {
        nlForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn    = document.getElementById('nlBtn');
            const status = document.getElementById('nlStatus');
            const data   = new FormData(this);

            btn.textContent  = t('newsletter.button_loading');
            btn.disabled     = true;
            status.style.display = 'none';

            fetch('<?= BASE_URL ?>/newsletter_subscribe.php', { method: 'POST', body: data })
                .then(r => r.json())
                .then(res => {
                    status.style.display = 'block';
                    status.style.color   = res.success ? '#b59a7c' : '#ef4444';
                    status.textContent   = res.success ? t('newsletter.success') : (res.message || t('newsletter.error'));
                    if (res.success) nlForm.reset();
                })
                .catch(() => {
                    status.style.display = 'block';
                    status.style.color   = '#ef4444';
                    status.textContent   = t('newsletter.error');
                })
                .finally(() => {
                    btn.textContent = t('newsletter.button');
                    btn.disabled    = false;
                });
        });
    }
</script>
JS;

include 'inc/footer.php'; 
?>