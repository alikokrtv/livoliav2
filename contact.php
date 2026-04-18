<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';
require_once 'inc/functions.php';
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim | <?= SITE_TITLE ?></title>
    <meta name="description" content="Livolia Tekstil ile iletişime geçin. Fason üretim, koleksiyon ve işbirliği talepleriniz için bize ulaşın.">

    <!-- Open Graph -->
    <meta property="og:title" content="İletişim | <?= SITE_TITLE ?>">
    <meta property="og:description" content="Livolia Tekstil ile iletişime geçin.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= BASE_URL ?>/contact.php">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= THEME_URL ?>/assets/css/style.css">
    <style>
        /* ── Contact Page Specific Styles ── */
        .contact-hero {
            background-color: #0a0a0a;
            padding: 180px 6vw 80px;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 60% 50%, rgba(168,140,111,0.08) 0%, transparent 70%);
        }

        .contact-hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
        }

        .contact-hero span.label {
            display: block;
            font-size: 0.65rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #b59a7c;
            margin-bottom: 20px;
        }

        .contact-hero h1 {
            font-family: 'Cinzel', serif;
            font-size: clamp(2.2rem, 5vw, 4rem);
            font-weight: 400;
            color: #f9f8f6;
            line-height: 1.15;
            letter-spacing: 0.02em;
            margin-bottom: 20px;
        }

        .contact-hero p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.5);
            font-weight: 300;
            letter-spacing: 0.03em;
            line-height: 1.8;
        }

        /* ── Main Content ── */
        .contact-main {
            padding: 80px 6vw 100px;
            background-color: #f9f8f6;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 80px;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Info Column */
        .contact-info h3 {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            letter-spacing: 2px;
            color: #0a0a0a;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }

        .contact-info-item {
            margin-bottom: 28px;
        }

        .contact-info-item span.ci-label {
            display: block;
            font-size: 0.62rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #b59a7c;
            margin-bottom: 6px;
        }

        .contact-info-item a,
        .contact-info-item p {
            font-size: 0.88rem;
            color: #333;
            font-weight: 400;
            line-height: 1.7;
            text-decoration: none;
            display: block;
        }

        .contact-info-item a:hover {
            color: #b59a7c;
        }

        .contact-socials {
            display: flex;
            gap: 16px;
            margin-top: 36px;
            padding-top: 32px;
            border-top: 1px solid rgba(0,0,0,0.06);
        }

        .contact-social-link {
            font-size: 0.72rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #555;
            text-decoration: none;
            padding-bottom: 2px;
            border-bottom: 1px solid rgba(0,0,0,0.15);
            transition: color 0.3s, border-color 0.3s;
        }

        .contact-social-link:hover {
            color: #b59a7c;
            border-color: #b59a7c;
        }

        /* Form Column */
        .contact-form-wrapper h3 {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            letter-spacing: 2px;
            color: #0a0a0a;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }

        .contact-form .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form label {
            display: block;
            font-size: 0.68rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 8px;
        }

        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(0,0,0,0.15);
            padding: 10px 0;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.875rem;
            color: #0a0a0a;
            outline: none;
            transition: border-color 0.3s;
            border-radius: 0;
            -webkit-appearance: none;
        }

        .contact-form input:focus,
        .contact-form select:focus,
        .contact-form textarea:focus {
            border-bottom-color: #b59a7c;
        }

        .contact-form textarea {
            resize: none;
            min-height: 120px;
        }

        .contact-form select {
            background: transparent;
            cursor: pointer;
        }

        .contact-form select option {
            color: #0a0a0a;
        }

        .contact-submit {
            margin-top: 36px;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .contact-submit button {
            background: #0a0a0a;
            color: #f9f8f6;
            border: none;
            padding: 14px 36px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .contact-submit button:hover {
            background: #b59a7c;
            transform: translateY(-1px);
        }

        .contact-submit button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        #formStatus {
            font-size: 0.8rem;
            display: none;
        }

        #formStatus.success { color: #10b981; }
        #formStatus.error   { color: #ef4444; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .contact-grid { grid-template-columns: 1fr; gap: 50px; }
        }

        @media (max-width: 600px) {
            .contact-form .form-row { grid-template-columns: 1fr; }
            .contact-hero { padding: 140px 5vw 60px; }
            .contact-main { padding: 50px 5vw 70px; }
        }
    </style>
</head>

<body>
    <div class="cursor-dot"></div>

    <header class="main-nav">
        <div class="nav-container">
            <a href="<?= BASE_URL ?>" class="nav-brand">LIVOLIA</a>
            <nav class="nav-menu">
                <a href="<?= BASE_URL ?>/#koleksiyon" class="nav-link">KOLEKSİYON</a>
                <a href="<?= BASE_URL ?>/#production" class="nav-link">ÜRETİM</a>
                <a href="<?= BASE_URL ?>/#about" class="nav-link">HAKKIMIZDA</a>
                <a href="contact.php" class="nav-btn">BİZE ULAŞIN</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="contact-hero">
        <div class="contact-hero-content">
            <span class="label">İletişim</span>
            <h1>Birlikte<br>Yaratalım</h1>
            <p>Fason üretim talepleriniz, koleksiyonlarımız veya<br>işbirliği fırsatları için bizimle iletişime geçin.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="contact-main">
        <div class="contact-grid">

            <!-- Info -->
            <div class="contact-info">
                <h3>BİLGİLERİMİZ</h3>

                <div class="contact-info-item">
                    <span class="ci-label">Adres</span>
                    <p>Kazım Karabekir Mh. Muhsin Yazıcıoğlu Bulvarı No:114,<br>Yıldırım / Bursa, Türkiye</p>
                </div>

                <div class="contact-info-item">
                    <span class="ci-label">E-posta</span>
                    <a href="mailto:info@livolia.com.tr">info@livolia.com.tr</a>
                </div>

                <div class="contact-info-item">
                    <span class="ci-label">Telefon</span>
                    <a href="tel:+905449313961">+90 544 931 39 61</a>
                </div>

                <div class="contact-info-item">
                    <span class="ci-label">Çalışma Saatleri</span>
                    <p>Pazartesi – Cuma: 09:00 – 18:00<br>Cumartesi: 09:00 – 13:00</p>
                </div>

                <div class="contact-socials">
                    <a href="https://instagram.com/livoliatekstil" target="_blank" class="contact-social-link">Instagram</a>
                    <a href="https://linkedin.com/company/livolia" target="_blank" class="contact-social-link">LinkedIn</a>
                    <a href="https://pinterest.com/livoliatekstil" target="_blank" class="contact-social-link">Pinterest</a>
                </div>
            </div>

            <!-- Form -->
            <div class="contact-form-wrapper">
                <h3>MESAJ GÖNDERIN</h3>
                <form class="contact-form" id="contactForm" novalidate>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cf_name">Ad Soyad *</label>
                            <input type="text" id="cf_name" name="name" required placeholder="Adınız">
                        </div>
                        <div class="form-group">
                            <label for="cf_email">E-posta *</label>
                            <input type="email" id="cf_email" name="email" required placeholder="email@sirket.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cf_subject">Konu *</label>
                        <select id="cf_subject" name="subject" required>
                            <option value="">Seçiniz…</option>
                            <option value="Fason Üretim Talebi">Fason Üretim Talebi</option>
                            <option value="Koleksiyon Bilgisi">Koleksiyon Bilgisi</option>
                            <option value="Bayilik Başvurusu">Bayilik Başvurusu</option>
                            <option value="Fiyat Teklifi">Fiyat Teklifi</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cf_message">Mesajınız *</label>
                        <textarea id="cf_message" name="message" required placeholder="Talebinizi veya sorunuzu buraya yazın…"></textarea>
                    </div>
                    <div class="contact-submit">
                        <button type="submit" id="cfSubmit">GÖNDER</button>
                        <span id="formStatus"></span>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <footer class="luxury-footer" style="padding-top:60px">
        <div class="footer-main">
            <div class="footer-col" style="flex:2">
                <h5>İLETİŞİM</h5>
                <div class="footer-links">
                    <a href="mailto:info@livolia.com.tr" class="footer-link">info@livolia.com.tr</a>
                    <a href="tel:+905449313961" class="footer-link">+90 544 931 39 61</a>
                </div>
            </div>
            <div class="footer-col">
                <h5>KEŞFEDİN</h5>
                <div class="footer-links">
                    <a href="<?= BASE_URL ?>/#koleksiyon" class="footer-link">Koleksiyon</a>
                    <a href="blog.php" class="footer-link">Blog</a>
                    <a href="contact.php" class="footer-link">İletişim</a>
                </div>
            </div>
            <div class="footer-col">
                <h5>YASAL</h5>
                <div class="footer-links">
                    <a href="kvkk.php" class="footer-link">KVKK</a>
                    <a href="cerez.php" class="footer-link">Çerez Politikası</a>
                </div>
            </div>
        </div>
        <div style="text-align:center;padding:30px 6vw;border-top:1px solid rgba(255,255,255,0.06);margin-top:40px;">
            <small style="color:rgba(255,255,255,0.2);font-size:0.68rem;letter-spacing:2px">
                &copy; <?= date('Y') ?> LIVOLIA TEKSTİL — TÜM HAKLARI SAKLIDIR
            </small>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        // Custom cursor
        const cursor = document.querySelector('.cursor-dot');
        document.addEventListener('mousemove', e => {
            gsap.to(cursor, { x: e.clientX, y: e.clientY, duration: 0.1 });
        });
        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('grow'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('grow'));
        });

        // Header scroll
        window.addEventListener('scroll', () => {
            document.querySelector('.main-nav').classList.toggle('scrolled', window.scrollY > 80);
        });

        // Contact Form AJAX
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn    = document.getElementById('cfSubmit');
            const status = document.getElementById('formStatus');
            const data   = new FormData(this);

            btn.disabled    = true;
            btn.textContent = 'GÖNDERİLİYOR…';
            status.style.display = 'none';

            fetch('<?= BASE_URL ?>/contact_submit.php', { method: 'POST', body: data })
                .then(r => r.json())
                .then(res => {
                    status.style.display = 'inline';
                    if (res.success) {
                        status.className   = 'success';
                        status.textContent = res.message;
                        this.reset();
                    } else {
                        status.className   = 'error';
                        status.textContent = res.message;
                    }
                })
                .catch(() => {
                    status.style.display = 'inline';
                    status.className     = 'error';
                    status.textContent   = 'Bir hata oluştu. Lütfen tekrar deneyin.';
                })
                .finally(() => {
                    btn.disabled    = false;
                    btn.textContent = 'GÖNDER';
                });
        });
    </script>
</body>

</html>
