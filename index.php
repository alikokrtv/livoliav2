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
            <h1 class="gsap-reveal">LIVOLIA<br>HOME TEXTILES</h1>
            <p class="gsap-reveal">Modern ev tekstili koleksiyonları ve butik üretim yaklaşımıyla markalara çözüm sunuyoruz.</p>
            <div class="hero-explore gsap-reveal">
                <a href="#koleksiyon">KOLEKSİYONLARI GÖR</a>
                <a href="contact.php" class="hero-cta-secondary">PARTNER OL</a>
            </div>
        </div>
    </section>

    <!-- Statement Section -->
    <section class="editorial-statement" id="about">
        <div class="statement-container">
            <span class="section-label text-reveal">VİZYONUMUZ</span>
            <h2 class="massive-text gsap-reveal">Kaliteyi tasarımla birleştirerek,
                koleksiyondan üretime kadar markalara uçtan uca değer sunuyoruz.</h2>
            <div class="statement-meta gsap-reveal">
                <p>— LIVOLIA HOME TEXTILES</p>
            </div>
        </div>
    </section>

    <!-- Brand Values Section -->
    <section class="brand-values">
        <div class="values-grid">
            <div class="value-item gsap-reveal">
                <span class="value-num">01</span>
                <h4>SÜRDÜRÜLEBİLİRLİK</h4>
                <p>Çevre dostu üretim yaklaşımı ve verimli süreçlerle uzun vadeli değer üretiyoruz.</p>
            </div>
            <div class="value-item gsap-reveal">
                <span class="value-num">02</span>
                <h4>KİŞİSELLEŞTİRME</h4>
                <p>Markanızın kimliğine uygun özel desen, doku ve ürün geliştirme desteği sunuyoruz.</p>
            </div>
            <div class="value-item gsap-reveal">
                <span class="value-num">03</span>
                <h4>KÜRESEL ERİŞİM</h4>
                <p>Bursa merkezli üretim gücümüzle global pazarlara zamanında ve istikrarlı teslimat sağlıyoruz.</p>
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
                <h3 class="editorial-heading gsap-reveal">Nitelikli<br>Kumaş Koleksiyonları</h3>
                <p class="gsap-reveal">Farklı segmentlere uygun kumaş koleksiyonlarımız; tasarım esnekliği, kalite standardı ve sürdürülebilir üretim prensibiyle hazırlanır.</p>
                <a href="contact.php" class="link-arrow gsap-reveal">KATALOG TALEP ET</a>
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
                <h3 class="editorial-heading gsap-reveal">Perdelik Ürünlerde<br>Güvenilir Üretim</h3>
                <p class="gsap-reveal">Perdelik ürün grubunda estetik, dayanıklılık ve fonksiyonelliği bir araya getiriyor; proje ve marka ihtiyaçlarına göre üretim planlıyoruz.</p>
                <a href="contact.php" class="link-arrow gsap-reveal">TEKLİF AL</a>
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
                    <span class="stat-number">Yeni</span>
                    <span class="stat-label">Marka Yaklaşımı</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number">Butik</span>
                    <span class="stat-label">Üretim Modeli</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number">Esnek</span>
                    <span class="stat-label">Koleksiyon Geliştirme</span>
                </div>
                <div class="stat-item gsap-reveal">
                    <span class="stat-number">Net</span>
                    <span class="stat-label">İletişim ve Süreç</span>
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
                <p class="gsap-reveal">Yeni koleksiyonlar, üretim güncellemeleri ve B2B iş birlikleri için ekibimizle bağlantıda kalın.</p>
                <form class="newsletter-form gsap-reveal" id="nlForm">
                    <input type="email" name="email" placeholder="Kurumsal e-posta adresiniz" required>
                    <button type="submit" id="nlBtn">GÖNDER</button>
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