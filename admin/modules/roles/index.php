<?php
/**
 * admin/modules/roles/index.php — Rol & Yetkilendirme Yönetimi
 */
Auth::requirePermission('roles', 'can_view');

$pageTitle = 'Rol & Yetkilendirme';
$currentModule = 'roles';
$pageActions = '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal" onclick="openAddRoleModal()">
    <i class="ki-duotone ki-plus fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>Yeni Rol Ekle</button>';

$modules = ['members' => 'Üyeler', 'roles' => 'Yetkilendirme', 'pages' => 'Sayfa Yönetimi', 'blog' => 'Blog Yönetimi'];

require_once ADMIN_PATH . '/views/layout.php';
?>
<div class="card">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title"><span class="card-label fw-bold fs-3">Roller</span></h3>
    </div>
    <div class="card-body py-4">
        <table id="rolesTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>Rol Adı</th>
                    <th>Slug</th>
                    <th>Açıklama</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Rol Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Yeni Rol Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="module" value="roles">
                    <input type="hidden" name="action" value="store">
                    <input type="hidden" name="id" value="">
                    <div class="row g-4 mb-6">
                        <div class="col-md-4">
                            <label class="required form-label">Rol Adı</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" required placeholder="ornek-rol">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Açıklama</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                    </div>
                    <h5 class="mb-4">İzinler</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-row-dashed">
                            <thead>
                                <tr class="fw-bold fs-7 text-uppercase">
                                    <th>Modül</th>
                                    <th class="text-center">Görüntüle</th>
                                    <th class="text-center">Ekle</th>
                                    <th class="text-center">Düzenle</th>
                                    <th class="text-center">Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($modules as $key => $label): ?>
                                    <tr>
                                        <td class="fw-semibold">
                                            <?= $label ?>
                                        </td>
                                        <?php foreach (['can_view', 'can_add', 'can_edit', 'can_delete'] as $perm): ?>
                                            <td class="text-center">
                                                <div
                                                    class="form-check form-check-sm form-check-custom d-inline-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="perms[<?= $key ?>][<?= $perm ?>]" value="1">
                                                </div>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveRoleBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
var rolesTable;
$(document).ready(function() {
    rolesTable = $('#rolesTable').DataTable({
        processing: true,
        ajax: { url: AJAX_URL, type: 'POST', data: { module: 'roles', action: 'list', _csrf_token: CSRF_TOKEN } },
        columns: [
            { data: 'id' }, { data: 'name' }, { data: 'slug' }, { data: 'description', defaultContent: '-' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                return '<button class="btn btn-sm btn-light-warning me-1" onclick="editRole('+d.id+')"><i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i></button>'
                    + '<button class="btn btn-sm btn-light-danger" onclick="deleteRole('+d.id+')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });
});

function openAddRoleModal() {
    $('#roleModalLabel').text('Yeni Rol Ekle');
    $('#roleForm')[0].reset();
    $('input[type=checkbox]').prop('checked', false);
    $('[name=action]').val('store');
    $('[name=id]').val('');
}

function editRole(id) {
    $.post(AJAX_URL, { module: 'roles', action: 'get', id: id, _csrf_token: CSRF_TOKEN }, function(r) {
        if (!r.success) return Swal.fire('Hata', r.message, 'error');
        var d = r.data;
        $('#roleModalLabel').text('Rol Düzenle');
        $('[name=action]').val('update');
        $('[name=id]').val(d.role.id);
        $('[name=name]').val(d.role.name);
        $('[name=slug]').val(d.role.slug);
        $('[name=description]').val(d.role.description);
        $('input[type=checkbox]').prop('checked', false);
        $.each(d.perms, function(mod, perms) {
            $.each(perms, function(perm, val) {
                if (val == 1) $('input[name="perms['+mod+']['+perm+']"]').prop('checked', true);
            });
        });
        $('#roleModal').modal('show');
    });
}

function deleteRole(id) {
    Swal.fire({ title: 'Emin misiniz?', text: 'Bu rol silinecek!', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Evet, Sil', cancelButtonText: 'İptal', confirmButtonColor: '#d33'
    }).then(function(r) {
        if (!r.isConfirmed) return;
        $.post(AJAX_URL, { module: 'roles', action: 'delete', id: id, _csrf_token: CSRF_TOKEN }, function(res) {
            if (res.success) { Swal.fire('Silindi!', res.message, 'success'); rolesTable.ajax.reload(); }
            else Swal.fire('Hata', res.message, 'error');
        });
    });
}

$('#saveRoleBtn').on('click', function() {
    var formData = $('#roleForm').serializeArray();
    $.post(AJAX_URL, formData, function(r) {
        if (r.success) { Swal.fire('Başarılı!', r.message, 'success'); $('#roleModal').modal('hide'); rolesTable.ajax.reload(); }
        else Swal.fire('Hata', r.message, 'error');
    });
});
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>