<?php
/**
 * admin/views/layout.php
 * Metronic tabanlı admin layout başlangıcı.
 * $pageTitle ve $currentModule değişkenleri modül dosyasından set edilmeli.
 */
$pageTitle = $pageTitle ?? 'Dashboard';
$currentModule = $currentModule ?? 'dashboard';
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= htmlspecialchars(page_title($pageTitle)) ?>
    </title>
    <!-- Metronic Global Styles -->
    <link rel="stylesheet" href="<?= ADMIN_URL ?>/assets/plugins/global/plugins.bundle.css">
    <link rel="stylesheet" href="<?= ADMIN_URL ?>/assets/css/style.bundle.css">
    <!-- Özel Stiller -->
    <link rel="stylesheet" href="<?= ADMIN_URL ?>/assets/css/custom.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php require_once ADMIN_PATH . '/views/sidebar.php'; ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php require_once ADMIN_PATH . '/views/header.php'; ?>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
                        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack">
                            <div class="page-title d-flex flex-column">
                                <h1 class="d-flex fw-bold my-1 fs-3">
                                    <?= htmlspecialchars($pageTitle) ?>
                                </h1>
                            </div>
                            <?php if (!empty($pageActions)): ?>
                                <div class="d-flex align-items-center gap-2">
                                    <?= $pageActions ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl">