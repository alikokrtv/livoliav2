<?php
/**
 * admin/modules/contacts/ajax.php
 */

function contacts_list(): void
{
    Auth::requirePermission('contacts', 'can_view');
    $rows = Database::getInstance()->fetchAll(
        'SELECT id, name, email, subject, is_read, replied_at, created_at FROM contact_messages ORDER BY created_at DESC'
    );
    Response::success(['data' => $rows]);
}

function contacts_get(): void
{
    Auth::requirePermission('contacts', 'can_view');
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id) Response::error('Geçersiz ID.');

    $db  = Database::getInstance();
    $msg = $db->fetchOne('SELECT * FROM contact_messages WHERE id = ?', [$id]);
    if (!$msg) Response::error('Mesaj bulunamadı.');

    // Okundu olarak işaretle
    $db->execute('UPDATE contact_messages SET is_read = 1 WHERE id = ?', [$id]);

    Response::success(['data' => $msg]);
}

function contacts_reply(): void
{
    Auth::requirePermission('contacts', 'can_edit');
    $id    = (int) ($_POST['id'] ?? 0);
    $reply = trim($_POST['reply'] ?? '');

    if (!$id)    Response::error('Geçersiz ID.');
    if (!$reply) Response::error('Cevap metni boş olamaz.');

    $db  = Database::getInstance();
    $msg = $db->fetchOne('SELECT * FROM contact_messages WHERE id = ?', [$id]);
    if (!$msg) Response::error('Mesaj bulunamadı.');

    // Mail gönder
    $headers  = "From: Livolia <" . (defined('MAIL_FROM') ? MAIL_FROM : 'noreply@livolia.com.tr') . ">\r\n";
    $headers .= "Reply-To: info@livolia.com.tr\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "MIME-Version: 1.0\r\n";

    $subject = 'Re: ' . $msg['subject'];
    $body    = '<!DOCTYPE html><html><body style="font-family:sans-serif;color:#1A1916;max-width:600px;margin:0 auto;padding:20px">'
        . '<h2 style="font-family:Georgia,serif;color:#A88C6F;letter-spacing:2px">LIVOLIA</h2>'
        . '<hr style="border-color:#E8E2DB">'
        . '<p>Sayın ' . htmlspecialchars($msg['name']) . ',</p>'
        . '<p>' . nl2br(htmlspecialchars($reply)) . '</p>'
        . '<hr style="border-color:#E8E2DB;margin-top:32px">'
        . '<small style="color:#9B9590">Livolia Tekstil — info@livolia.com.tr</small>'
        . '</body></html>';

    @mail($msg['email'], $subject, $body, $headers);

    // DB güncelle
    $db->execute(
        'UPDATE contact_messages SET reply_text = ?, replied_at = CURRENT_TIMESTAMP, is_read = 1 WHERE id = ?',
        [$reply, $id]
    );

    Response::success([], 'Cevap gönderildi.');
}

function contacts_delete(): void
{
    Auth::requirePermission('contacts', 'can_delete');
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id) Response::error('Geçersiz ID.');
    Database::getInstance()->execute('DELETE FROM contact_messages WHERE id = ?', [$id]);
    Response::success([], 'Mesaj silindi.');
}
