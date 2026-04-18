<?php
/**
 * admin/modules/newsletter/index.php — Bülten Aboneleri
 */
Auth::requirePermission('newsletter', 'can_view');

$pageTitle    = 'Bülten Aboneleri';
$currentModule = 'newsletter';
$pageActions  = '
<a href="' . ADMIN_URL . '/newsletter/export" class="btn btn-light btn-sm me-2">
  <i class="ki-duotone ki-arrow-down fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>CSV İndir
</a>
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mailModal">
  <i class="ki-duotone ki-send fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>Toplu Mail Gönder
</button>';

require_once ADMIN_PATH . '/views/layout.php';

// CSV export
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    $db   = Database::getInstance();
    $rows = $db->fetchAll('SELECT email, status, created_at FROM newsletter_subscribers ORDER BY created_at DESC');
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="newsletter_subscribers_' . date('Ymd') . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['E-posta', 'Durum', 'Kayıt Tarihi']);
    foreach ($rows as $r) {
        fputcsv($out, [$r['email'], $r['status'] ? 'Aktif' : 'Pasif', $r['created_at']]);
    }
    fclose($out);
    exit;
}
?>
<div class="card">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title"><span class="card-label fw-bold fs-3">Aboneler</span></h3>
    </div>
    <div class="card-body py-4">
        <table id="subscriberTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                    <th>#</th>
                    <th>E-posta</th>
                    <th>Durum</th>
                    <th>Kayıt Tarihi</th>
                    <th class="text-end">İşlem</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Toplu Mail Modal -->
<div class="modal fade" id="mailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Toplu E-posta Gönder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="mailForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="module" value="newsletter">
                    <input type="hidden" name="action" value="send_bulk">
                    <div class="mb-4">
                        <label class="form-label required">Konu</label>
                        <input type="text" name="subject" class="form-control" placeholder="E-posta konusu" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label required">İçerik</label>
                        <textarea name="body" class="form-control" rows="8"
                            placeholder="HTML veya düz metin içerik girebilirsiniz." required></textarea>
                    </div>
                    <div class="alert alert-warning d-flex align-items-center gap-2 py-3">
                        <i class="ki-duotone ki-information fs-4 text-warning">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                        </i>
                        <small>Bu işlem tüm <strong>aktif</strong> abonelere mail gönderir. Sunucunun
                            <code>mail()</code> fonksiyonunun aktif olması gerekir.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="sendMailBtn">
                    <i class="ki-duotone ki-send fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
$(document).ready(function() {
    var tbl = $('#subscriberTable').DataTable({
        processing: true,
        ajax: { url: AJAX_URL, type: 'POST',
            data: { module: 'newsletter', action: 'list', _csrf_token: CSRF_TOKEN }},
        columns: [
            { data: 'id' },
            { data: 'email' },
            { data: 'status', render: function(d) {
                return d == 1
                    ? '<span class="badge badge-light-success">Aktif</span>'
                    : '<span class="badge badge-secondary">Pasif</span>';
            }},
            { data: 'created_at' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                var toggle = d.status == 1
                    ? '<button class="btn btn-sm btn-light-warning me-1" onclick="toggleSub(' + d.id + ',0)" title="Pasife Al"><i class="ki-duotone ki-cross fs-5"><span class="path1"></span><span class="path2"></span></i></button>'
                    : '<button class="btn btn-sm btn-light-success me-1" onclick="toggleSub(' + d.id + ',1)" title="Aktife Al"><i class="ki-duotone ki-check fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
                return toggle
                    + '<button class="btn btn-sm btn-light-danger" onclick="deleteSub(' + d.id + ')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });

    function toggleSub(id, status) {
        $.post(AJAX_URL, { module: 'newsletter', action: 'toggle', id: id, status: status, _csrf_token: CSRF_TOKEN },
            function(r) { tbl.ajax.reload(); });
    }
    window.toggleSub = toggleSub;

    window.deleteSub = function(id) {
        Swal.fire({ title: 'Emin misiniz?', text: 'Abone silinecek.', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Evet, Sil', cancelButtonText: 'İptal',
            confirmButtonColor: '#ef4444'
        }).then(function(r) {
            if (!r.isConfirmed) return;
            $.post(AJAX_URL, { module: 'newsletter', action: 'delete', id: id, _csrf_token: CSRF_TOKEN },
                function(res) {
                    if (res.success) tbl.ajax.reload();
                    else Swal.fire('Hata', res.message, 'error');
                });
        });
    };

    $('#sendMailBtn').on('click', function() {
        var data = new FormData(document.getElementById('mailForm'));
        $.ajax({ url: AJAX_URL, type: 'POST', data: data, processData: false, contentType: false,
            success: function(r) {
                if (r.success) { Swal.fire('Gönderildi!', r.message, 'success'); $('#mailModal').modal('hide'); document.getElementById('mailForm').reset(); }
                else Swal.fire('Hata', r.message, 'error');
            }
        });
    });
});
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>
