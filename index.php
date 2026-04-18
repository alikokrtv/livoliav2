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
            <h1 class="gsap-reveal">THE ART OF<br>WOVEN ELEGANCE</h1>
            <p class="gsap-reveal">Global pazar için tasarlanmış, kusursuz fason üretim ve imza koleksiyonlar.</p>
            <div class="hero-explore gsap-reveal">
                <span class="explore-line"></span>
                <a href="#koleksiyon">KEŞFET</a>
            </div>
        </div>
    </section>

    <!-- Statement Section -->
    <section class="editorial-statement" id="about">
        <div class="statement-container">
            <span class="section-label text-reveal">VİZYONUMUZ</span>
            <h2 class="massive-text gsap-reveal">Mükemmellik bir standart değil, başlangıç noktamızdır. Biz sadece
                kumaş üretmiyoruz; küresel markalar için zamansız değerler dokuyoruz.</h2>
            <div class="statement-meta gsap-reveal">
                <p>— LIVOLIA TEKSTİL, EST. 1994</p>
            </div>
        </div>
    </section>

    <!-- Brand Values Section -->
    <section class="brand-values">
        <div class="values-grid">
            <div class="value-item gsap-reveal">
                <span class="value-num">01</span>
                <h4>SÜRDÜRÜLEBİLİRLİK</h4>
                <p>En modern geri dönüşüm teknolojileri ve çevre dostu üretim süreçleriyle yarını bugün dokuyoruz.</p>
            </div>
            <div class="value-item gsap-reveal">
                <span class="value-num">02</span>
                <h4>KİŞİSELLEŞTİRME</h4>
                <p>Markanızın ruhuna uygun, size özel desen ve doku çalışmalarıyla butik bir yaklaşım sunuyoruz.</p>
            </div>
            <div class="value-item gsap-reveal">
                <span class="value-num">03</span>
                <h4>KÜRESEL ERİŞİM</h4>
                <p>Bursa'dan dünyaya uzanan lojistik ağımızla, lüks segmentin ihtiyaçlarına zamanında yanıt veriyoruz.</p>
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
                <span class="section-label">01 // KUMAŞ</span>
                <h3 class="editorial-heading gsap-reveal">Ustalıkla<br>Dokunmuş</h3>
                <p class="gsap-reveal">Kusursuz dokuma teknikleri ve iplik seçimleriyle hayat bulan koleksiyonlarımız, lüksün dokunulabilir halini sunuyor. Modern teknolojiyi geleneksel zanaatla harmanlayarak global markaların özel tasarımları için en yüksek standartları sağlıyoruz.</p>
                <a href="contact.php" class="link-arrow gsap-reveal">Detaylı Bilgi Alın</a>
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
                <span class="section-label">02 // PERDE</span>
                <h3 class="editorial-heading gsap-reveal">Işığa<br>Yön Verin</h3>
                <p class="gsap-reveal">Kusursuz dökümü ve zamansız desenleri ile yaşam alanlarınıza derinlik katan perdelik kumaşlarımız, fonksiyonelliği ve estetiği bir araya getiriyor. Işığın gücünü lüks bir dokunuşla kontrol edin ve mekana imzanızı bırakın.</p>
                <a href="contact.php" class="link-arrow gsap-reveal">Kataloğu İnceleyin</a>
            </div>
        </div>
    </section>

    <!-- B2B / Production Section -->
    <section class="precision-section" id="production">
        <div class="precision-grid">
            <div class="stats-container">
                <span class="section-label" style="color: var(--c-accent); border-color: rgba(181,154,124,0.3);">ÖLÇEKLİ ÜRETİM</span>
                <h2 class="editorial-heading gsap-reveal precision-title">Endüstriyel Güç,<br>Butik Hassasiyet</h2>

                <div class="stat-item gsap-reveal">
                    <span class="stat-number">20M+</span>
                    <span class="stat-label">Yıllık Kapasite (m²)</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number">50+</span>
                    <span class="stat-label">İhracat Ülkesi</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number">%100</span>
                    <span class="stat-label">Özelleştirilebilir Üretim</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number">30+</span>
                    <span class="stat-label">Yıl Sektör Deneyimi</span>
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
            <span class="section-label">OPERASYONEL SÜREÇ</span>
            <div class="process-grid">
                <div class="process-step gsap-reveal">
                    <span class="step-icon">01.</span>
                    <h5>TASARIM & AR-GE</h5>
                    <p>Koleksiyonlarımızın ruhu olan desen ve dokular, trend analizleri ve yaratıcı vizyonumuzla şekillenir.</p>
                </div>
                <div class="process-step gsap-reveal">
                    <span class="step-icon">02.</span>
                    <h5>TİTİZ ÜRETİM</h5>
                    <p>Modern dokuma tezgahlarımızda, her iplik en yüksek kalite standartlarına göre işlenir.</p>
                </div>
                <div class="process-step gsap-reveal">
                    <span class="step-icon">03.</span>
                    <h5>KALİTE KONTROL</h5>
                    <p>Üretimin her aşamasında, kusursuzluğu garanti altına almak için uzman ekibimiz tarafından denetlenir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Accents Grid -->
    <section class="accents-section">
        <div class="statement-container" style="text-align: center; margin-bottom: 6vw;">
            <h2 class="editorial-heading gsap-reveal">Lüks Detaylar</h2>
        </div>
        <div class="accents-grid">
            <div class="accent-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/table_linen.jpg" alt="Table Linen">
                <div class="accent-overlay">
                    <h4>Masa Örtüleri</h4>
                </div>
            </div>
            <div class="accent-card gsap-reveal">
                <img src="<?= THEME_URL ?>/assets/img/cushions.jpg" alt="Cushions">
                <div class="accent-overlay">
                    <h4>Kırlentler</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter/CTA Section -->
    <section class="newsletter-section">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <span class="section-label text-reveal">KOLEKSİYON HABERLERİ</span>
                <h2 class="editorial-heading gsap-reveal">Livolia Dünyasını Keşfedin</h2>
                <p class="gsap-reveal">Yeni koleksiyonlar, özel tasarımlar ve sektörel trendlerden ilk siz haberdar olun.</p>
                <form class="newsletter-form gsap-reveal" id="nlForm">
                    <input type="email" name="email" placeholder="E-Posta Adresiniz" required>
                    <button type="submit" id="nlBtn">KAYDOL</button>
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

            btn.textContent  = '…';
            btn.disabled     = true;
            status.style.display = 'none';

            fetch('<?= BASE_URL ?>/newsletter_subscribe.php', { method: 'POST', body: data })
                .then(r => r.json())
                .then(res => {
                    status.style.display = 'block';
                    status.style.color   = res.success ? '#b59a7c' : '#ef4444';
                    status.textContent   = res.message;
                    if (res.success) nlForm.reset();
                })
                .catch(() => {
                    status.style.display = 'block';
                    status.style.color   = '#ef4444';
                    status.textContent   = 'Bir hata oluştu. Lütfen tekrar deneyin.';
                })
                .finally(() => {
                    btn.textContent = 'KAYDOL';
                    btn.disabled    = false;
                });
        });
    }
</script>
JS;

include 'inc/footer.php'; 
?>