<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$pageTitle = "İletişim";
$pageDesc  = "Livolia Tekstil ile iletişime geçin. Bursa'dan dünyaya lüks ev tekstili çözümleri.";
$activePage = "iletisim";

include 'inc/header.php';
?>

<main>
    <!-- Hero -->
    <section class="page-hero">
        <div class="page-hero-bg" style="background-image: url('<?= THEME_URL ?>/assets/img/hero.jpg');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content gsap-reveal">
            <span class="section-label" style="color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.3);" data-i18n="contact.hero_label">İLETİŞİM</span>
            <h1 style="color: #fff; margin-top: 1.5rem;" data-i18n="contact.hero_title">Birlikte<br>Yaratalım</h1>
            <p style="color: rgba(255,255,255,0.75); margin-top: 1rem;" data-i18n="contact.hero_desc">Fason üretim talepleriniz, koleksiyonlarımız veya işbirliği fırsatları için bizimle iletişime geçin.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 10vw 5%; background: var(--c-light);">
        <div class="two-col-grid" style="max-width: 1200px; margin: 0 auto; gap: 80px;">
            
            <!-- Info Column -->
            <div class="gsap-reveal">
                <h3 class="editorial-heading" style="font-size: 1.5rem; margin-bottom: 2.5rem;" data-i18n="contact.info_title">BİLGİLERİMİZ</h3>
                
                <div style="margin-bottom: 2rem;">
                    <span style="display: block; font-size: 10px; letter-spacing: 0.2em; color: var(--c-accent); text-transform: uppercase; margin-bottom: 8px;" data-i18n="contact.addr_label">Adres</span>
                    <p style="color: var(--c-gray-text); line-height: 1.6; font-size: 15px;" data-i18n="footer.address">Kazım Karabekir Mh. Muhsin Yazıcıoğlu Bulvarı No:114,<br>Yıldırım / Bursa, Türkiye</p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <span style="display: block; font-size: 10px; letter-spacing: 0.2em; color: var(--c-accent); text-transform: uppercase; margin-bottom: 8px;" data-i18n="contact.email_label">E-posta</span>
                    <a href="mailto:info@livolia.com.tr" style="color: var(--c-dark); font-size: 16px; text-decoration: none; font-weight: 500;">info@livolia.com.tr</a>
                </div>

                <div style="margin-bottom: 2rem;">
                    <span style="display: block; font-size: 10px; letter-spacing: 0.2em; color: var(--c-accent); text-transform: uppercase; margin-bottom: 8px;" data-i18n="contact.phone_label">Telefon</span>
                    <a href="tel:+905449313961" style="color: var(--c-dark); font-size: 16px; text-decoration: none; font-weight: 500;">+90 544 931 39 61</a>
                </div>

                <div style="margin-bottom: 3rem;">
                    <span style="display: block; font-size: 10px; letter-spacing: 0.2em; color: var(--c-accent); text-transform: uppercase; margin-bottom: 8px;" data-i18n="contact.hours_label">Çalışma Saatleri</span>
                    <p style="color: var(--c-gray-text); line-height: 1.6; font-size: 14px;" data-i18n="contact.hours_val">Pazartesi – Cuma: 09:00 – 18:00<br>Cumartesi: 09:00 – 13:00</p>
                </div>

                <div style="display: flex; gap: 20px; border-top: 1px solid var(--c-gray-border); padding-top: 2rem;">
                    <a href="https://instagram.com/livoliatekstil" target="_blank" style="font-size: 11px; letter-spacing: 0.1em; color: var(--c-gray-text); text-transform: uppercase; text-decoration: none;">Instagram</a>
                    <a href="https://linkedin.com/company/livolia" target="_blank" style="font-size: 11px; letter-spacing: 0.1em; color: var(--c-gray-text); text-transform: uppercase; text-decoration: none;">LinkedIn</a>
                    <a href="https://pinterest.com/livoliatekstil" target="_blank" style="font-size: 11px; letter-spacing: 0.1em; color: var(--c-gray-text); text-transform: uppercase; text-decoration: none;">Pinterest</a>
                </div>
            </div>

            <!-- Form Column -->
            <div class="gsap-reveal" style="background: white; padding: 4rem; border: 1px solid var(--c-gray-border);">
                <h3 class="editorial-heading" style="font-size: 1.5rem; margin-bottom: 2.5rem;" data-i18n="contact.form_title">MESAJ GÖNDERİN</h3>
                
                <form id="contactForm" novalidate>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display:block; font-size: 11px; color: var(--c-accent); margin-bottom: 8px;" data-i18n="contact.name_label">Ad Soyad *</label>
                            <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; font-family: inherit;">
                        </div>
                        <div>
                            <label style="display:block; font-size: 11px; color: var(--c-accent); margin-bottom: 8px;" data-i18n="contact.email_label">E-posta *</label>
                            <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; font-family: inherit;" data-i18n="contact.email_placeholder">
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display:block; font-size: 11px; color: var(--c-accent); margin-bottom: 8px;" data-i18n="contact.subject_label">Konu *</label>
                        <select name="subject" required style="width: 100%; padding: 12px; border: 1px solid #ddd; font-family: inherit; background: white;">
                            <option value="" data-i18n="contact.subject_select">Seçiniz…</option>
                            <option value="Production Request" data-i18n="contact.subject_opt1">Fason Üretim Talebi</option>
                            <option value="Collection Info" data-i18n="contact.subject_opt2">Koleksiyon Bilgisi</option>
                            <option value="Partnership" data-i18n="contact.subject_opt3">Bayilik Başvurusu</option>
                            <option value="Price Quote" data-i18n="contact.subject_opt4">Fiyat Teklifi</option>
                            <option value="Other" data-i18n="contact.subject_opt5">Diğer</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label style="display:block; font-size: 11px; color: var(--c-accent); margin-bottom: 8px;" data-i18n="contact.message_label">Mesajınız *</label>
                        <textarea name="message" required style="width: 100%; padding: 12px; border: 1px solid #ddd; min-height: 150px; font-family: inherit;" data-i18n="contact.message_placeholder"></textarea>
                    </div>

                    <div style="display: flex; align-items: center; gap: 20px;">
                        <button type="submit" id="cfSubmit" style="background: var(--c-dark); color: white; border: none; padding: 15px 40px; font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; cursor: pointer; transition: background 0.3s;" data-i18n="contact.button">GÖNDER</button>
                        <span id="formStatus" style="font-size: 12px;"></span>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php 
$extraScripts = <<<JS
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn    = document.getElementById('cfSubmit');
        const status = document.getElementById('formStatus');
        const data   = new FormData(this);

        btn.disabled    = true;
        btn.textContent = t('contact.sending');
        status.style.display = 'none';

        fetch('contact_submit.php', { method: 'POST', body: data })
            .then(r => r.json())
            .then(res => {
                status.style.display = 'inline';
                status.style.color = res.success ? '#10b981' : '#ef4444';
                status.textContent = res.message;
                if (res.success) this.reset();
            })
            .catch(() => {
                status.style.display = 'inline';
                status.style.color = '#ef4444';
                status.textContent = t('contact.error');
            })
            .finally(() => {
                btn.disabled    = false;
                btn.textContent = t('contact.button');
            });
    });
</script>
JS;

include 'inc/footer.php'; 
?>
