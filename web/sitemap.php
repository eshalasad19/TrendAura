<?php
// Dynamic XML sitemap — reflects current products/categories automatically,
// so it never goes stale like a hand-written sitemap.xml would.
include('config/db.php');

header('Content-Type: application/xml; charset=utf-8');

// TODO: replace with your real live domain once deployed.
$base_url = 'https://YOUR-DOMAIN.com';

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Static pages
$static_pages = [
    '' => '1.0',
    'shop-default.php' => '0.9',
    'shop_collection.php' => '0.8',
    'about-us.php' => '0.5',
    'contact.php' => '0.5',
];
foreach ($static_pages as $path => $priority) {
    echo "  <url>\n";
    echo "    <loc>{$base_url}/{$path}</loc>\n";
    echo "    <priority>{$priority}</priority>\n";
    echo "  </url>\n";
}

// Product pages
$sql = "SELECT product_id FROM product";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = (int) $row['product_id'];
        echo "  <url>\n";
        echo "    <loc>{$base_url}/product_details.php?product_id={$pid}</loc>\n";
        echo "    <priority>0.7</priority>\n";
        echo "  </url>\n";
    }
}

echo '</urlset>';
