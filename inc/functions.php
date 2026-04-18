<?php
/**
 * functions.php — Genel Yardımcı Fonksiyonlar
 */

/** URL'ye yönlendir */
function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/** Girdiyi sanitize et (XSS koruması) */
function sanitize(mixed $input): mixed
{
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(strip_tags(trim((string) $input)), ENT_QUOTES, 'UTF-8');
}

/** POST verisi al (sanitize edilmiş) */
function post(string $key, mixed $default = null): mixed
{
    return isset($_POST[$key]) ? sanitize($_POST[$key]) : $default;
}

/** GET verisi al (sanitize edilmiş) */
function get_param(string $key, mixed $default = null): mixed
{
    return isset($_GET[$key]) ? sanitize($_GET[$key]) : $default;
}

/** CSRF token oluştur ve session'a kaydet */
function csrf_token(): string
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/** CSRF token gizli input alanı */
function csrf_field(): string
{
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . csrf_token() . '">';
}

/** CSRF token doğrula (geçersizse hata döner) */
function csrf_check(): void
{
    $token = $_POST[CSRF_TOKEN_NAME] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $token)) {
        http_response_code(403);
        die(json_encode(['success' => false, 'message' => 'Geçersiz güvenlik kodu.']));
    }
}

/** Flash mesaj kaydet */
function flash(string $key, string $message, string $type = 'success'): void
{
    $_SESSION['_flash'][$key] = ['message' => $message, 'type' => $type];
}

/** Flash mesajı al ve sil */
function get_flash(string $key): ?array
{
    $flash = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $flash;
}

/** Slug oluştur (Türkçe karakter desteği) */
function slugify(string $text): string
{
    $tr = ['ş', 'Ş', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç'];
    $en = ['s', 'S', 'i', 'I', 'g', 'G', 'u', 'U', 'o', 'O', 'c', 'C'];
    $text = str_replace($tr, $en, $text);
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/** Tarih formatla (Y-m-d H:i:s → d.m.Y H:i) */
function format_date(string $date, string $format = 'd.m.Y H:i'): string
{
    return date($format, strtotime($date));
}

/** Dosya yükle, yol döner */
function upload_file(array $file, string $targetDir, array $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp']): string|false
{
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes))
        return false;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $filename = uniqid('img_', true) . '.' . $ext;
    $target = rtrim($targetDir, '/') . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        return $filename;
    }
    return false;
}

/** Sayfa başlığını ayarla */
function page_title(string $title): string
{
    return $title . ' — ' . ADMIN_TITLE;
}

/** Kısa metin (excerpt) */
function excerpt(string $text, int $length = 150): string
{
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length)
        return $text;
    return mb_substr($text, 0, $length) . '...';
}

/**
 * Blog görsel yolunu güvenli şekilde çözer.
 * DB'de yalnız dosya adı, göreli yol veya tam URL saklanmış olabilir.
 */
function blog_image_url(?string $image): ?string
{
    $image = trim((string) $image);
    if ($image === '') {
        return null;
    }

    if (preg_match('~^(https?:)?//~i', $image)) {
        return $image;
    }

    $normalized = ltrim(str_replace('\\', '/', $image), '/');

    $candidates = [
        ['fs' => ROOT . '/theme/assets/img/blog/' . $normalized, 'url' => THEME_URL . '/assets/img/blog/' . rawurlencode(basename($normalized))],
        ['fs' => ROOT . '/' . $normalized, 'url' => BASE_URL . '/' . $normalized],
    ];

    foreach ($candidates as $candidate) {
        if (is_file($candidate['fs'])) {
            return $candidate['url'];
        }
    }

    return null;
}
