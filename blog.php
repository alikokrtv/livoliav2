<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';

$db = Database::getInstance();

// Pagination
$page     = max(1, (int) ($_GET['page'] ?? 1));
$perPage  = 9;
$offset   = ($page - 1) * $perPage;
$cat      = isset($_GET['cat']) ? (int) $_GET['cat'] : 0;

$catWhere = $cat ? 'AND p.category_id = ?' : '';
$params   = $cat ? [$catWhere !== '' ? $cat : null] : [];

$totalRow = $db->fetchOne(
    "SELECT COUNT(*) AS cnt FROM blog_posts p WHERE p.status = 1 {$catWhere}",
    $cat ? [$cat] : []
);
$total     = (int) ($totalRow['cnt'] ?? 0);
$totalPages = (int) ceil($total / $perPage);

$posts = $db->fetchAll(
    "SELECT p.id, p.title, p.slug, p.image, p.created_at,
            c.name AS category_name
     FROM blog_posts p
     LEFT JOIN blog_categories c ON c.id = p.category_id
     WHERE p.status = 1 {$catWhere}
     ORDER BY p.created_at DESC
     LIMIT ? OFFSET ?",
    $cat ? [$cat, $perPage, $offset] : [$perPage, $offset]
);

$categories = $db->fetchAll('SELECT id, name FROM blog_categories ORDER BY name');
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | <?= SITE_TITLE ?></title>
    <meta name="description" content="Livolia Tekstil Blog — Sektörel trendler, koleksiyon hikayeleri ve üretim süreçleri hakkında yazılar.">

    <!-- Open Graph -->
    <meta property="og:title" content="Blog | <?= SITE_TITLE ?>">
    <meta property="og:description" content="Sektörel trendler, koleksiyon hikayeleri ve üretim süreçleri.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= BASE_URL ?>/blog.php">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= THEME_URL ?>/assets/css/style.css">
    <style>
        /* ── Blog Page ── */
        .blog-hero {
            background-color: #0a0a0a;
            padding: 160px 6vw 70px;
        }

        .blog-hero-content span.label {
            display: block;
            font-size: 0.65rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #b59a7c;
            margin-bottom: 16px;
        }

        .blog-hero-content h1 {
            font-family: 'Cinzel', serif;
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 400;
            color: #f9f8f6;
            letter-spacing: 0.02em;
        }

        /* ── Category Filter ── */
        .blog-filter {
            padding: 32px 6vw 0;
            background: #f9f8f6;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            border-bottom: 1px solid rgba(0,0,0,0.07);
            padding-bottom: 24px;
        }

        .blog-filter a {
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            text-decoration: none;
            padding: 6px 16px;
            border: 1px solid rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .blog-filter a:hover,
        .blog-filter a.active {
            background: #0a0a0a;
            color: #f9f8f6;
            border-color: #0a0a0a;
        }

        /* ── Grid ── */
        .blog-section {
            padding: 60px 6vw 100px;
            background: #f9f8f6;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 32px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .blog-card {
            background: #fff;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .blog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }

        .blog-card-img {
            width: 100%;
            aspect-ratio: 16/10;
            object-fit: cover;
            display: block;
            background: #e8e2db;
        }

        .blog-card-img-placeholder {
            width: 100%;
            aspect-ratio: 16/10;
            background: linear-gradient(135deg, #1F1E1C 0%, #2D2B28 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blog-card-img-placeholder span {
            font-family: 'Cinzel', serif;
            font-size: 1.5rem;
            letter-spacing: 4px;
            color: rgba(255,255,255,0.15);
        }

        .blog-card-body {
            padding: 24px;
        }

        .blog-card-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .blog-card-cat {
            font-size: 0.62rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #b59a7c;
            font-weight: 600;
        }

        .blog-card-date {
            font-size: 0.68rem;
            color: #aaa;
        }

        .blog-card h3 {
            font-family: 'Cinzel', serif;
            font-size: 1.05rem;
            font-weight: 400;
            color: #0a0a0a;
            line-height: 1.4;
            letter-spacing: 0.01em;
            margin-bottom: 16px;
        }

        .blog-card-link {
            font-size: 0.68rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #0a0a0a;
            text-decoration: none;
            border-bottom: 1px solid rgba(0,0,0,0.2);
            padding-bottom: 2px;
            transition: color 0.3s, border-color 0.3s;
        }

        .blog-card-link:hover {
            color: #b59a7c;
            border-color: #b59a7c;
        }

        /* ── Empty State ── */
        .blog-empty {
            text-align: center;
            padding: 80px 0;
            color: #aaa;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }

        /* ── Pagination ── */
        .blog-pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 60px;
        }

        .blog-pagination a,
        .blog-pagination span {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            text-decoration: none;
            border: 1px solid rgba(0,0,0,0.1);
            color: #555;
            transition: all 0.2s;
        }

        .blog-pagination a:hover {
            background: #0a0a0a;
            color: #fff;
            border-color: #0a0a0a;
        }

        .blog-pagination span.current {
            background: #0a0a0a;
            color: #fff;
            border-color: #0a0a0a;
        }

        @media (max-width: 700px) {
            .blog-grid { grid-template-columns: 1fr; }
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

    <!-- Hero -->
    <section class="blog-hero">
        <div class="blog-hero-content">
            <span class="label">Blog</span>
            <h1>Tekstil Dünyasından<br>Hikayeler</h1>
        </div>
    </section>

    <!-- Category Filter -->
    <div class="blog-filter">
        <a href="blog.php" class="<?= !$cat ? 'active' : '' ?>">Tümü</a>
        <?php foreach ($categories as $c): ?>
            <a href="blog.php?cat=<?= $c['id'] ?>"
               class="<?= $cat === (int)$c['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($c['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Posts -->
    <section class="blog-section">
        <?php if (empty($posts)): ?>
            <div class="blog-empty">
                <p>Henüz yayınlanmış yazı bulunmuyor.</p>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($posts as $post): ?>
                    <article class="blog-card">
                        <a href="blog-detail.php?slug=<?= urlencode($post['slug']) ?>">
                            <?php if ($post['image']): ?>
                                <img src="<?= THEME_URL ?>/assets/img/blog/<?= htmlspecialchars($post['image']) ?>"
                                     alt="<?= htmlspecialchars($post['title']) ?>"
                                     class="blog-card-img"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="blog-card-img-placeholder">
                                    <span>LIVOLIA</span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <?php if ($post['category_name']): ?>
                                    <span class="blog-card-cat"><?= htmlspecialchars($post['category_name']) ?></span>
                                    <span style="color:#ddd">|</span>
                                <?php endif; ?>
                                <span class="blog-card-date">
                                    <?= date('d M Y', strtotime($post['created_at'])) ?>
                                </span>
                            </div>
                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                            <a href="blog-detail.php?slug=<?= urlencode($post['slug']) ?>" class="blog-card-link">
                                Devamını Oku →
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="blog-pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $cat ? "&cat={$cat}" : '' ?>">‹</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i === $page): ?>
                            <span class="current"><?= $i ?></span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?><?= $cat ? "&cat={$cat}" : '' ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $cat ? "&cat={$cat}" : '' ?>">›</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
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
        <div style="text-align:center;padding:30px 6vw;border-top:1px solid rgba(255,255,255,0.06);margin-top:40px">
            <small style="color:rgba(255,255,255,0.2);font-size:.68rem;letter-spacing:2px">
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
    </script>
</body>

</html>
