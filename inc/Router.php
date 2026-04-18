<?php
/**
 * Router.php — URL Yönlendirici
 * admin/index.php ve public index.php tarafından kullanılır.
 */

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /** GET rotası ekle */
    public function get(string $pattern, callable $callback): void
    {
        $this->addRoute('GET', $pattern, $callback);
    }

    /** POST rotası ekle */
    public function post(string $pattern, callable $callback): void
    {
        $this->addRoute('POST', $pattern, $callback);
    }

    /** GET + POST rotası */
    public function any(string $pattern, callable $callback): void
    {
        $this->addRoute('GET', $pattern, $callback);
        $this->addRoute('POST', $pattern, $callback);
    }

    private function addRoute(string $method, string $pattern, callable $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $this->basePath . '/' . ltrim($pattern, '/'),
            'callback' => $callback,
        ];
    }

    /** Gelen isteği eşleştir ve çalıştır */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $requestUri = rtrim($requestUri, '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method)
                continue;

            $pattern = $this->patternToRegex($route['pattern']);
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // tam eşleşmeyi at
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        // 404
        http_response_code(404);
        echo '<h1>404 - Sayfa Bulunamadı</h1>';
    }

    /** :param tarzı parametreleri regex'e çevirir */
    private function patternToRegex(string $pattern): string
    {
        $regex = preg_replace('/\/:([a-zA-Z0-9_]+)/', '/([a-zA-Z0-9_\-]+)', $pattern);
        $regex = str_replace('/', '\/', $regex);
        return '/^' . $regex . '$/';
    }

    // ─── Admin modül/aksiyon yardımcısı ──────────────────────────────

    /**
     * URL'den modül ve aksiyon bilgisini çıkarır.
     * Örn: /admin/members/edit/5 → ['module' => 'members', 'action' => 'edit', 'id' => '5']
     */
    public static function parseAdminUrl(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = trim($uri, '/');
        $parts = explode('/', $uri);

        // 'admin' segmentini kaldır
        $idx = array_search('admin', $parts);
        if ($idx !== false) {
            $parts = array_slice($parts, $idx + 1);
        }

        return [
            'module' => $parts[0] ?? 'dashboard',
            'action' => $parts[1] ?? 'index',
            'id' => $parts[2] ?? null,
        ];
    }
}
