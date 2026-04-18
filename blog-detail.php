<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';
require_once 'inc/functions.php';

$db   = Database::getInstance();
$slug = trim($_GET['slug'] ?? '');

if (!$slug) {
    header('Location: blog.php');
    exit;
}

$post = $db->fetchOne(
    "SELECT p.*, c.name AS category_name
     FROM blog_posts p
     LEFT JOIN blog_categories c ON c.id = p.category_id
     WHERE p.slug = ? AND p.status = 1
     LIMIT 1",
    [$slug]
);

if (!$post) {
    header('HTTP/1.0 404 Not Found');
    header('Location: blog.php');
    exit;
}

// Related posts
$related = $db->fetchAll(
    "SELECT id, title, slug, image, created_at FROM blog_posts
     WHERE status = 1 AND id != ? AND category_id = ?
     ORDER BY created_at DESC LIMIT 3",
    [$post['id'], $post['category_id'] ?? 0]
);

$metaTitle = htmlspecialchars($post['title'] . ' | ' . SITE_TITLE);
$metaDesc  = mb_substr(strip_tags($post['content'] ?? ''), 0, 160);
$postImageUrl = blog_image_url($post['image'] ?? null);
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $metaTitle ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $metaTitle ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= BASE_URL ?>/blog-detail.php?slug=<?= urlencode($slug) ?>">
    <?php if ($postImageUrl): ?>
        <meta property="og:image" content="<?= htmlspecialchars($postImageUrl) ?>">
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $metaTitle ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= THEME_URL ?>/assets/css/style.css">
    <style>
        /* ── Post Hero ── */
        .post-hero {
            position: relative;
            min-height: 55vh;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            background: #0a0a0a;
        }

        .post-hero-bg {
            position: absolute;
            inset: 0;
            object-fit: cover;
            width: 100%;
            height: 100%;
            opacity: 0.45;
        }

        .post-hero-bg-fallback {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1F1E1C 0%, #2D2B28 100%);
        }

        .post-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.1) 60%);
        }

        .post-hero-content {
            position: relative;
            z-index: 2;
            padding: 160px 6vw 60px;
            max-width: 860px;
        }

        .post-hero-content .post-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .post-cat {
            font-size: 0.78rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #b59a7c;
            font-weight: 600;
        }

        .post-date {
            font-size: 0.84rem;
            color: rgba(255,255,255,0.72);
            letter-spacing: 1px;
        }

        .post-hero-content h1 {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.8rem, 3.5vw, 3rem);
            font-weight: 400;
            color: #f9f8f6;
            line-height: 1.25;
            letter-spacing: 0.01em;
        }

        /* ── Post Body ── */
        .post-main {
            padding: 70px 6vw 100px;
            background: #f9f8f6;
        }

        .post-container {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 70px;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Content */
        .post-content {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.06rem;
            line-height: 1.85;
            color: #1f1f1f;
        }

        .post-content h2,
        .post-content h3 {
            font-family: 'Cinzel', serif;
            color: #0a0a0a;
            margin: 36px 0 16px;
            letter-spacing: 0.01em;
        }

        .post-content h2 { font-size: 1.4rem; }
        .post-content h3 { font-size: 1.1rem; }

        .post-content p {
            margin-bottom: 20px;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin: 24px 0;
        }

        .post-content a {
            color: #b59a7c;
            text-decoration: underline;
            text-decoration-color: rgba(181,154,124,0.3);
        }

        .post-content blockquote {
            border-left: 3px solid #b59a7c;
            padding-left: 24px;
            margin: 32px 0;
            font-style: italic;
            color: #555;
        }

        .post-content ul,
        .post-content ol {
            padding-left: 24px;
            margin-bottom: 20px;
        }

        .post-content li { margin-bottom: 6px; }

        /* Share Bar */
        .post-share {
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .post-share span {
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #666;
        }

        .share-btn {
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #333;
            text-decoration: none;
            padding: 6px 14px;
            border: 1px solid rgba(0,0,0,0.12);
            transition: all 0.2s;
        }

        .share-btn:hover {
            background: #0a0a0a;
            color: #fff;
            border-color: #0a0a0a;
        }

        /* Sidebar */
        .post-sidebar {}

        .post-sidebar h4 {
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #0a0a0a;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }

        .related-item {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .related-item:last-child {
            border-bottom: none;
        }

        .related-item img {
            width: 70px;
            height: 50px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .related-item-placeholder {
            width: 70px;
            height: 50px;
            background: #e8e2db;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .related-item-placeholder span {
            font-size: 0.5rem;
            letter-spacing: 1px;
            color: #aaa;
        }

        .related-item a {
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            color: #0a0a0a;
            text-decoration: none;
            line-height: 1.4;
            display: block;
            margin-bottom: 4px;
        }

        .related-item a:hover { color: #b59a7c; }

        .related-item small {
            font-size: 0.76rem;
            color: #666;
        }

        /* Back link */
        .post-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.84rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #555;
            text-decoration: none;
            margin-bottom: 36px;
            transition: color 0.2s;
        }

        .post-back:hover { color: #b59a7c; }

        @media (max-width: 900px) {
            .post-container { grid-template-columns: 1fr; }
            .post-sidebar { display: none; }
        }
    </style>
</head>

<body>
    <div class="cursor-dot"></div>

    <header class="main-nav scrolled">
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

    <!-- Post Hero -->
    <section class="post-hero">
        <?php if ($postImageUrl): ?>
            <img src="<?= htmlspecialchars($postImageUrl) ?>"
                 alt="<?= htmlspecialchars($post['title']) ?>" class="post-hero-bg">
        <?php else: ?>
            <div class="post-hero-bg-fallback"></div>
        <?php endif; ?>
        <div class="post-hero-overlay"></div>

        <div class="post-hero-content">
            <div class="post-meta">
                <?php if ($post['category_name']): ?>
                    <span class="post-cat"><?= htmlspecialchars($post['category_name']) ?></span>
                    <span style="color:rgba(255,255,255,0.2)">·</span>
                <?php endif; ?>
                <span class="post-date"><?= date('d F Y', strtotime($post['created_at'])) ?></span>
            </div>
            <h1><?= htmlspecialchars($post['title']) ?></h1>
        </div>
    </section>

    <!-- Post Body -->
    <section class="post-main">
        <div class="post-container">
            <!-- Content -->
            <div>
                <a href="blog.php" class="post-back">← Tüm Yazılar</a>

                <div class="post-content">
                    <?= $post['content'] ?>
                </div>

                <!-- Share -->
                <div class="post-share">
                    <span>Paylaş</span>
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode(BASE_URL . '/blog-detail.php?slug=' . $post['slug']) ?>"
                       target="_blank" class="share-btn">Twitter</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(BASE_URL . '/blog-detail.php?slug=' . $post['slug']) ?>"
                       target="_blank" class="share-btn">LinkedIn</a>
                    <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' ' . BASE_URL . '/blog-detail.php?slug=' . $post['slug']) ?>"
                       target="_blank" class="share-btn">WhatsApp</a>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="post-sidebar">
                <?php if (!empty($related)): ?>
                    <h4>İlgili Yazılar</h4>
                    <?php foreach ($related as $r): ?>
                        <div class="related-item">
                            <?php $relatedImageUrl = blog_image_url($r['image'] ?? null); ?>
                            <?php if ($relatedImageUrl): ?>
                                <img src="<?= htmlspecialchars($relatedImageUrl) ?>"
                                     alt="<?= htmlspecialchars($r['title']) ?>">
                            <?php else: ?>
                                <div class="related-item-placeholder"><span>LVL</span></div>
                            <?php endif; ?>
                            <div>
                                <a href="blog-detail.php?slug=<?= urlencode($r['slug']) ?>">
                                    <?= htmlspecialchars($r['title']) ?>
                                </a>
                                <small><?= date('d M Y', strtotime($r['created_at'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div style="margin-top:40px;padding:24px;background:#fff;border:1px solid rgba(0,0,0,0.06)">
                    <p style="font-family:'Cinzel',serif;font-size:.75rem;letter-spacing:2px;color:#0a0a0a;margin-bottom:10px">BÜLTENIMIZE KATIL</p>
                    <p style="font-size:.78rem;color:#888;margin-bottom:16px;line-height:1.6">Yeni koleksiyonlar ve sektörel haberlerden ilk haberdar olun.</p>
                    <form id="sidebarNewsletterForm">
                        <input type="email" name="email" placeholder="E-posta adresiniz"
                               style="width:100%;border:none;border-bottom:1px solid rgba(0,0,0,0.15);padding:8px 0;font-family:'Montserrat',sans-serif;font-size:.8rem;outline:none;background:transparent;margin-bottom:14px">
                        <button type="submit"
                                style="width:100%;background:#0a0a0a;color:#fff;border:none;padding:10px;font-family:'Montserrat',sans-serif;font-size:.68rem;letter-spacing:2px;text-transform:uppercase;cursor:pointer">
                            KAYDOL
                        </button>
                        <div id="snStatus" style="font-size:.72rem;margin-top:8px;display:none"></div>
                    </form>
                </div>
            </aside>
        </div>
    </section>

    <footer class="luxury-footer" style="padding-top:60px">
        <div class="footer-intro" style="max-width:640px;margin-bottom:28px">
            <h3 style="font-family:'Cinzel',serif;font-size:1.6rem;letter-spacing:.08em;margin-bottom:10px">LIVOLIA TEKSTİL</h3>
            <p style="font-size:1rem;color:#3b3b3b;line-height:1.75">Yeni koleksiyonlar, üretim yaklaşımımız ve sektörel gelişmeler için bizimle bağlantıda kalın.</p>
        </div>
        <div class="footer-main">
            <div class="footer-col" style="flex:2">
                <h5>İLETİŞİM</h5>
                <div class="footer-links">
                    <a href="mailto:info@livolia.com.tr" class="footer-link">info@livolia.com.tr</a>
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
        <div style="text-align:center;padding:30px 6vw;border-top:1px solid rgba(0,0,0,0.08);margin-top:40px">
            <small style="color:rgba(0,0,0,0.56);font-size:.86rem;letter-spacing:1.6px">
                &copy; <?= date('Y') ?> LIVOLIA TEKSTİL — TÜM HAKLARI SAKLIDIR
            </small>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        const cursor = document.querySelector('.cursor-dot');
        document.addEventListener('mousemove', e => {
            gsap.to(cursor, { x: e.clientX, y: e.clientY, duration: 0.1 });
        });
        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('grow'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('grow'));
        });

        // Sidebar newsletter
        const snForm = document.getElementById('sidebarNewsletterForm');
        if (snForm) {
            snForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const data = new FormData(this);
                const st   = document.getElementById('snStatus');
                fetch('<?= BASE_URL ?>/newsletter_subscribe.php', { method: 'POST', body: data })
                    .then(r => r.json())
                    .then(res => {
                        st.style.display = 'block';
                        st.style.color   = res.success ? '#10b981' : '#ef4444';
                        st.textContent   = res.message;
                        if (res.success) snForm.reset();
                    });
            });
        }
    </script>
</body>

</html>
