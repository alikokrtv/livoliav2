<?php
// Geçici admin şifre sıfırlama aracı
// Kullandıktan sonra bu dosyayı SİL!

$dsn = "sqlite:" . realpath(__DIR__) . "/database.sqlite";

try {
    $pdo = new PDO($dsn, "", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $newPassword = 'admin123'; // ← İstediğin şifreyi buraya yaz
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    // Mevcut kullanıcıları listele
    $stmt = $pdo->query("SELECT id, name, email, role_id FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Mevcut Kullanıcılar</h2><pre>";
    print_r($users);
    echo "</pre>";

    // Admin kullanıcısının şifresini güncelle (role_id = 1 admin varsayımı)
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE role_id = 1");
    $stmt->execute([$hash]);

    echo "<h2 style='color:green'>✅ Admin şifresi güncellendi!</h2>";
    echo "<p>Yeni şifre: <strong>$newPassword</strong></p>";
    echo "<p><strong>⚠️ Bu dosyayı şimdi sil: reset_admin.php</strong></p>";

} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Bağlantı Hatası</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Önce phpMyAdmin sorununu çöz, sonra tekrar dene.</p>";
}
