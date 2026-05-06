<?php
require_once 'inc/config.php';
require_once 'inc/Database.php';
require_once 'inc/functions.php';

$db = Database::getInstance();

// Pagination
$page     = max(1, (int) ($_GET['page'] ?? 1));
$perPage  = 9;
$offset   = ($page - 1) * $perPage;
$cat      = isset($_GET['cat']) ? (int) $_GET['cat'] : 0;

$catWhere = $cat ? 'AND p.category_id = ?' : '';
$params   = $cat ? [$cat] : [];

$totalRow = $db->fetchOne(
    "SELECT COUNT(*) AS cnt FROM blog_posts p WHERE p.status = 1 {$catWhere}",
    $params
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
    array_merge($params, [$perPage, $offset])
);

$categories = $db->fetchAll('SELECT id, name FROM blog_categories ORDER BY name');

$pageTitle = "Blog";
$activePage = "blog";

include 'inc/header.php';
?>

<main>
    <!-- Hero -->
    <section class="page-hero">
        <div class="page-hero-bg" style="background-image: url('<?= THEME_URL ?>/assets/img/hero.jpg');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content gsap-reveal">
            <span class="section-label" style="color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.3);" data-i18n="blog.hero_label">BLOG</span>
            <h1 style="color: #fff; margin-top: 1.5rem;" data-i18n="blog.hero_title">Tekstil Dünyasından Hikayeler</h1>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>" data-i18n="breadcrumb.home">Ana Sayfa</a> / <span data-i18n="nav.blog">Blog</span>
    </div>

    <!-- Category Filter -->
    <div style="padding: 30px 5%; background: #f9f8f6; border-bottom: 1px solid var(--c-gray-border); display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
        <a href="blog.php" class="<?= !$cat ? 'nav-btn' : 'nav-btn-outline' ?>" style="font-size: 10px; padding: 10px 25px; border-radius: 4px; text-decoration: none; <?= !$cat ? 'background: var(--c-dark); color: white;' : 'color: var(--c-dark); border: 1px solid var(--c-dark);' ?>" data-i18n="blog.all">Tümü</a>
        <?php foreach ($categories as $c): ?>
            <a href="blog.php?cat=<?= $c['id'] ?>"
               class="<?= $cat === (int)$c['id'] ? 'nav-btn' : 'nav-btn-outline' ?>"
               style="font-size: 10px; padding: 10px 25px; border-radius: 4px; text-decoration: none; <?= $cat === (int)$c['id'] ? 'background: var(--c-dark); color: white;' : 'color: var(--c-dark); border: 1px solid var(--c-dark);' ?>">
                <?= htmlspecialchars($c['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Posts Section -->
    <section class="page-content" style="background: #f9f8f6;">
        <?php if (empty($posts)): ?>
            <div style="text-align: center; padding: 80px 0; color: var(--c-gray-text);" data-i18n="blog.empty">
                Henüz yayınlanmış yazı bulunmuyor.
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 40px;">
                <?php foreach ($posts as $post): ?>
                    <article class="gsap-reveal" style="background: white; border: 1px solid var(--c-gray-border); transition: transform 0.3s;">
                        <a href="blog-detail.php?slug=<?= urlencode($post['slug']) ?>" style="display: block; overflow: hidden;">
                            <?php $postImageUrl = blog_image_url($post['image'] ?? null); ?>
                            <?php if ($postImageUrl): ?>
                                <img src="<?= htmlspecialchars($postImageUrl) ?>"
                                     alt="<?= htmlspecialchars($post['title']) ?>"
                                     style="width: 100%; aspect-ratio: 16/10; object-fit: cover; transition: transform 0.5s;"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            <?php else: ?>
                                <div style="width: 100%; aspect-ratio: 16/10; background: var(--c-dark); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.1); font-family: var(--font-display); font-size: 1.5rem;">LIVOLIA</div>
                            <?php endif; ?>
                        </a>
                        <div style="padding: 25px;">
                            <div style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-accent); margin-bottom: 12px; display: flex; gap: 10px; align-items: center;">
                                <?php if ($post['category_name']): ?>
                                    <span><?= htmlspecialchars($post['category_name']) ?></span>
                                    <span style="opacity: 0.3;">|</span>
                                <?php endif; ?>
                                <span style="color: var(--c-gray-text);"><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                            </div>
                            <h3 style="font-size: 1.35rem; margin-bottom: 20px; line-height: 1.4; color: var(--c-dark);"><?= htmlspecialchars($post['title']) ?></h3>
                            <a href="blog-detail.php?slug=<?= urlencode($post['slug']) ?>" style="font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--c-dark); text-decoration: none; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 3px;" data-i18n="blog.read_more">Devamını Oku →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 60px;">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $cat ? "&cat={$cat}" : '' ?>" style="width: 40px; height: 40px; border: 1px solid var(--c-gray-border); display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--c-dark);">‹</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i === $page): ?>
                            <span style="width: 40px; height: 40px; background: var(--c-dark); color: white; display: flex; align-items: center; justify-content: center;"><?= $i ?></span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?><?= $cat ? "&cat={$cat}" : '' ?>" style="width: 40px; height: 40px; border: 1px solid var(--c-gray-border); display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--c-dark);"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $cat ? "&cat={$cat}" : '' ?>" style="width: 40px; height: 40px; border: 1px solid var(--c-gray-border); display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--c-dark);">›</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
