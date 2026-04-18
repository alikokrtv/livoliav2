<?php
/**
 * Response.php — JSON AJAX Yanıt Yardımcısı
 * Tüm AJAX endpoint'leri bu sınıfı kullanır.
 */

class Response
{
    /** Başarılı JSON yanıt */
    public static function success(mixed $data = null, string $message = 'İşlem başarılı.'): never
    {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /** Hatalı JSON yanıt */
    public static function error(string $message = 'Bir hata oluştu.', int $code = 400): never
    {
        http_response_code($code);
        self::json([
            'success' => false,
            'message' => $message,
        ]);
    }

    /** Doğrulama hatası */
    public static function validationError(array $errors): never
    {
        http_response_code(422);
        self::json([
            'success' => false,
            'message' => 'Lütfen formu doğru doldurun.',
            'errors' => $errors,
        ]);
    }

    /** Ham JSON çıktı */
    private static function json(array $payload): never
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}
