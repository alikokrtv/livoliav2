<?php
/**
 * admin/views/footer.php — Footer & JS Scriptler
 */
?>
</div><!-- /#kt_content_container -->
</div><!-- /#kt_post -->
</div><!-- /#kt_content -->

<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">
                <?= date('Y') ?> &copy;
            </span>
            <a href="<?= BASE_URL ?>" class="text-gray-800 text-hover-primary">
                <?= SITE_TITLE ?> Admin
            </a>
        </div>
    </div>
</div>
</div><!-- /#kt_wrapper -->
</div><!-- /.page -->
</div><!-- /.d-flex.flex-root -->

<!-- Global JS -->
<script src="<?= ADMIN_URL ?>/assets/plugins/global/plugins.bundle.js"></script>
<script src="<?= ADMIN_URL ?>/assets/js/scripts.bundle.js"></script>
<!-- jQuery (DataTables için) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CSRF Token (Global) -->
<script>
    const ADMIN_URL = '<?= ADMIN_URL ?>';
    const AJAX_URL = '<?= ADMIN_URL ?>/ajax.php';
    const CSRF_TOKEN = '<?= csrf_token() ?>';

    // Global AJAX setup — her istekte CSRF token ekle
    $(document).ajaxSetup({
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
    });

    // Global AJAX hata yakalayıcı
    $(document).ajaxError(function (event, xhr) {
        if (xhr.status === 401) {
            Swal.fire({
                icon: 'warning',
                title: 'Oturum Sona Erdi',
                text: 'Lütfen tekrar giriş yapın.',
                confirmButtonText: 'Giriş Yap'
            }).then(() => { window.location.href = ADMIN_URL + '/login'; });
        }
    });
</script>
<!-- Toast Notification System -->
<div class="lv-toast-container" id="lvToastContainer"></div>
<script>
function lvToast(type, title, message, duration) {
    duration = duration || 4000;
    var icons = { success: '✓', error: '✕', warning: '!', info: 'i' };
    var container = document.getElementById('lvToastContainer');
    var toast = document.createElement('div');
    toast.className = 'lv-toast ' + type;
    toast.innerHTML =
        '<div class="lv-toast-icon">' + (icons[type] || 'i') + '</div>'
        + '<div class="lv-toast-body">'
        + '<div class="lv-toast-title">' + title + '</div>'
        + (message ? '<div class="lv-toast-message">' + message + '</div>' : '')
        + '</div>'
        + '<button class="lv-toast-close" onclick="this.parentNode.remove()">×</button>'
        + '<div class="lv-toast-progress"></div>';
    container.appendChild(toast);
    setTimeout(function() {
        toast.classList.add('removing');
        setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
    }, duration);
}
</script>
<!-- Sayfa özgü scriptler -->
<?php if (!empty($pageScripts)): ?>
    <script><?= $pageScripts ?></script>
<?php endif; ?>
</body>

</html>