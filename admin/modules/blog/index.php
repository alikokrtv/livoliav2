<?php
/**
 * admin/modules/blog/index.php — Blog Yazıları Yönetimi
 */
Auth::requirePermission('blog', 'can_view');

$pageTitle = 'Blog Yönetimi';
$currentModule = 'blog';
$pageActions = '<a href="' . ADMIN_URL . '/blog/categories" class="btn btn-light-primary btn-sm me-2">Kategoriler</a>
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#blogModal" onclick="openAddBlogModal()">
    <i class="ki-duotone ki-plus fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>Yeni Yazı Ekle</button>';

$categories = Database::getInstance()->fetchAll('SELECT id, name FROM blog_categories ORDER BY name');
require_once ADMIN_PATH . '/views/layout.php';
?>
<div class="card">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title"><span class="card-label fw-bold fs-3">Blog Yazıları</span></h3>
    </div>
    <div class="card-body py-4">
        <table id="blogTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                    <th>#</th>
                    <th>Başlık</th>
                    <th>Kategori</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Blog Yazısı Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blogModalLabel">Yeni Yazı Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="blogForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="module" value="blog">
                    <input type="hidden" name="action" value="store">
                    <input type="hidden" name="id" value="">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="required form-label">Başlık</label>
                            <input type="text" name="title" class="form-control" required id="blogTitle">
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" required id="blogSlug">
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Seçiniz</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kapak Görseli</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="1">Yayında</option>
                                <option value="0">Taslak</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">İçerik</label>
                            <textarea name="content" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveBlogBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
var blogTable;
$(document).ready(function() {
    $('#blogTitle').on('keyup', function() {
        if (!$('[name=id]').val()) {
            var slug = $(this).val().toLowerCase()
                .replace(/ş/g,'s').replace(/ğ/g,'g').replace(/ü/g,'u').replace(/ö/g,'o').replace(/ı/g,'i').replace(/ç/g,'c')
                .replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-');
            $('#blogSlug').val(slug);
        }
    });

    blogTable = $('#blogTable').DataTable({
        processing: true,
        ajax: { url: AJAX_URL, type: 'POST', data: { module: 'blog', action: 'list', _csrf_token: CSRF_TOKEN } },
        columns: [
            { data: 'id' }, { data: 'title' }, { data: 'category_name', defaultContent: '-' },
            { data: 'status', render: function(d) {
                return d==1 ? '<span class="badge badge-light-success">Yayında</span>' : '<span class="badge badge-light-warning">Taslak</span>';
            }},
            { data: 'created_at' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                return '<button class="btn btn-sm btn-light-warning me-1" onclick="editBlog('+d.id+')"><i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i></button>'
                    + '<button class="btn btn-sm btn-light-danger" onclick="deleteBlog('+d.id+')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });
});

function openAddBlogModal() {
    $('#blogModalLabel').text('Yeni Yazı Ekle');
    $('#blogForm')[0].reset();
    $('[name=action]').val('store');
    $('[name=id]').val('');
}

function editBlog(id) {
    $.post(AJAX_URL, { module: 'blog', action: 'get', id: id, _csrf_token: CSRF_TOKEN }, function(r) {
        if (!r.success) return Swal.fire('Hata', r.message, 'error');
        var d = r.data;
        $('#blogModalLabel').text('Yazı Düzenle');
        $('[name=action]').val('update');
        $('[name=id]').val(d.id);
        $('[name=title]').val(d.title);
        $('[name=slug]').val(d.slug);
        $('[name=category_id]').val(d.category_id);
        $('[name=content]').val(d.content);
        $('[name=status]').val(d.status);
        $('#blogModal').modal('show');
    });
}

function deleteBlog(id) {
    Swal.fire({ title: 'Emin misiniz?', text: 'Yazı silinecek!', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Evet, Sil', cancelButtonText: 'İptal', confirmButtonColor: '#d33'
    }).then(function(r) {
        if (!r.isConfirmed) return;
        $.post(AJAX_URL, { module: 'blog', action: 'delete', id: id, _csrf_token: CSRF_TOKEN }, function(res) {
            if (res.success) { Swal.fire('Silindi!', res.message, 'success'); blogTable.ajax.reload(); }
            else Swal.fire('Hata', res.message, 'error');
        });
    });
}

$('#saveBlogBtn').on('click', function() {
    var formData = new FormData(document.getElementById('blogForm'));
    $.ajax({
        url: AJAX_URL,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(r) {
            if (r.success) { Swal.fire('Başarılı!', r.message, 'success'); $('#blogModal').modal('hide'); blogTable.ajax.reload(); }
            else Swal.fire('Hata', r.message, 'error');
        }
    });
});
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>