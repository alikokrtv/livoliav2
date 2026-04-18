<?php
/**
 * theme/views/header.php — Public Site Header
 * $pageTitle değişkeni modül dosyasından set edilmeli.
 */
$pageTitle = $pageTitle ?? SITE_TITLE;
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDesc ?? '') ?>">
    <title>
        <?= htmlspecialchars($pageTitle) ?> —
        <?= SITE_TITLE ?>
    </title>
    <link rel="stylesheet" href="<?= THEME_URL ?>/assets/css/style.css">
</head>

<body>
    <header id="site-header">
        <nav class="navbar">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
                    <?= SITE_TITLE ?>
                </a>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/blog">Blog</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main id="main-content">