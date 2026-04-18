<?php
/**
 * admin/modules/roles/ajax.php — Rol AJAX Handler
 */

function roles_list(): void
{
    $rows = Database::getInstance()->fetchAll('SELECT * FROM roles ORDER BY id DESC');
    Response::success(['data' => $rows]);
}

function roles_get(): void
{
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');

    $db = Database::getInstance();
    $role = $db->fetchOne('SELECT * FROM roles WHERE id = ?', [$id]);
    if (!$role)
        Response::error('Rol bulunamadı.', 404);

    // İzinleri çek
    $permsRaw = $db->fetchAll('SELECT * FROM permissions WHERE role_id = ?', [$id]);
    $perms = [];
    foreach ($permsRaw as $p) {
        $perms[$p['module']] = [
            'can_view' => $p['can_view'],
            'can_add' => $p['can_add'],
            'can_edit' => $p['can_edit'],
            'can_delete' => $p['can_delete'],
        ];
    }

    Response::success(['role' => $role, 'perms' => $perms]);
}

function roles_store(): void
{
    Auth::requirePermission('roles', 'can_add');

    $name = post('name');
    $slug = slugify(post('slug') ?: post('name'));
    $description = post('description');

    if (empty($name) || empty($slug))
        Response::error('Rol adı ve slug zorunludur.');

    $db = Database::getInstance();
    if ($db->fetchOne('SELECT id FROM roles WHERE slug = ?', [$slug])) {
        Response::error('Bu slug zaten kullanılıyor.');
    }

    $db->execute(
        'INSERT INTO roles (name, slug, description) VALUES (?, ?, ?)',
        [$name, $slug, $description]
    );
    $roleId = $db->lastInsertId();

    // İzinleri kaydet
    roles_savePermissions($db, (int) $roleId);

    Response::success(null, 'Rol başarıyla eklendi.');
}

function roles_update(): void
{
    Auth::requirePermission('roles', 'can_edit');

    $id = (int) post('id');
    $name = post('name');
    $slug = slugify(post('slug') ?: post('name'));
    $description = post('description');

    if (!$id)
        Response::error('Geçersiz ID.');

    $db = Database::getInstance();
    $db->execute(
        'UPDATE roles SET name=?, slug=?, description=? WHERE id=?',
        [$name, $slug, $description, $id]
    );

    // Mevcut izinleri temizle ve yeniden kaydet
    $db->execute('DELETE FROM permissions WHERE role_id = ?', [$id]);
    roles_savePermissions($db, $id);

    Response::success(null, 'Rol başarıyla güncellendi.');
}

function roles_delete(): void
{
    Auth::requirePermission('roles', 'can_delete');

    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');

    $db = Database::getInstance();
    $db->execute('DELETE FROM permissions WHERE role_id = ?', [$id]);
    $db->execute('DELETE FROM roles WHERE id = ?', [$id]);

    Response::success(null, 'Rol başarıyla silindi.');
}

/** Yardımcı: POST'taki perms[] dizisini DB'ye yaz */
function roles_savePermissions(Database $db, int $roleId): void
{
    $perms = $_POST['perms'] ?? [];
    $modules = ['members', 'roles', 'pages', 'blog'];

    foreach ($modules as $mod) {
        $p = $perms[$mod] ?? [];
        $db->execute(
            'INSERT INTO permissions (role_id, module, can_view, can_add, can_edit, can_delete) VALUES (?, ?, ?, ?, ?, ?)',
            [
                $roleId,
                $mod,
                !empty($p['can_view']) ? 1 : 0,
                !empty($p['can_add']) ? 1 : 0,
                !empty($p['can_edit']) ? 1 : 0,
                !empty($p['can_delete']) ? 1 : 0,
            ]
        );
    }
}
