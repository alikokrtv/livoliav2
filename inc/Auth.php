<?php
/**
 * Auth.php — Kimlik Doğrulama & Yetkilendirme
 */

class Auth
{
    private static Database $db;

    /** Session başlat (her sayfanın başında çağrılır) */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => SESSION_LIFETIME,
                'path' => '/',
                'secure' => false, // HTTPS'te true yap
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
        self::$db = Database::getInstance();
    }

    /** Kullanıcı girişi yapar, başarılıysa true döner */
    public static function login(string $email, string $password): bool
    {
        $user = self::$db->fetchOne(
            'SELECT u.*, r.slug AS role_slug FROM users u
             LEFT JOIN roles r ON r.id = u.role_id
             WHERE u.email = ? AND u.status = 1',
            [$email]
        );

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        // Şifre hash'i yenileme (gerekirse)
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            self::$db->execute(
                'UPDATE users SET password = ? WHERE id = ?',
                [password_hash($password, PASSWORD_DEFAULT), $user['id']]
            );
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'role_slug' => $user['role_slug'],
        ];
        $_SESSION['_last_activity'] = time();

        session_regenerate_id(true);
        return true;
    }

    /** Kullanıcı çıkışı */
    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }

    /** Giriş kontrol et: yapılmamışsa login sayfasına yönlendir */
    public static function check(): void
    {
        self::start();

        // Oturum zaman aşımı kontrolü
        if (
            isset($_SESSION['_last_activity']) &&
            (time() - $_SESSION['_last_activity']) > SESSION_LIFETIME
        ) {
            self::logout();
            redirect(ADMIN_URL . '/login');
        }

        if (!self::isLoggedIn()) {
            redirect(ADMIN_URL . '/login');
        }

        $_SESSION['_last_activity'] = time();
    }

    /** Kullanıcı giriş yapmış mı? */
    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']);
    }

    /** Oturum bilgisi al */
    public static function user(?string $key = null): mixed
    {
        if ($key === null) {
            return $_SESSION['user'] ?? null;
        }
        return $_SESSION['user'][$key] ?? null;
    }

    /** Kullanıcının belirli bir modülde izni var mı? */
    public static function hasPermission(string $module, string $action = 'can_view'): bool
    {
        $roleId = self::user('role_id');
        if (!$roleId)
            return false;

        // Admin her şeye erişebilir
        if (self::user('role_slug') === 'admin')
            return true;

        $perm = self::$db->fetchOne(
            'SELECT * FROM permissions WHERE role_id = ? AND module = ?',
            [$roleId, $module]
        );

        return !empty($perm[$action]);
    }

    /** İzin yoksa 403 döner */
    public static function requirePermission(string $module, string $action = 'can_view'): void
    {
        if (!self::hasPermission($module, $action)) {
            http_response_code(403);
            die(json_encode(['success' => false, 'message' => 'Bu işlem için yetkiniz yok.']));
        }
    }
}
