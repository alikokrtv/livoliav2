<?php
/**
 * admin/modules/media/index.php — Görsel Yönetimi
 */
Auth::requirePermission('media', 'can_view');

$pageTitle = 'Görsel Yönetimi';
$currentModule = 'media';

// Asset directory
$uploadDir = ROOT . '/theme/assets/img';
$uploadUrl = THEME_URL . '/assets/img';

// Handle delete
if (isset($_GET['delete'])) {
    $file = basename($_GET['delete']);
    $filePath = $uploadDir . '/' . $file;
    if (file_exists($filePath) && !is_dir($filePath)) {
        unlink($filePath);
        redirect(ADMIN_URL . '/media?status=deleted');
    }
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($ext, $allowed)) {
        $newName = time() . '_' . $file['name'];
        if (move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $newName)) {
            redirect(ADMIN_URL . '/media?status=uploaded');
        }
    }
}

// Scan files
$files = array_diff(scandir($uploadDir), array('..', '.', 'blog', '.htaccess'));

require_once ADMIN_PATH . '/views/layout.php';
?>

<div class="card mb-5">
    <div class="card-header">
        <h3 class="card-title">Görsel Yükle</h3>
    </div>
    <div class="card-body">
        <form action="<?= ADMIN_URL ?>/media" method="POST" enctype="multipart/form-data">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <input type="file" name="file" class="form-control" required accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted mt-2 d-block">İzin verilen formatlar: JPG, PNG, WEBP. Maksimum 5MB.</small>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Yükle</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title"><span class="card-label fw-bold fs-3">Kütüphane</span></h3>
    </div>
    <div class="card-body">
        <div class="row g-6">
            <?php foreach ($files as $f): 
                $fUrl = $uploadUrl . '/' . $f;
                $size = round(filesize($uploadDir . '/' . $f) / 1024, 2);
            ?>
                <div class="col-md-3 col-xl-2">
                    <div class="lv-media-card border rounded p-3 text-center h-100 d-flex flex-column">
                        <div class="mb-3" style="height: 120px; overflow: hidden; border-radius: 4px; background: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                            <img src="<?= $fUrl ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="lv-media-info mb-3">
                            <div class="text-truncate fw-bold fs-7 mb-1" title="<?= $f ?>"><?= $f ?></div>
                            <div class="text-muted fs-8"><?= $size ?> KB</div>
                        </div>
                        <div class="mt-auto d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-light-primary" onclick="copyToClipboard('<?= $fUrl ?>')" title="Linki Kopyala">
                                <i class="ki-duotone ki-copy fs-5 p-0"></i>
                            </button>
                            <a href="<?= ADMIN_URL ?>/media?delete=<?= $f ?>" class="btn btn-sm btn-light-danger" onclick="return confirm('Bu görseli silmek istediğinize emin misiniz?')" title="Sil">
                                <i class="ki-duotone ki-trash fs-5 p-0"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php 
$extraScripts = <<<JS
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            text: 'Görsel yolu panoya kopyalandı!',
            icon: 'success',
            buttonsStyling: false,
            confirmButtonText: 'Tamam',
            customClass: { confirmButton: 'btn btn-primary' }
        });
    });
}
</script>
JS;

require_once ADMIN_PATH . '/views/footer.php'; 
?>
