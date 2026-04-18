<?php
/**
 * autoload.php — Sınıf Otomatik Yükleyici
 * inc/ klasöründeki tüm PHP sınıflarını otomatik yükler.
 */

spl_autoload_register(function (string $className): void {
    // İsim alanı varsa kaldır (namespace desteği eklenmek istenirse)
    $className = ltrim($className, '\\');

    $filePath = INC_PATH . '/' . $className . '.php';

    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
