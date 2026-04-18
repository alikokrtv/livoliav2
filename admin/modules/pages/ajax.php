<?php
/**
 * admin/modules/pages/ajax.php — Sayfa AJAX Handler
 */

function pages_list(): void
{
    $rows = Database::getInstance()->fetchAll(
        'SELECT id, title, slug, status, created_at FROM pages ORDER BY id DESC'
    );
    Response::success(['data' => $rows]);
}

function pages_get(): void
{
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');
    $page = Database::getInstance()->fetchOne('SELECT * FROM pages WHERE id = ?', [$id]);
    if (!$page)
        Response::error('Sayfa bulunamadı.', 404);
    Response::success($page);
}

function pages_store(): void
{
    Auth::requirePermission('pages', 'can_add');

    $title = post('title');
    $slug = slugify(post('slug') ?: post('title'));
    $content = $_POST['content'] ?? '';
    $metaT = post('meta_title');
    $metaD = post('meta_desc');
    $status = (int) post('status');

    if (empty($title))
        Response::error('Sayfa başlığı zorunludur.');

    $db = Database::getInstance();
    if ($db->fetchOne('SELECT id FROM pages WHERE slug = ?', [$slug])) {
        Response::error('Bu slug zaten kullanılıyor.');
    }

    $db->execute(
        'INSERT INTO pages (title, slug, content, meta_title, meta_desc, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())',
        [$title, $slug, $content, $metaT, $metaD, $status]
    );

    Response::success(null, 'Sayfa başarıyla eklendi.');
}

function pages_update(): void
{
    Auth::requirePermission('pages', 'can_edit');

    $id = (int) post('id');
    $title = post('title');
    $slug = slugify(post('slug') ?: post('title'));
    $content = $_POST['content'] ?? '';
    $metaT = post('meta_title');
    $metaD = post('meta_desc');
    $status = (int) post('status');

    if (!$id)
        Response::error('Geçersiz ID.');

    $db = Database::getInstance();
    if ($db->fetchOne('SELECT id FROM pages WHERE slug = ? AND id != ?', [$slug, $id])) {
        Response::error('Bu slug başka bir sayfada kullanılıyor.');
    }

    $db->execute(
        'UPDATE pages SET title=?, slug=?, content=?, meta_title=?, meta_desc=?, status=? WHERE id=?',
        [$title, $slug, $content, $metaT, $metaD, $status, $id]
    );

    Response::success(null, 'Sayfa başarıyla güncellendi.');
}

function pages_delete(): void
{
    Auth::requirePermission('pages', 'can_delete');

    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');
    Database::getInstance()->execute('DELETE FROM pages WHERE id = ?', [$id]);
    Response::success(null, 'Sayfa başarıyla silindi.');
}
