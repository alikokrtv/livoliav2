<?php
/**
 * admin/modules/settings/index.php — Site Ayarları
 */
Auth::requirePermission('settings', 'can_view');

$pageTitle = 'Site Ayarları';
$currentModule = 'settings';

$db = Database::getInstance();

// Handle Save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    foreach ($_POST as $key => $value) {
        if ($key === '_csrf_token') continue;
        $db->execute('INSERT INTO settings (key, value) VALUES (?, ?) ON CONFLICT(key) DO UPDATE SET value = ?', [$key, $value, $value]);
    }
    redirect(ADMIN_URL . '/settings?status=saved');
}

// Fetch all settings
$settingsRaw = $db->fetchAll('SELECT * FROM settings');
$settings = [];
foreach ($settingsRaw as $s) {
    $settings[$s['key']] = $s['value'];
}

require_once ADMIN_PATH . '/views/layout.php';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Genel Yapılandırma</h3>
    </div>
    <div class="card-body">
        <form action="<?= ADMIN_URL ?>/settings" method="POST">
            <?= csrf_field() ?>
            
            <div class="row g-9 mb-8">
                <div class="col-md-6 fv-row">
                    <label class="required fs-6 fw-semibold mb-2">Site Başlığı</label>
                    <input type="text" class="form-control" name="site_title" value="<?= $settings['site_title'] ?? '' ?>" required>
                </div>
                <div class="col-md-6 fv-row">
                    <label class="required fs-6 fw-semibold mb-2">İletişim E-postası</label>
                    <input type="email" class="form-control" name="site_email" value="<?= $settings['site_email'] ?? '' ?>" required>
                </div>
            </div>

            <div class="row g-9 mb-8">
                <div class="col-md-6 fv-row">
                    <label class="fs-6 fw-semibold mb-2">Telefon Numarası</label>
                    <input type="text" class="form-control" name="site_phone" value="<?= $settings['site_phone'] ?? '' ?>">
                </div>
                <div class="col-md-6 fv-row">
                    <label class="fs-6 fw-semibold mb-2">WhatsApp Hızlı İletişim</label>
                    <input type="text" class="form-control" name="site_whatsapp" value="<?= $settings['site_whatsapp'] ?? '' ?>">
                </div>
            </div>

            <div class="fv-row mb-8">
                <label class="fs-6 fw-semibold mb-2">Firma Adresi</label>
                <textarea class="form-control" name="site_address" rows="3"><?= $settings['site_address'] ?? '' ?></textarea>
            </div>

            <div class="separator separator-dashed my-10"></div>
            
            <h4 class="mb-5">Sosyal Medya Linkleri</h4>
            <div class="row g-9 mb-8">
                <div class="col-md-4">
                    <label class="fs-6 fw-semibold mb-2">Instagram</label>
                    <input type="text" class="form-control" name="social_instagram" value="<?= $settings['social_instagram'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="fs-6 fw-semibold mb-2">LinkedIn</label>
                    <input type="text" class="form-control" name="social_linkedin" value="<?= $settings['social_linkedin'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="fs-6 fw-semibold mb-2">Pinterest</label>
                    <input type="text" class="form-control" name="social_pinterest" value="<?= $settings['social_pinterest'] ?? '' ?>">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-10">Ayarları Kaydet</button>
            </div>
        </form>
    </div>
</div>

<?php require_once ADMIN_PATH . '/views/footer.php'; ?>
