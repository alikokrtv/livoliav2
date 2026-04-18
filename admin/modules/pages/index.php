<?php
/**
 * admin/modules/pages/index.php — Sayfa Yönetimi
 */
Auth::requirePermission('pages', 'can_view');

$pageTitle = 'Sayfa Yönetimi';
$currentModule = 'pages';
$pageActions = '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pageModal" onclick="openAddPageModal()">
    <i class="ki-duotone ki-plus fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>Yeni Sayfa Ekle</button>';

require_once ADMIN_PATH . '/views/layout.php';
?>
<div class="card">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title"><span class="card-label fw-bold fs-3">Sayfalar</span></h3>
    </div>
    <div class="card-body py-4">
        <table id="pagesTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                    <th>#</th>
                    <th>Başlık</th>
                    <th>Slug</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Sayfa Modal -->
<div class="modal fade" id="pageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageModalLabel">Yeni Sayfa Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="pageForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="module" value="pages">
                    <input type="hidden" name="action" value="store">
                    <input type="hidden" name="id" value="">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="required form-label">Sayfa Başlığı</label>
                            <input type="text" name="title" class="form-control" required id="pageTitle">
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" required id="pageSlug">
                        </div>
                        <div class="col-12">
                            <label class="form-label">İçerik</label>
                            <textarea name="content" class="form-control" rows="10" id="pageContent"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Başlığı</label>
                            <input type="text" name="meta_title" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Açıklaması</label>
                            <input type="text" name="meta_desc" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="1">Yayında</option>
                                <option value="0">Taslak</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="savePageBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
var pagesTable;
$(document).ready(function() {
    // Başlık → slug otomatik doldur
    $('#pageTitle').on('keyup', function() {
        if (!$('[name=id]').val()) {
            var slug = $(this).val().toLowerCase()
                .replace(/ş/g,'s').replace(/ğ/g,'g').replace(/ü/g,'u').replace(/ö/g,'o').replace(/ı/g,'i').replace(/ç/g,'c')
                .replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-');
            $('#pageSlug').val(slug);
        }
    });

    pagesTable = $('#pagesTable').DataTable({
        processing: true,
        ajax: { url: AJAX_URL, type: 'POST', data: { module: 'pages', action: 'list', _csrf_token: CSRF_TOKEN } },
        columns: [
            { data: 'id' }, { data: 'title' }, { data: 'slug' },
            { data: 'status', render: function(d) {
                return d==1 ? '<span class="badge badge-light-success">Yayında</span>' : '<span class="badge badge-light-warning">Taslak</span>';
            }},
            { data: 'created_at' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                return '<button class="btn btn-sm btn-light-warning me-1" onclick="editPage('+d.id+')"><i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i></button>'
                    + '<button class="btn btn-sm btn-light-danger" onclick="deletePage('+d.id+')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });
});

function openAddPageModal() {
    $('#pageModalLabel').text('Yeni Sayfa Ekle');
    $('#pageForm')[0].reset();
    $('[name=action]').val('store');
    $('[name=id]').val('');
}

function editPage(id) {
    $.post(AJAX_URL, { module: 'pages', action: 'get', id: id, _csrf_token: CSRF_TOKEN }, function(r) {
        if (!r.success) return Swal.fire('Hata', r.message, 'error');
        var d = r.data;
        $('#pageModalLabel').text('Sayfa Düzenle');
        $('[name=action]').val('update');
        $('[name=id]').val(d.id);
        $('[name=title]').val(d.title);
        $('[name=slug]').val(d.slug);
        $('[name=content]').val(d.content);
        $('[name=meta_title]').val(d.meta_title);
        $('[name=meta_desc]').val(d.meta_desc);
        $('[name=status]').val(d.status);
        $('#pageModal').modal('show');
    });
}

function deletePage(id) {
    Swal.fire({ title: 'Emin misiniz?', text: 'Sayfa silinecek!', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Evet, Sil', cancelButtonText: 'İptal', confirmButtonColor: '#d33'
    }).then(function(r) {
        if (!r.isConfirmed) return;
        $.post(AJAX_URL, { module: 'pages', action: 'delete', id: id, _csrf_token: CSRF_TOKEN }, function(res) {
            if (res.success) { Swal.fire('Silindi!', res.message, 'success'); pagesTable.ajax.reload(); }
            else Swal.fire('Hata', res.message, 'error');
        });
    });
}

$('#savePageBtn').on('click', function() {
    $.post(AJAX_URL, $('#pageForm').serialize(), function(r) {
        if (r.success) { Swal.fire('Başarılı!', r.message, 'success'); $('#pageModal').modal('hide'); pagesTable.ajax.reload(); }
        else Swal.fire('Hata', r.message, 'error');
    });
});
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>