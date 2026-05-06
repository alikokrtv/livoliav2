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

$pageTitle = $post['title'];
$pageDesc  = mb_substr(strip_tags($post['content'] ?? ''), 0, 160);
$activePage = "blog";

include 'inc/header.php';
?>

<main>
    <!-- Post Hero -->
    <section class="page-hero">
        <div class="page-hero-bg" style="background-image: url('<?= blog_image_url($post['image']) ?>');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content gsap-reveal">
            <div style="font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--c-accent); margin-bottom: 20px; display: flex; gap: 15px; align-items: center;">
                <?php if ($post['category_name']): ?>
                    <span><?= htmlspecialchars($post['category_name']) ?></span>
                    <span style="opacity: 0.3;">|</span>
                <?php endif; ?>
                <span style="color: rgba(255,255,255,0.7);"><?= date('d F Y', strtotime($post['created_at'])) ?></span>
            </div>
            <h1 style="color: #fff; line-height: 1.25;"><?= htmlspecialchars($post['title']) ?></h1>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>" data-i18n="breadcrumb.home">Ana Sayfa</a> / <a href="blog.php" data-i18n="nav.blog">Blog</a> / <?= htmlspecialchars($post['title']) ?>
    </div>

    <!-- Post Body -->
    <section class="page-content" style="background: #f9f8f6;">
        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 80px; max-width: 1200px; margin: 0 auto;">
            
            <!-- Main Content -->
            <div class="gsap-reveal">
                <a href="blog.php" style="display: inline-flex; align-items: center; gap: 10px; font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--c-gray-text); text-decoration: none; margin-bottom: 40px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 5px;" data-i18n="blog.back">← Tüm Yazılar</a>
                
                <div class="post-content" style="font-size: 1.08rem; line-height: 1.95; color: #333;">
                    <?= $post['content'] ?>
                </div>

                <!-- Share -->
                <div style="margin-top: 60px; padding-top: 30px; border-top: 1px solid var(--c-gray-border); display: flex; align-items: center; gap: 20px;">
                    <span style="font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--c-accent);" data-i18n="blog.share">Paylaş</span>
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode(BASE_URL . '/blog-detail.php?slug=' . $post['slug']) ?>" target="_blank" style="font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-dark); text-decoration: none; border: 1px solid var(--c-gray-border); padding: 8px 15px;">Twitter</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(BASE_URL . '/blog-detail.php?slug=' . $post['slug']) ?>" target="_blank" style="font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-dark); text-decoration: none; border: 1px solid var(--c-gray-border); padding: 8px 15px;">LinkedIn</a>
                    <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' ' . BASE_URL . '/blog-detail.php?slug=' . $post['slug']) ?>" target="_blank" style="font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-dark); text-decoration: none; border: 1px solid var(--c-gray-border); padding: 8px 15px;">WhatsApp</a>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="gsap-reveal">
                <?php if (!empty($related)): ?>
                    <h4 style="font-size: 12px; letter-spacing: 0.25em; text-transform: uppercase; color: var(--c-dark); border-bottom: 1px solid var(--c-dark); padding-bottom: 15px; margin-bottom: 25px;" data-i18n="blog.related">İlgili Yazılar</h4>
                    <?php foreach ($related as $r): ?>
                        <div style="display: flex; gap: 15px; margin-bottom: 25px; align-items: flex-start;">
                            <img src="<?= blog_image_url($r['image']) ?>" alt="<?= htmlspecialchars($r['title']) ?>" style="width: 70px; aspect-ratio: 1; object-fit: cover; flex-shrink: 0;">
                            <div>
                                <a href="blog-detail.php?slug=<?= urlencode($r['slug']) ?>" style="font-family: var(--font-display); font-size: 0.95rem; color: var(--c-dark); text-decoration: none; display: block; line-height: 1.4; margin-bottom: 5px;"><?= htmlspecialchars($r['title']) ?></a>
                                <small style="font-size: 11px; color: var(--c-gray-text);"><?= date('d M Y', strtotime($r['created_at'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div style="margin-top: 50px; padding: 30px; background: white; border: 1px solid var(--c-gray-border);">
                    <h5 style="font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--c-dark); margin-bottom: 15px;" data-i18n="sidebar_newsletter.title">BÜLTENİMİZE KATIL</h5>
                    <p style="font-size: 12px; color: var(--c-gray-text); line-height: 1.6; margin-bottom: 20px;" data-i18n="sidebar_newsletter.desc">Yeni koleksiyonlar ve sektörel haberlerden ilk haberdar olun.</p>
                    <form id="sidebarNewsletterForm">
                        <input type="email" name="email" data-i18n="sidebar_newsletter.placeholder" placeholder="E-posta adresiniz" style="width: 100%; padding: 10px 0; border: none; border-bottom: 1px solid #ddd; outline: none; margin-bottom: 20px; font-family: inherit; font-size: 13px;">
                        <button type="submit" style="width: 100%; background: var(--c-dark); color: white; border: none; padding: 12px; font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; cursor: pointer;" data-i18n="sidebar_newsletter.button">KAYDOL</button>
                        <div id="snStatus" style="font-size: 11px; margin-top: 10px; display: none;"></div>
                    </form>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php 
$extraScripts = <<<JS
<script>
    const snForm = document.getElementById('sidebarNewsletterForm');
    if (snForm) {
        snForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const data = new FormData(this);
            const st   = document.getElementById('snStatus');
            st.style.display = 'block';
            st.textContent = '...';
            
            fetch('newsletter_subscribe.php', { method: 'POST', body: data })
                .then(r => r.json())
                .then(res => {
                    st.style.color = res.success ? '#10b981' : '#ef4444';
                    st.textContent = res.success ? t('newsletter.success') : (res.message || t('newsletter.error'));
                    if (res.success) snForm.reset();
                })
                .catch(() => {
                    st.style.color = '#ef4444';
                    st.textContent = t('newsletter.error');
                });
        });
    }
</script>
JS;

include 'inc/footer.php'; 
?>
