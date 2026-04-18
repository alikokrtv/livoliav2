<?php
/**
 * admin/modules/members/ajax.php — Üye AJAX Handler
 */

function members_list(): void
{
    $db = Database::getInstance();
    $rows = $db->fetchAll(
        'SELECT u.id, u.name, u.email, u.status, u.created_at, r.name AS role_name
         FROM users u LEFT JOIN roles r ON r.id = u.role_id
         ORDER BY u.id DESC'
    );
    Response::success(['data' => $rows]);
}

function members_get(): void
{
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');

    $db = Database::getInstance();
    $user = $db->fetchOne('SELECT id, name, email, role_id, status FROM users WHERE id = ?', [$id]);

    if (!$user)
        Response::error('Üye bulunamadı.', 404);
    Response::success($user);
}

function members_store(): void
{
    Auth::requirePermission('members', 'can_add');

    $name = post('name');
    $email = post('email');
    $password = $_POST['password'] ?? '';
    $roleId = (int) post('role_id');
    $status = (int) post('status');

    $errors = [];
    if (empty($name))
        $errors[] = 'Ad Soyad zorunludur.';
    if (empty($email))
        $errors[] = 'E-posta zorunludur.';
    if (empty($password))
        $errors[] = 'Şifre zorunludur.';
    if (!$roleId)
        $errors[] = 'Rol seçiniz.';
    if ($errors)
        Response::validationError($errors);

    $db = Database::getInstance();

    // E-posta tekrar kontrolü
    if ($db->fetchOne('SELECT id FROM users WHERE email = ?', [$email])) {
        Response::error('Bu e-posta zaten kayıtlı.');
    }

    $db->execute(
        'INSERT INTO users (name, email, password, role_id, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())',
        [$name, $email, password_hash($password, PASSWORD_DEFAULT), $roleId, $status]
    );

    Response::success(null, 'Üye başarıyla eklendi.');
}

function members_update(): void
{
    Auth::requirePermission('members', 'can_edit');

    $id = (int) post('id');
    $name = post('name');
    $email = post('email');
    $password = $_POST['password'] ?? '';
    $roleId = (int) post('role_id');
    $status = (int) post('status');

    if (!$id)
        Response::error('Geçersiz ID.');

    $errors = [];
    if (empty($name))
        $errors[] = 'Ad Soyad zorunludur.';
    if (empty($email))
        $errors[] = 'E-posta zorunludur.';
    if ($errors)
        Response::validationError($errors);

    $db = Database::getInstance();

    // E-posta tekrar kontrolü (kendisi hariç)
    if ($db->fetchOne('SELECT id FROM users WHERE email = ? AND id != ?', [$email, $id])) {
        Response::error('Bu e-posta başka bir üyeye ait.');
    }

    if (!empty($password)) {
        $db->execute(
            'UPDATE users SET name=?, email=?, password=?, role_id=?, status=? WHERE id=?',
            [$name, $email, password_hash($password, PASSWORD_DEFAULT), $roleId, $status, $id]
        );
    } else {
        $db->execute(
            'UPDATE users SET name=?, email=?, role_id=?, status=? WHERE id=?',
            [$name, $email, $roleId, $status, $id]
        );
    }

    Response::success(null, 'Üye başarıyla güncellendi.');
}

function members_delete(): void
{
    Auth::requirePermission('members', 'can_delete');

    $id = (int) ($_POST['id'] ?? 0);
    if (!$id)
        Response::error('Geçersiz ID.');

    // Kendi hesabını silemesin
    if ($id === Auth::user('id')) {
        Response::error('Kendi hesabınızı silemezsiniz.');
    }

    Database::getInstance()->execute('DELETE FROM users WHERE id = ?', [$id]);
    Response::success(null, 'Üye başarıyla silindi.');
}
