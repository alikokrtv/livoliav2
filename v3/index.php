<?php
// Livolia Ultimate V3 - Giriş Noktası
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIVOLIA | ULTIMATE V3</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- GSAP Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
</head>

<body>

    <!-- Yükleme Ekranı -->
    <div id="loader">
        <div class="loader-bg"></div>
        <div class="loader-text">LIVOLIA</div>
    </div>

    <div class="custom-cursor"></div>

    <header>
        <div class="logo">LIVOLIA</div>
        <nav class="nav-links">
            <a href="#">Koleksiyon</a>
            <a href="#">Atölye</a>
            <a href="#">Üretim</a>
            <a href="#">İletişim</a>
        </nav>
    </header>

    <main id="main-content">
        <!-- Hero Bölümü -->
        <section class="v-section hero-v3">
            <div class="hero-img-box">
                <img src="assets/img/hero.png" alt="Lüks Showroom">
            </div>
            <div class="hero-content">
                <h1 class="split-txt">KUSURSUZ</h1>
                <p>İmza Tekstil Mükemmelliği</p>
            </div>
        </section>

        <!-- Yatay Kaydırma Bölümü (Desktop) -->
        <section class="pin-container">
            <div class="pin-section">
                <!-- Panel 1: Doku -->
                <div class="panel">
                    <div class="panel-content">
                        <div class="panel-img">
                            <img src="assets/img/fabrics.png" alt="Dokuma Detayı">
                        </div>
                        <div class="panel-text">
                            <span class="label">01 // DOKU</span>
                            <h2>DOKUNMUŞ<br>DÜŞLER</h2>
                            <p>Dünyanın en hassas ipliklerini zamansız başyapıtlara dönüştürüyoruz. Her dokuma, bir hassasiyet ve miras hikayesi anlatır.</p>
                        </div>
                    </div>
                </div>

                <!-- Panel 2: Mekan -->
                <div class="panel">
                    <div class="panel-content">
                        <div class="panel-img">
                            <img src="assets/img/interior.png" alt="Lüks İç Mekan">
                        </div>
                        <div class="panel-text">
                            <span class="label">02 // MEKAN</span>
                            <h2>ATMOSFERİN<br>MİMARI</h2>
                            <p>Işık ve gölgeye hükmeden perdelerle yaşam alanlarını dönüştürüyoruz. Lüks, kıvrımların zarafetinde gizlidir.</p>
                        </div>
                    </div>
                </div>

                <!-- Panel 3: Üretim -->
                <div class="panel">
                    <div class="panel-content">
                        <div class="panel-img">
                            <img src="assets/img/production.png" alt="Yüksek Teknoloji Üretim">
                        </div>
                        <div class="panel-text">
                            <span class="label">03 // ÜRETİM</span>
                            <h2>ENDÜSTRİYEL<br>GÜÇ</h2>
                            <p>Boutique hassasiyetini endüstriyel ölçekte sunuyoruz. Teknolojinin en son imkanlarını sanatla birleştiriyoruz.</p>
                        </div>
                    </div>
                </div>

                <!-- Panel 4: Detay -->
                <div class="panel">
                    <div class="panel-content">
                        <div class="panel-img">
                            <img src="assets/img/detail.png" alt="Kumaş Detayı">
                        </div>
                        <div class="panel-text">
                            <span class="label">04 // DETAY</span>
                            <h2>SAF<br>ZARAFET</h2>
                            <p>En küçük liften en geniş kumaşa kadar her noktada mükemmellik. Detaylar sadece bir parça değil, bütünün kendisidir.</p>
                        </div>
                    </div>
                </div>

                <!-- Panel 5: Mimari -->
                <div class="panel">
                    <div class="panel-content">
                        <div class="panel-img">
                            <img src="assets/img/architecture.png" alt="Showroom Mimarisi">
                        </div>
                        <div class="panel-text">
                            <span class="label">05 // VİZYON</span>
                            <h2>ESTETİĞİN<br>ÖTESİ</h2>
                            <p>Gelenekseli modernle harmanlayan vizyonumuzla tekstilin geleceğini tasarlıyoruz. Livolia bir markadan fazlası, bir yaşam stilidir.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final Statement -->
        <section class="v-section statement-v3">
            <div class="hero-content">
                <h2 style="font-family: 'Bodoni Moda'; font-size: clamp(2rem, 5vw, 4.5rem); max-width: 1000px; margin: 0 auto; line-height: 1.1; font-style: italic;">
                    "Biz sadece kumaş üretmiyoruz. Her ilmekte bir rüya dokuyoruz."
                </h2>
            </div>
        </section>

        <footer class="footer-v3">
            <div class="huge-type">LIVOLIA</div>
            <div class="footer-bottom">
                <p>&copy; 2026 LIVOLIA ULTIMATE — TÜM HAKLARI SAKLIDIR</p>
                <p>ANTIGRAVITY TARAFINDAN TASARLANDI</p>
            </div>
        </footer>
    </main>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Preloader
        window.addEventListener('load', () => {
            const tl = gsap.timeline();
            
            // Background scale in loader
            gsap.to('.loader-bg', { scale: 1, duration: 4, ease: "power2.out" });

            tl.to('.loader-text', { y: '100%', duration: 1, ease: "power4.inOut", delay: 1 })
              .to('#loader', { y: '-100%', duration: 1, ease: "expo.inOut" }, "-=0.2")
              .from('.hero-v3 h1', { y: 200, opacity: 0, duration: 1.5, ease: "power4.out" }, "-=0.5")
              .from('.hero-img-box img', { scale: 1.5, duration: 2.5, ease: "power2.out" }, "-=1.5");
        });

        // Custom Cursor (Desktop Only)
        if (window.innerWidth > 1024) {
            const cursor = document.querySelector('.custom-cursor');
            document.addEventListener('mousemove', (e) => {
                gsap.to(cursor, {
                    x: e.clientX,
                    y: e.clientY,
                    duration: 0.1
                });
            });

            document.querySelectorAll('a, .panel-img').forEach(el => {
                el.addEventListener('mouseenter', () => cursor.classList.add('active'));
                el.addEventListener('mouseleave', () => cursor.classList.remove('active'));
            });
        }

        // Horizontal Scroll Logic (Desktop Only)
        if (window.innerWidth > 1024) {
            let sections = gsap.utils.toArray(".panel");

            gsap.to(sections, {
                xPercent: -100 * (sections.length - 1),
                ease: "none",
                scrollTrigger: {
                    trigger: ".pin-container",
                    pin: true,
                    scrub: 1.5,
                    start: "top top",
                    end: () => "+=" + document.querySelector(".pin-section").offsetWidth
                }
            });
        }

        // Statement Reveal
        gsap.from('.statement-v3 h2', {
            scrollTrigger: {
                trigger: '.statement-v3',
                start: 'top 85%',
                toggleActions: "play none none reverse"
            },
            opacity: 0,
            y: 50,
            duration: 1.5,
            ease: 'power4.out'
        });

    </script>
</body>

</html>