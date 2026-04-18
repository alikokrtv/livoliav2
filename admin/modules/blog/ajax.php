<?php
/**
 * admin/modules/blog/ajax.php — Blog AJAX Handler
 */

function blog_list(): void
{
    $rows = Database::getInstance()->fetchAll(
        'SELECT p.id, p.title, p.slug, p.status, p.created_at, c.name AS category_name
         FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id
         ORDER BY p.id DESC'
    );
    Response::success(['data' => $rows]);
}

function blog_get(): void
{
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');
    $post = Database::getInstance()->fetchOne('SELECT * FROM blog_posts WHERE id = ?', [$id]);
    if (!$post)
        Response::error('Yazı bulunamadı.', 404);
    Response::success($post);
}

function blog_store(): void
{
    Auth::requirePermission('blog', 'can_add');

    $title = post('title');
    $slug = slugify(post('slug') ?: post('title'));
    $content = $_POST['content'] ?? '';
    $categoryId = (int) post('category_id');
    $status = (int) post('status');

    if (empty($title))
        Response::error('Başlık zorunludur.');
    if (!$categoryId)
        Response::error('Kategori seçiniz.');

    $db = Database::getInstance();
    if ($db->fetchOne('SELECT id FROM blog_posts WHERE slug = ?', [$slug])) {
        Response::error('Bu slug zaten kullanılıyor.');
    }

    // Görsel yükleme
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = ROOT . '/theme/assets/img/blog/';
        $image = upload_file($_FILES['image'], $uploadDir);
        if ($image === false)
            Response::error('Geçersiz dosya türü. (jpg, png, gif, webp)');
    }

    $db->execute(
        'INSERT INTO blog_posts (category_id, title, slug, content, image, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())',
        [$categoryId, $title, $slug, $content, $image, $status]
    );

    Response::success(null, 'Blog yazısı başarıyla eklendi.');
}

function blog_update(): void
{
    Auth::requirePermission('blog', 'can_edit');

    $id = (int) post('id');
    $title = post('title');
    $slug = slugify(post('slug') ?: post('title'));
    $content = $_POST['content'] ?? '';
    $categoryId = (int) post('category_id');
    $status = (int) post('status');

    if (!$id)
        Response::error('Geçersiz ID.');

    $db = Database::getInstance();
    if ($db->fetchOne('SELECT id FROM blog_posts WHERE slug = ? AND id != ?', [$slug, $id])) {
        Response::error('Bu slug başka bir yazıda kullanılıyor.');
    }

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = ROOT . '/theme/assets/img/blog/';
        $image = upload_file($_FILES['image'], $uploadDir);
        if ($image === false)
            Response::error('Geçersiz dosya türü.');
    }

    if ($image) {
        $db->execute(
            'UPDATE blog_posts SET category_id=?, title=?, slug=?, content=?, image=?, status=? WHERE id=?',
            [$categoryId, $title, $slug, $content, $image, $status, $id]
        );
    } else {
        $db->execute(
            'UPDATE blog_posts SET category_id=?, title=?, slug=?, content=?, status=? WHERE id=?',
            [$categoryId, $title, $slug, $content, $status, $id]
        );
    }

    Response::success(null, 'Blog yazısı başarıyla güncellendi.');
}

function blog_delete(): void
{
    Auth::requirePermission('blog', 'can_delete');

    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');
    Database::getInstance()->execute('DELETE FROM blog_posts WHERE id = ?', [$id]);
    Response::success(null, 'Yazı başarıyla silindi.');
}

// ─── Kategori Fonksiyonları ───────────────────────────────────────────

function blog_categories_list(): void
{
    $rows = Database::getInstance()->fetchAll('SELECT * FROM blog_categories ORDER BY name');
    Response::success(['data' => $rows]);
}

function blog_categories_store(): void
{
    Auth::requirePermission('blog', 'can_add');
    $name = post('name');
    $slug = slugify(post('slug') ?: post('name'));
    if (empty($name))
        Response::error('Kategori adı zorunludur.');
    Database::getInstance()->execute(
        'INSERT INTO blog_categories (name, slug) VALUES (?, ?)',
        [$name, $slug]
    );
    Response::success(null, 'Kategori eklendi.');
}

function blog_categories_delete(): void
{
    Auth::requirePermission('blog', 'can_delete');
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');
    Database::getInstance()->execute('DELETE FROM blog_categories WHERE id = ?', [$id]);
    Response::success(null, 'Kategori silindi.');
}
