<?php
/**
 * Livolia - Blog yazıları seed script
 * Çalıştır: http://localhost/livoliav2/seed_blog.php
 */
require_once 'inc/config.php';
require_once 'inc/Database.php';

$db = Database::getInstance();

// Kategori ID'lerini al
$cats = $db->fetchAll('SELECT id, slug FROM blog_categories');
$catMap = [];
foreach ($cats as $c) $catMap[$c['slug']] = $c['id'];
$genelId  = $catMap['genel']    ?? 1;
$haberler = $catMap['haberler'] ?? 2;

$posts = [
    [
        'category_id' => $haberler,
        'title'   => '2024 Ev Tekstili Trendleri: Doğal Dokular Ön Planda',
        'slug'    => '2024-ev-tekstili-trendleri',
        'image'   => 'fabrics.jpg',
        'content' => '<p>2024 yılı ev tekstili dünyasında doğal malzemeler ve organik dokular öne çıkıyor. Keten, pamuk ve geri dönüştürülmüş ipliklerden üretilen kumaşlar, hem estetik hem de çevre dostu tercihler arasında yer alıyor.</p><p>Livolia olarak bu trendi çok önce yakaladık. Sürdürülebilir üretim anlayışımızla, global markaların en zorlu beklentilerini karşılayan koleksiyonlarımızı geliştirdik. Doğanın renklerinden ilham alan toprak tonları, krem ve açık bej filamentler bu sezonun en çok talep gören seçenekleri arasında.</p><h3>Öne Çıkan Trendler</h3><ul><li>Organik keten karışımlı perdeler</li><li>Muslin masa örtüleri ve peçeteler</li><li>Geri dönüştürülmüş polyesterden üretilen kırlent kılıfları</li><li>El dokuma detaylı yatak örtüleri</li></ul><p>Koleksiyonlarımız hakkında detaylı bilgi almak için bizimle iletişime geçebilirsiniz.</p>',
        'status'  => 1,
        'created_at' => '2024-03-15 10:00:00',
    ],
    [
        'category_id' => $genelId,
        'title'   => 'Fason Üretimde Kalite Kontrolün Önemi',
        'slug'    => 'fason-uretimde-kalite-kontrol',
        'image'   => 'curtains.jpg',
        'content' => '<p>B2B tekstil üretiminde kalite kontrol, yalnızca son ürünün denetlenmesinden ibaret değildir. Hammadde seçiminden, üretim sürecinin her aşamasına, son paketlemeye kadar sistematik bir kalite yönetimi anlayışı gerekmektedir.</p><p>Livolia\'da uyguladığımız çok aşamalı kalite kontrol sistemi, 30 yılı aşkın deneyimimizin bir ürünüdür. Her bir kumaş partisi, gönderilmeden önce en az üç farklı kontrol sürecinden geçmektedir.</p><h3>Kalite Süreçlerimiz</h3><ul><li>Ham madde giriş kalite kontrolü</li><li>Üretim hattı anlık denetimleri</li><li>Renk ve boyut standart testleri</li><li>Son ürün mukavemet ve dayanıklılık testleri</li><li>ISO 9001 uyumlu dokümantasyon</li></ul><p>Küresel markaların güvenini kazanmak; tutarlı kalite, şeffaf iletişim ve söz verilen teslimat tarihlerine sadakatin bir sonucudur.</p>',
        'status'  => 1,
        'created_at' => '2024-02-20 09:00:00',
    ],
    [
        'category_id' => $haberler,
        'title'   => 'Livolia, Heimtextil Frankfurt 2024\'te Yerini Aldı',
        'slug'    => 'heimtextil-frankfurt-2024',
        'image'   => 'table_linen.jpg',
        'content' => '<p>Dünyanın en prestijli ev tekstili fuarı olan Heimtextil Frankfurt 2024\'e katılan Livolia Tekstil, yeni koleksiyonlarını uluslararası alıcılarla buluşturdu. Üç günlük fuar boyunca 15\'ten fazla ülkeden alıcıyla görüşme gerçekleştirdik.</p><p>Bu yılki teması "Sürdürülebilir Lüks" olan Heimtextil\'de, geri dönüştürülmüş hammaddelerden ürettiğimiz yeni koleksiyonumuz büyük ilgi gördü. Özellikle İskandinav tasarım firmalarının doğal tekstüre ve nötr renk paletine olan talepleri dikkat çekiciydi.</p><p>Fuar katılımımız, global ağımızı genişletme ve yeni ortaklıklar kurma açısından son derece verimli geçti. 2025 fuarında da Livolia standımızda sizleri ağırlamaktan büyük mutluluk duyacağız.</p>',
        'status'  => 1,
        'created_at' => '2024-01-18 14:00:00',
    ],
    [
        'category_id' => $genelId,
        'title'   => 'Sürdürülebilir Lüks: Geleceğin Tekstil Anlayışı',
        'slug'    => 'surdurulebilir-luks-gelecek',
        'image'   => 'cushions.jpg',
        'content' => '<p>Sürdürülebilirlik artık bir tercih değil, bir zorunluluktur. Global markaların tedarikçi seçiminde çevresel kriterler giderek daha belirleyici hale gelmektedir. Bu değişimi öngören Livolia, 2018 yılından itibaren sürdürülebilir üretim yatırımlarını hızlandırdı.</p><p>Bugün itibariyle üretimimizin %40\'ı GRS (Global Recycled Standard) sertifikalı hammaddelerle gerçekleşmektedir. 2027 hedefimiz ise bu oranı %70\'e çıkarmaktır.</p><h3>Çevresel Taahhütlerimiz</h3><ul><li>Su tüketimini %30 azaltmak</li><li>Karbon ayak izini 2030\'a kadar yarıya indirmek</li><li>%100 geri dönüştürülebilir ambalaj kullanımı</li><li>Kimyasal atık sıfır hedefi</li></ul><p>Lüks ve sürdürülebilirlik artık çelişen değil, birbirini tamamlayan kavramlardır. Biz bu gelecekte hem lider hem de örnek olmaya kararlıyız.</p>',
        'status'  => 1,
        'created_at' => '2023-12-05 11:00:00',
    ],
];

$inserted = 0;
foreach ($posts as $p) {
    try {
        // SQLite uyumlu — önce slug var mı kontrol et
        $existing = $db->fetchOne('SELECT id FROM blog_posts WHERE slug = ?', [$p['slug']]);
        if ($existing) {
            echo "⏭️ Zaten var: " . $p['title'] . "<br>";
            continue;
        }
        $db->execute(
            'INSERT INTO blog_posts (category_id, title, slug, content, image, status, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$p['category_id'], $p['title'], $p['slug'], $p['content'], $p['image'], $p['status'], $p['created_at']]
        );
        $inserted++;
        echo "✅ Eklendi: " . $p['title'] . "<br>";
    } catch (Exception $e) {
        echo "⚠️ Hata: " . $p['title'] . " — " . $e->getMessage() . "<br>";
    }
}

echo "<hr><strong>$inserted blog yazısı işlendi.</strong><br>";
echo '<a href="' . ADMIN_URL . '/blog">Admin Panel → Blog</a>';
?>
