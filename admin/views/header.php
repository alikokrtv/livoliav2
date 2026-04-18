<?php
/**
 * admin/views/header.php — Üst Navigasyon Çubuğu
 */
$user = Auth::user();
?>
<div id="kt_header" class="header align-items-stretch">
    <div class="header-brand">
        <a href="<?= ADMIN_URL ?>/dashboard" class="d-flex align-items-center">
            <span class="fw-bolder fs-3 text-white">
                <?= SITE_TITLE ?>
            </span>
            <span class="text-gray-400 fs-7 ms-2">Admin</span>
        </a>
        <!-- Hamburger (Mobile) -->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Menüyü Göster">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
        </div>
    </div>
    <div class="toolbar d-flex align-items-stretch">
        <div
            class="container-xxl py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
            <div class="d-flex align-items-center" id="kt_header_search">
            </div>
            <div class="d-flex align-items-center flex-shrink-0">
                <!-- Kullanıcı Menüsü -->
                <div class="d-flex align-items-center ms-3 ms-lg-4" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <div class="symbol-label bg-primary text-white fw-bold">
                            <?= mb_substr($user['name'] ?? 'A', 0, 1) ?>
                        </div>
                    </div>
                    <!-- Dropdown Menü -->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label bg-primary text-white fw-bold fs-2">
                                        <?= mb_substr($user['name'] ?? 'A', 0, 1) ?>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <?= htmlspecialchars($user['name'] ?? '') ?>
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                        <?= htmlspecialchars($user['email'] ?? '') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="<?= ADMIN_URL ?>/logout" class="menu-link px-5">
                                <i class="ki-duotone ki-arrow-right-left fs-2 me-3">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Çıkış Yap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>