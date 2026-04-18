<?php
/**
 * Database.php — PDO Singleton Sınıfı
 * Tüm veritabanı işlemleri bu sınıf üzerinden yapılır.
 */

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO(DB_DSN, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (ENVIRONMENT === 'development') {
                die('Veritabanı bağlantı hatası: ' . $e->getMessage());
            }
            die('Veritabanına bağlanılamadı. Lütfen daha sonra tekrar deneyin.');
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** Hazırlanmış sorgu çalıştırır, PDOStatement döner */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /** Tüm satırları dizi olarak döner */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /** Tek satır döner */
    public function fetchOne(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    /** INSERT/UPDATE/DELETE için etkilenen satır sayısını döner */
    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    /** Son eklenen kayıt ID'sini döner */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /** Transaction başlat */
    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    /** Transaction onayla */
    public function commit(): void
    {
        $this->pdo->commit();
    }

    /** Transaction geri al */
    public function rollback(): void
    {
        $this->pdo->rollBack();
    }
}
