<?php
/**
 * admin/modules/contacts/index.php — İletişim Mesajları
 */
Auth::requirePermission('contacts', 'can_view');

$pageTitle    = 'İletişim Mesajları';
$currentModule = 'contacts';

require_once ADMIN_PATH . '/views/layout.php';

$db = Database::getInstance();
$unread = $db->fetchOne('SELECT COUNT(*) AS cnt FROM contact_messages WHERE is_read = 0')['cnt'] ?? 0;
?>
<div class="card">
    <div class="card-header border-0 pt-6 d-flex align-items-center justify-content-between">
        <h3 class="card-title">
            <span class="card-label fw-bold fs-3">Mesajlar</span>
            <?php if ($unread > 0): ?>
                <span class="badge badge-light-danger ms-2"><?= $unread ?> okunmadı</span>
            <?php endif; ?>
        </h3>
    </div>
    <div class="card-body py-4">
        <table id="contactTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                    <th>#</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Konu</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Mesaj Detay Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mesaj Detayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="msgBody">
                <!-- Dinamik içerik -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" id="sendReplyBtn">
                    <i class="ki-duotone ki-send fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Cevap Gönder
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
var contactTable;
var currentMsgId = 0;

$(document).ready(function() {
    contactTable = $('#contactTable').DataTable({
        processing: true,
        ajax: { url: AJAX_URL, type: 'POST',
            data: { module: 'contacts', action: 'list', _csrf_token: CSRF_TOKEN }},
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'subject' },
            { data: 'is_read', render: function(d) {
                return d == 0
                    ? '<span class="badge badge-light-warning">Okunmadı</span>'
                    : '<span class="badge badge-light-success">Okundu</span>';
            }},
            { data: 'created_at' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                return '<button class="btn btn-sm btn-light-primary me-1" onclick="viewMsg(' + d.id + ')"><i class="ki-duotone ki-eye fs-5"><span class="path1"></span><span class="path2"></span></i></button>'
                     + '<button class="btn btn-sm btn-light-danger" onclick="deleteMsg(' + d.id + ')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        order: [[0, 'desc']],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });
});

function viewMsg(id) {
    currentMsgId = id;
    $.post(AJAX_URL, { module: 'contacts', action: 'get', id: id, _csrf_token: CSRF_TOKEN }, function(r) {
        if (!r.success) return;
        var d = r.data;
        var replied = d.replied_at
            ? '<div class="mt-4 p-3" style="background:#f0fdf4;border-radius:8px;border-left:3px solid #10b981"><small style="color:#10b981;font-weight:700;display:block;margin-bottom:6px">CEVAP GÖNDERİLDİ — ' + d.replied_at + '</small><p style="margin:0;font-size:.85rem">' + d.reply_text + '</p></div>'
            : '';
        $('#msgBody').html(
            '<div class="row g-3 mb-4">' +
            '<div class="col-sm-6"><small class="text-muted d-block mb-1" style="letter-spacing:1px;font-size:.68rem">AD SOYAD</small><strong>' + d.name + '</strong></div>' +
            '<div class="col-sm-6"><small class="text-muted d-block mb-1" style="letter-spacing:1px;font-size:.68rem">E-POSTA</small><a href="mailto:' + d.email + '">' + d.email + '</a></div>' +
            '<div class="col-12"><small class="text-muted d-block mb-1" style="letter-spacing:1px;font-size:.68rem">KONU</small><strong>' + d.subject + '</strong></div>' +
            '</div>' +
            '<div class="p-4" style="background:#fafaf9;border-radius:8px;border:1px solid #E8E2DB">' +
            '<small class="text-muted d-block mb-2" style="letter-spacing:1px;font-size:.68rem">MESAJ</small>' +
            '<p style="font-size:.875rem;line-height:1.7;margin:0">' + d.message.replace(/\n/g,'<br>') + '</p>' +
            '</div>' +
            replied +
            '<div class="mt-4">' +
            '<label class="form-label">Cevap Yaz</label>' +
            '<textarea id="replyText" class="form-control" rows="4" placeholder="Cevabınızı yazın..."></textarea>' +
            '</div>'
        );
        $('#msgModal').modal('show');
        contactTable.ajax.reload(null, false);
    });
}
window.viewMsg = viewMsg;

$('#sendReplyBtn').on('click', function() {
    var reply = $('#replyText').val().trim();
    if (!reply) return Swal.fire('Uyarı', 'Cevap metni boş olamaz.', 'warning');
    $.post(AJAX_URL, { module: 'contacts', action: 'reply', id: currentMsgId, reply: reply, _csrf_token: CSRF_TOKEN }, function(r) {
        if (r.success) { Swal.fire('Gönderildi!', r.message, 'success'); $('#msgModal').modal('hide'); contactTable.ajax.reload(); }
        else Swal.fire('Hata', r.message, 'error');
    });
});

window.deleteMsg = function(id) {
    Swal.fire({ title: 'Emin misiniz?', text: 'Mesaj silinecek.', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Evet, Sil', cancelButtonText: 'İptal', confirmButtonColor: '#ef4444'
    }).then(function(r) {
        if (!r.isConfirmed) return;
        $.post(AJAX_URL, { module: 'contacts', action: 'delete', id: id, _csrf_token: CSRF_TOKEN }, function(res) {
            if (res.success) contactTable.ajax.reload();
            else Swal.fire('Hata', res.message, 'error');
        });
    });
};
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>
