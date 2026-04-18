<?php
/**
 * inc/footer.php — Tüm sayfalarda kullanılan ortak footer
 */
?>
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/905449313961?text=Merhaba,%20ürünleriniz%20hakkında%20bilgi%20almak%20istiyorum." 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       title="WhatsApp ile İletişim">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 2C7.37 2 2 7.37 2 14C2 16.49 2.76 18.81 4.08 20.73L2.5 25.5L7.41 23.95C9.27 25.12 11.56 25.86 14 25.86C20.63 25.86 26 20.49 26 13.93C26 7.37 20.63 2 14 2Z" fill="white"/>
            <path d="M20.5 17.8C20.23 18.55 19.08 19.18 18.22 19.35C17.63 19.47 16.86 19.56 14.24 18.47C10.91 17.09 8.74 13.7 8.57 13.47C8.41 13.24 7.25 11.69 7.25 10.09C7.25 8.49 8.08 7.71 8.43 7.35C8.72 7.05 9.18 6.92 9.62 6.92C9.77 6.92 9.9 6.93 10.02 6.93C10.37 6.95 10.55 6.97 10.78 7.54C11.07 8.24 11.77 9.84 11.85 10C11.94 10.16 12.02 10.38 11.91 10.62C11.81 10.87 11.72 10.98 11.56 11.16C11.39 11.34 11.23 11.48 11.07 11.68C10.92 11.86 10.75 12.05 10.94 12.37C11.13 12.69 11.77 13.73 12.71 14.56C13.93 15.64 14.93 15.99 15.29 16.13C15.56 16.24 15.88 16.21 16.08 15.99C16.33 15.71 16.64 15.25 16.96 14.79C17.18 14.46 17.46 14.42 17.76 14.53C18.07 14.63 19.66 15.41 19.99 15.57C20.32 15.73 20.54 15.8 20.62 15.95C20.7 16.1 20.7 16.85 20.5 17.8Z" fill="#25D366"/>
        </svg>
        <span class="whatsapp-tooltip">WhatsApp ile Yaz</span>
    </a>

    <footer class="luxury-footer" id="iletisim">
        <div class="footer-intro">
            <h3>LIVOLIA TEKSTİL</h3>
            <p>
                Premium ev tekstili koleksiyonları ve fason üretim çözümleriyle,
                markalara tasarımdan sevkiyata kadar uçtan uca destek sağlıyoruz.
            </p>
        </div>
        <div class="footer-main">
            <div class="footer-col" style="flex: 2;">
                <h5>İLETİŞİM</h5>
                <div class="footer-links">
                    <a href="mailto:info@livolia.com.tr" class="footer-link">info@livolia.com.tr</a>
                    <a href="tel:+905449313961" class="footer-link">+90 544 931 39 61</a>
                    <span class="footer-link" style="display:block; margin-top:10px; line-height:1.5; color: #a9a9a9;">Kazım Karabekir Mh. Muhsin Yazıcıoğlu Bulvarı No:114,<br>Yıldırım/Bursa Türkiye</span>
                </div>
            </div>
            <div class="footer-col">
                <h5>SOSYAL MEDYA</h5>
                <div class="footer-links">
                    <a href="https://instagram.com/livoliatekstil" target="_blank" class="footer-link">Instagram</a>
                    <a href="https://linkedin.com/company/livolia" target="_blank" class="footer-link">LinkedIn</a>
                    <a href="https://pinterest.com/livoliatekstil" target="_blank" class="footer-link">Pinterest</a>
                </div>
            </div>
            <div class="footer-col">
                <h5>KEŞFEDİN</h5>
                <div class="footer-links">
                    <a href="<?= BASE_URL ?>/koleksiyon.php" class="footer-link">Koleksiyon</a>
                    <a href="<?= BASE_URL ?>/hakkimizda.php" class="footer-link">Hakkımızda</a>
                    <a href="<?= BASE_URL ?>/misyon-vizyon.php" class="footer-link">Misyon &amp; Vizyon</a>
                    <a href="<?= BASE_URL ?>/blog.php" class="footer-link">Blog</a>
                    <a href="<?= BASE_URL ?>/contact.php" class="footer-link">İletişim</a>
                </div>
            </div>
            <div class="footer-col">
                <h5>YASAL</h5>
                <div class="footer-links">
                    <a href="<?= BASE_URL ?>/kvkk.php" class="footer-link">KVKK</a>
                    <a href="<?= BASE_URL ?>/cerez.php" class="footer-link">Çerez Politikası</a>
                </div>
            </div>
        </div>
        <div style="text-align:center;padding:30px 6vw;border-top:1px solid rgba(0,0,0,0.07);margin-top:40px">
            <small style="color:rgba(0,0,0,0.56);font-size:.88rem;letter-spacing:1.4px">
                &copy; <?= date('Y') ?> LIVOLIA TEKSTİL — TÜM HAKLARI SAKLIDIR
            </small>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Custom Cursor
        const cursor = document.querySelector('.cursor-dot');
        if (cursor) {
            document.addEventListener('mousemove', (e) => {
                gsap.to(cursor, { x: e.clientX, y: e.clientY, duration: 0.1, ease: "power2.out" });
            });
            document.querySelectorAll('a, button, .accent-card, .collection-card').forEach(el => {
                el.addEventListener('mouseenter', () => cursor.classList.add('grow'));
                el.addEventListener('mouseleave', () => cursor.classList.remove('grow'));
            });
        }

        // Header Scroll Effect
        const mainNav = document.getElementById('mainNav');
        if (mainNav) {
            ScrollTrigger.create({
                trigger: "body",
                start: "100px top",
                onEnter: () => mainNav.classList.add('scrolled'),
                onLeaveBack: () => mainNav.classList.remove('scrolled'),
            });
        }

        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('navMobileToggle');
        const mobileOverlay = document.getElementById('mobileMenuOverlay');
        if (mobileToggle && mobileOverlay) {
            mobileToggle.addEventListener('click', () => {
                mobileToggle.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = mobileOverlay.classList.contains('active') ? 'hidden' : '';
            });
            // Overlay'e tıklanınca kapat
            mobileOverlay.addEventListener('click', (e) => {
                if (e.target === mobileOverlay) {
                    mobileToggle.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }

        // Scroll Reveal — Hero içindeki elemanları ATLA (onlar load'da çalışır)
        gsap.utils.toArray('.gsap-reveal').forEach(elem => {
            // Hero wrapper içindeyse atla — ayrı yönetilir
            if (elem.closest('.hero-content-wrapper')) return;

            gsap.fromTo(elem,
                { y: 50, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: elem,
                        start: "top 88%",
                        toggleActions: "play none none none"
                    },
                    y: 0,
                    opacity: 1,
                    duration: 0.9,
                    ease: "power3.out"
                }
            );
        });

        // Hero elemanlarını sayfa yüklenince hemen göster (scroll trigger olmadan)
        const heroElems = document.querySelectorAll('.hero-content-wrapper .gsap-reveal');
        if (heroElems.length > 0) {
            gsap.fromTo(heroElems,
                { y: 60, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 1.3,
                    stagger: 0.18,
                    ease: "power4.out",
                    delay: 0.4
                }
            );
        }

        // Parallax
        gsap.utils.toArray('.parallax-img').forEach(img => {
            gsap.to(img, {
                scrollTrigger: {
                    trigger: img.parentElement,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                },
                y: -80,
                ease: "none"
            });
        });

        // Footer logo — basit fade-in (scrub ile kayboluyordu)
        if (document.querySelector('.huge-logo')) {
            gsap.fromTo('.huge-logo',
                { y: 60, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: '.luxury-footer',
                        start: "top 80%",
                        toggleActions: "play none none none"
                    },
                    y: 0,
                    opacity: 1,
                    duration: 1.2,
                    ease: "power3.out"
                }
            );
        }
    </script>
    <?= $extraScripts ?? '' ?>
</body>
</html>
