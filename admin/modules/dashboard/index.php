<?php
/**
 * admin/modules/dashboard/index.php
 */
$pageTitle    = 'Dashboard';
$currentModule = 'dashboard';

require_once ADMIN_PATH . '/views/layout.php';

$db = Database::getInstance();

$totalMembers     = $db->fetchOne('SELECT COUNT(*) AS cnt FROM users')['cnt'] ?? 0;
$totalPosts       = $db->fetchOne('SELECT COUNT(*) AS cnt FROM blog_posts')['cnt'] ?? 0;
$totalContacts    = $db->fetchOne('SELECT COUNT(*) AS cnt FROM contact_messages')['cnt'] ?? 0;
$unreadContacts   = $db->fetchOne('SELECT COUNT(*) AS cnt FROM contact_messages WHERE is_read = 0')['cnt'] ?? 0;
$totalSubscribers = $db->fetchOne('SELECT COUNT(*) AS cnt FROM newsletter_subscribers WHERE status = 1')['cnt'] ?? 0;
$totalPages       = $db->fetchOne('SELECT COUNT(*) AS cnt FROM pages')['cnt'] ?? 0;

// Recent messages
$recentMsgs = $db->fetchAll(
    'SELECT id, name, subject, is_read, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 5'
);

// Recent subscribers
$recentSubs = $db->fetchAll(
    'SELECT email, created_at FROM newsletter_subscribers ORDER BY created_at DESC LIMIT 5'
);
?>

<!-- Stat Cards -->
<div class="row g-4 mb-5">
    <!-- Mesajlar -->
    <div class="col-6 col-xl-2">
        <div class="lv-stat-card">
            <div class="lv-stat-icon <?= $unreadContacts > 0 ? 'danger' : 'primary' ?>">
                <i class="ki-duotone ki-message-text-2 fs-2">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                </i>
            </div>
            <div>
                <div class="lv-stat-value"><?= $totalContacts ?></div>
                <div class="lv-stat-label">Mesaj</div>
                <?php if ($unreadContacts > 0): ?>
                    <span class="badge badge-light-danger mt-1"><?= $unreadContacts ?> okunmadı</span>
                <?php endif; ?>
                <a href="<?= ADMIN_URL ?>/contacts" class="lv-stat-link">Görüntüle →</a>
            </div>
        </div>
    </div>
    <!-- Aboneler -->
    <div class="col-6 col-xl-2">
        <div class="lv-stat-card">
            <div class="lv-stat-icon success">
                <i class="ki-duotone ki-sms fs-2">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
            <div>
                <div class="lv-stat-value"><?= $totalSubscribers ?></div>
                <div class="lv-stat-label">Abone</div>
                <a href="<?= ADMIN_URL ?>/newsletter" class="lv-stat-link">Yönet →</a>
            </div>
        </div>
    </div>
    <!-- Blog -->
    <div class="col-6 col-xl-2">
        <div class="lv-stat-card">
            <div class="lv-stat-icon warning">
                <i class="ki-duotone ki-pencil fs-2">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
            <div>
                <div class="lv-stat-value"><?= $totalPosts ?></div>
                <div class="lv-stat-label">Blog Yazısı</div>
                <a href="<?= ADMIN_URL ?>/blog" class="lv-stat-link">Yönet →</a>
            </div>
        </div>
    </div>
    <!-- Sayfalar -->
    <div class="col-6 col-xl-2">
        <div class="lv-stat-card">
            <div class="lv-stat-icon info">
                <i class="ki-duotone ki-document fs-2">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
            <div>
                <div class="lv-stat-value"><?= $totalPages ?></div>
                <div class="lv-stat-label">Sayfa</div>
                <a href="<?= ADMIN_URL ?>/pages" class="lv-stat-link">Yönet →</a>
            </div>
        </div>
    </div>
    <!-- Üyeler -->
    <div class="col-6 col-xl-2">
        <div class="lv-stat-card">
            <div class="lv-stat-icon primary">
                <i class="ki-duotone ki-people fs-2">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    <span class="path4"></span><span class="path5"></span>
                </i>
            </div>
            <div>
                <div class="lv-stat-value"><?= $totalMembers ?></div>
                <div class="lv-stat-label">Üye</div>
                <a href="<?= ADMIN_URL ?>/members" class="lv-stat-link">Yönet →</a>
            </div>
        </div>
    </div>
    <!-- Site -->
    <div class="col-6 col-xl-2">
        <div class="lv-stat-card">
            <div class="lv-stat-icon success">
                <i class="ki-duotone ki-globe fs-2">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
            <div>
                <div class="lv-stat-value" style="font-size:1rem;margin-top:4px">Canlı</div>
                <div class="lv-stat-label">Site Durumu</div>
                <a href="<?= BASE_URL ?>" target="_blank" class="lv-stat-link">Görüntüle →</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Row -->
<div class="row g-4">
    <!-- Son Mesajlar -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="mb-0" style="font-size:.9rem;font-weight:700;color:var(--lv-text-primary)">Son Mesajlar</h4>
                <a href="<?= ADMIN_URL ?>/contacts" class="btn btn-sm btn-light-primary">Tümünü Gör</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentMsgs)): ?>
                    <div class="text-center py-5 text-muted" style="font-size:.82rem">Henüz mesaj yok.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <?php foreach ($recentMsgs as $m): ?>
                                    <tr>
                                        <td style="padding:14px 20px">
                                            <div style="font-size:.875rem;font-weight:<?= $m['is_read'] ? '400' : '700' ?>;color:var(--lv-text-primary)">
                                                <?= htmlspecialchars($m['name']) ?>
                                            </div>
                                            <div style="font-size:.75rem;color:var(--lv-text-muted)">
                                                <?= htmlspecialchars($m['subject']) ?>
                                            </div>
                                        </td>
                                        <td style="padding:14px 20px;text-align:right;white-space:nowrap">
                                            <?php if (!$m['is_read']): ?>
                                                <span class="badge badge-light-warning">Yeni</span>
                                            <?php endif; ?>
                                            <div style="font-size:.7rem;color:var(--lv-text-muted);margin-top:2px">
                                                <?= date('d M', strtotime($m['created_at'])) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Son Aboneler -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="mb-0" style="font-size:.9rem;font-weight:700;color:var(--lv-text-primary)">Son Aboneler</h4>
                <a href="<?= ADMIN_URL ?>/newsletter" class="btn btn-sm btn-light-primary">Tümünü Gör</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentSubs)): ?>
                    <div class="text-center py-5 text-muted" style="font-size:.82rem">Henüz abone yok.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <?php foreach ($recentSubs as $s): ?>
                                    <tr>
                                        <td style="padding:14px 20px">
                                            <div style="font-size:.875rem;color:var(--lv-text-primary)">
                                                <?= htmlspecialchars($s['email']) ?>
                                            </div>
                                        </td>
                                        <td style="padding:14px 20px;text-align:right">
                                            <span class="badge badge-light-success">Aktif</span>
                                            <div style="font-size:.7rem;color:var(--lv-text-muted);margin-top:2px">
                                                <?= date('d M', strtotime($s['created_at'])) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once ADMIN_PATH . '/views/footer.php'; ?>
