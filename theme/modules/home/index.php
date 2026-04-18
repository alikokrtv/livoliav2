<?php
/**
 * theme/modules/home/index.php — Ana Sayfa
 */
$pageTitle = 'Ana Sayfa';

require_once THEME_PATH . '/views/header.php';
?>
<section class="hero py-5 text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">
            <?= SITE_TITLE ?>
        </h1>
        <p class="lead text-muted">Kurumsal web sitenize hoş geldiniz.</p>
    </div>
</section>

<?php
// Son blog yazıları
$db = Database::getInstance();
$posts = $db->fetchAll(
    'SELECT p.id, p.title, p.slug, p.created_at, c.name AS cat
     FROM blog_posts p
     LEFT JOIN blog_categories c ON c.id = p.category_id
     WHERE p.status = 1
     ORDER BY p.id DESC LIMIT 3'
);
if ($posts):
    ?>
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">Son Blog Yazıları</h2>
            <div class="row g-4">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">
                                    <?= htmlspecialchars($post['cat'] ?? 'Genel') ?>
                                </span>
                                <h5 class="card-title">
                                    <?= htmlspecialchars($post['title']) ?>
                                </h5>
                                <p class="text-muted small">
                                    <?= format_date($post['created_at']) ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="<?= BASE_URL ?>/blog/<?= $post['slug'] ?>"
                                    class="btn btn-sm btn-outline-primary">Devamını Oku</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require_once THEME_PATH . '/views/footer.php'; ?>