<?php
/**
 * admin/modules/members/index.php — Üye Listesi
 */
Auth::requirePermission('members', 'can_view');

$pageTitle = 'Üye Yönetimi';
$currentModule = 'members';
$pageActions = '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#memberModal" onclick="openAddModal()">
    <i class="ki-duotone ki-plus fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>Yeni Üye Ekle</button>';

require_once ADMIN_PATH . '/views/layout.php';
?>
<div class="card">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Üyeler</span>
        </h3>
    </div>
    <div class="card-body py-4">
        <table id="membersTable" class="table align-middle table-row-dashed fs-6 gy-5 dataTable">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Durum</th>
                    <th>Kayıt Tarihi</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Üye Ekle/Düzenle Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Yeni Üye Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="memberForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="module" value="members">
                    <input type="hidden" name="action" value="store">
                    <input type="hidden" name="id" value="">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <label class="required form-label">Ad Soyad</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="required form-label">E-posta</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Şifre <small class="text-muted">(düzenleme: boş bırakılırsa
                                    değişmez)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="required form-label">Rol</label>
                            <select name="role_id" class="form-select" required>
                                <option value="">Seçiniz</option>
                                <?php
                                $roles = Database::getInstance()->fetchAll('SELECT id, name FROM roles ORDER BY name');
                                foreach ($roles as $role):
                                    ?>
                                    <option value="<?= $role['id'] ?>">
                                        <?= htmlspecialchars($role['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="required form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="1">Aktif</option>
                                <option value="0">Pasif</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveMemberBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<?php
$pageScripts = <<<JS
var membersTable;

$(document).ready(function () {
    membersTable = $('#membersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: AJAX_URL,
            type: 'POST',
            data: { module: 'members', action: 'list', _csrf_token: CSRF_TOKEN }
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role_name', defaultContent: '-' },
            { data: 'status', render: function(d) {
                return d == 1
                    ? '<span class="badge badge-light-success">Aktif</span>'
                    : '<span class="badge badge-light-danger">Pasif</span>';
            }},
            { data: 'created_at' },
            { data: null, className: 'text-end', orderable: false, render: function(d) {
                return '<button class="btn btn-sm btn-light-warning me-1" onclick="editMember('+d.id+')"><i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i></button>'
                    + '<button class="btn btn-sm btn-light-danger" onclick="deleteMember('+d.id+')"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i></button>';
            }}
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' }
    });
});

function openAddModal() {
    $('#memberModalLabel').text('Yeni Üye Ekle');
    $('#memberForm')[0].reset();
    $('[name=action]').val('store');
    $('[name=id]').val('');
}

function editMember(id) {
    $.post(AJAX_URL, { module: 'members', action: 'get', id: id, _csrf_token: CSRF_TOKEN }, function(r) {
        if (!r.success) return Swal.fire('Hata', r.message, 'error');
        var d = r.data;
        $('#memberModalLabel').text('Üye Düzenle');
        $('[name=action]').val('update');
        $('[name=id]').val(d.id);
        $('[name=name]').val(d.name);
        $('[name=email]').val(d.email);
        $('[name=role_id]').val(d.role_id);
        $('[name=status]').val(d.status);
        $('[name=password]').val('');
        $('#memberModal').modal('show');
    });
}

function deleteMember(id) {
    Swal.fire({ title: 'Emin misiniz?', text: 'Bu üye silinecek!', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Evet, Sil', cancelButtonText: 'İptal',
        confirmButtonColor: '#d33'
    }).then(function(r) {
        if (!r.isConfirmed) return;
        $.post(AJAX_URL, { module: 'members', action: 'delete', id: id, _csrf_token: CSRF_TOKEN }, function(res) {
            if (res.success) { Swal.fire('Silindi!', res.message, 'success'); membersTable.ajax.reload(); }
            else Swal.fire('Hata', res.message, 'error');
        });
    });
}

$('#saveMemberBtn').on('click', function() {
    var formData = $('#memberForm').serialize();
    $.post(AJAX_URL, formData, function(r) {
        if (r.success) {
            Swal.fire('Başarılı!', r.message, 'success');
            $('#memberModal').modal('hide');
            membersTable.ajax.reload();
        } else {
            Swal.fire('Hata', r.message, 'error');
        }
    });
});
JS;
require_once ADMIN_PATH . '/views/footer.php';
?>