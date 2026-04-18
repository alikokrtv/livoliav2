<?php
/**
 * admin/modules/blog/categories.php — Blog Kategorileri
 */
Auth::requirePermission('blog', 'can_view');

$pageTitle = 'Blog Kategorileri';
$currentModule = 'blog';
$pageActions = '<a href="' . ADMIN_URL . '/blog" class="btn btn-light-secondary btn-sm me-2">← Yazılara Dön</a>
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#catModal">
    <i class="ki-duotone ki-plus fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>Yeni Kategori</button>';

require_once ADMIN_PATH . '/views/layout.php';
?>
<div class="card">
    <div class="card-body py-4">
        <table id="catTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                    <th>#</th>
                    <th>Kategori Adı</th>
                    <th>Slug</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="catModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="catForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="module" value="blog">
                    <input type="hidden" name="action" value="categories_store">
                    <div class="mb-4">
                        <label class="required form-label">Kategori Adı</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveCatBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
var catTable;
$(document).ready(function() {
    catTable = $('#catTable').DataTable({
        processing: true,
        ajax: { url: AJAX_URL, type: 'POST', data: { module: 'blog', action: 'categories_list', _csrf_token: CSRF_TOKEN } },
        columns: [
            { data: 'id' }, { data: 'name' }, { data: 'slug' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                return '<button class="btn btn-sm btn-light-danger" onclick="deleteCat('+d.id+')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });
});

function deleteCat(id) {
    Swal.fire({ title: 'Emin misiniz?', icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Sil', cancelButtonText: 'İptal', confirmButtonColor: '#d33'
    }).then(function(r) {
        if (!r.isConfirmed) return;
        $.post(AJAX_URL, { module: 'blog', action: 'categories_delete', id: id, _csrf_token: CSRF_TOKEN }, function(res) {
            if (res.success) { Swal.fire('Silindi!', res.message, 'success'); catTable.ajax.reload(); }
            else Swal.fire('Hata', res.message, 'error');
        });
    });
}

$('#saveCatBtn').on('click', function() {
    $.post(AJAX_URL, $('#catForm').serialize(), function(r) {
        if (r.success) { Swal.fire('Başarılı!', r.message, 'success'); $('#catModal').modal('hide'); catTable.ajax.reload(); $('#catForm')[0].reset(); }
        else Swal.fire('Hata', r.message, 'error');
    });
});
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>