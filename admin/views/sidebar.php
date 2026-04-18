<?php
/**
 * admin/views/sidebar.php — Sol Menü
 */
$currentModule = $currentModule ?? 'dashboard';

$menuItems = [
    ['type' => 'heading', 'label' => 'Genel Bakış'],
    ['module' => 'dashboard', 'label' => 'Ana Pano', 'icon' => 'ki-element-11', 'perm' => null],

    ['type' => 'separator'],
    ['type' => 'heading', 'label' => 'İçerik Yönetimi'],
    ['module' => 'pages',    'label' => 'Sayfalar',      'icon' => 'ki-document',     'perm' => 'pages'],
    ['module' => 'blog',     'label' => 'Blog Yazıları', 'icon' => 'ki-pencil',       'perm' => 'blog'],
    ['module' => 'media',    'label' => 'Görsel Yönetimi','icon' => 'ki-picture',      'perm' => 'media'],

    ['type' => 'separator'],
    ['type' => 'heading', 'label' => 'Katalog & Üretim'],
    ['module' => 'fabrics',  'label' => 'Kumaş Koleksiyonu', 'icon' => 'ki-abstract-26', 'perm' => 'fabrics'],
    ['module' => 'production','label' => 'Üretim Talepleri', 'icon' => 'ki-basket',      'perm' => 'production'],

    ['type' => 'separator'],
    ['type' => 'heading', 'label' => 'Müşteri İlişkileri'],
    ['module' => 'contacts',    'label' => 'Gelen Mesajlar', 'icon' => 'ki-message-text-2',  'perm' => 'contacts'],
    ['module' => 'newsletter',  'label' => 'Bülten Listesi',   'icon' => 'ki-sms',             'perm' => 'newsletter'],

    ['type' => 'separator'],
    ['type' => 'heading', 'label' => 'Sistem'],
    ['module' => 'members',  'label' => 'Yöneticiler',        'icon' => 'ki-people',       'perm' => 'members'],
    ['module' => 'settings', 'label' => 'Site Ayarları',       'icon' => 'ki-gear',         'perm' => 'settings'],
];
?>
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!-- Logo -->
    <div class="aside-logo flex-column-auto px-6 pt-9 pb-4" id="kt_aside_logo">
        <a href="<?= ADMIN_URL ?>/dashboard">
            <span class="fw-bolder text-white fs-4" style="letter-spacing: 5px;">
                LIVOLIA
            </span>
        </a>
    </div>
    <!-- Menü -->
    <div class="aside-menu flex-column-fluid ps-3 pe-1" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu"
            class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold my-5 mt-lg-2 mb-lg-0 ps-3 pe-3"
            data-kt-menu="true">

            <?php foreach ($menuItems as $item): ?>

                <?php if (isset($item['type']) && $item['type'] === 'heading'): ?>
                    <div class="menu-item pt-5">
                        <div class="menu-content"><span
                                class="menu-heading fw-bold text-uppercase fs-7 text-muted"><?= $item['label'] ?></span></div>
                    </div>
                <?php elseif (isset($item['type']) && $item['type'] === 'separator'): ?>
                    <div class="menu-item">
                        <div class="menu-content">
                            <div class="separator mx-1 my-2"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (isset($item['perm']) && $item['perm'] && !Auth::hasPermission($item['perm'])):
                        continue; endif; ?>
                    <div class="menu-item mb-1">
                        <a class="menu-link <?= $currentModule === $item['module'] ? 'active' : '' ?>"
                            href="<?= ADMIN_URL ?>/<?= $item['module'] ?>">
                            <span class="menu-icon">
                                <i class="ki-duotone <?= $item['icon'] ?> fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span>
                                </i>
                            </span>
                            <span class="menu-title">
                                <?= $item['label'] ?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>

            <!-- Ayırıcı -->
            <div class="menu-item">
                <div class="menu-content">
                    <div class="separator mx-1 my-4"></div>
                </div>
            </div>
            <!-- Siteyi Görüntüle -->
            <div class="menu-item mb-1">
                <a class="menu-link" href="<?= BASE_URL ?>" target="_blank">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-globe fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Siteyi Görüntüle</span>
                </a>
            </div>
            <div class="menu-item mb-1">
                <a class="menu-link" href="<?= ADMIN_URL ?>/logout">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-exit-right fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Güvenli Çıkış</span>
                </a>
            </div>
        </div>
    </div>
</div>