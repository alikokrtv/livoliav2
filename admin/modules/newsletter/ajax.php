<?php
/**
 * admin/modules/newsletter/ajax.php
 */

function newsletter_list(): void
{
    Auth::requirePermission('newsletter', 'can_view');
    $rows = Database::getInstance()->fetchAll(
        'SELECT id, email, status, created_at FROM newsletter_subscribers ORDER BY created_at DESC'
    );
    Response::success(['data' => $rows]);
}

function newsletter_toggle(): void
{
    Auth::requirePermission('newsletter', 'can_edit');
    $id     = (int) ($_POST['id'] ?? 0);
    $status = (int) ($_POST['status'] ?? 0);
    if (!$id) Response::error('Geçersiz ID.');
    Database::getInstance()->execute(
        'UPDATE newsletter_subscribers SET status = ? WHERE id = ?',
        [$status, $id]
    );
    Response::success([], 'Güncellendi.');
}

function newsletter_delete(): void
{
    Auth::requirePermission('newsletter', 'can_delete');
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id) Response::error('Geçersiz ID.');
    Database::getInstance()->execute('DELETE FROM newsletter_subscribers WHERE id = ?', [$id]);
    Response::success([], 'Abone silindi.');
}

function newsletter_send_bulk(): void
{
    Auth::requirePermission('newsletter', 'can_add');

    $subject = trim($_POST['subject'] ?? '');
    $body    = trim($_POST['body'] ?? '');

    if (!$subject || !$body) Response::error('Konu ve içerik zorunludur.');

    $subscribers = Database::getInstance()->fetchAll(
        'SELECT email FROM newsletter_subscribers WHERE status = 1'
    );

    if (empty($subscribers)) Response::error('Aktif abone bulunamadı.');

    $headers  = "From: Livolia <" . (defined('MAIL_FROM') ? MAIL_FROM : 'noreply@livolia.com.tr') . ">\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "MIME-Version: 1.0\r\n";

    $sent   = 0;
    $failed = 0;
    foreach ($subscribers as $sub) {
        $htmlBody = '<!DOCTYPE html><html><body style="font-family:sans-serif;color:#1A1916;max-width:600px;margin:0 auto;padding:20px">'
            . '<h2 style="font-family:Georgia,serif;color:#A88C6F;letter-spacing:2px">LIVOLIA</h2>'
            . '<hr style="border-color:#E8E2DB">'
            . nl2br(htmlspecialchars_decode(htmlspecialchars($body)))
            . '<hr style="border-color:#E8E2DB;margin-top:40px">'
            . '<small style="color:#9B9590">Bu e-postayı almak istemiyorsanız <a href="' . BASE_URL . '/newsletter_unsubscribe.php?email=' . urlencode($sub['email']) . '" style="color:#A88C6F">aboneliğinizi iptal edin</a>.</small>'
            . '</body></html>';

        if (@mail($sub['email'], $subject, $htmlBody, $headers)) {
            $sent++;
        } else {
            $failed++;
        }
    }

    Response::success([], "{$sent} aboneye gönderildi" . ($failed ? ", {$failed} başarısız." : '.'));
}
