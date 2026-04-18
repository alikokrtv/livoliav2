<?php
/**
 * sitemap.php — Dynamic XML Sitemap
 */
require_once 'inc/config.php';
require_once 'inc/Database.php';

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

$db    = Database::getInstance();
$base  = BASE_URL;
$today = date('Y-m-d');

$staticPages = [
    ['loc' => $base . '/',            'lastmod' => $today, 'changefreq' => 'weekly',  'priority' => '1.0'],
    ['loc' => $base . '/contact.php', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => $base . '/blog.php',    'lastmod' => $today, 'changefreq' => 'daily',   'priority' => '0.9'],
    ['loc' => $base . '/kvkk.php',    'lastmod' => $today, 'changefreq' => 'yearly',  'priority' => '0.3'],
    ['loc' => $base . '/cerez.php',   'lastmod' => $today, 'changefreq' => 'yearly',  'priority' => '0.3'],
];

// Blog posts
$posts = $db->fetchAll("SELECT slug, updated_at FROM blog_posts WHERE status = 1 ORDER BY updated_at DESC");

$blogUrls = [];
foreach ($posts as $p) {
    $blogUrls[] = [
        'loc'        => $base . '/blog-detail.php?slug=' . urlencode($p['slug']),
        'lastmod'    => date('Y-m-d', strtotime($p['updated_at'])),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ];
}
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach (array_merge($staticPages, $blogUrls) as $url): ?>
    <url>
        <loc><?= htmlspecialchars($url['loc']) ?></loc>
        <lastmod><?= $url['lastmod'] ?></lastmod>
        <changefreq><?= $url['changefreq'] ?></changefreq>
        <priority><?= $url['priority'] ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
