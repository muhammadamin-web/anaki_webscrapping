<?php
require 'vendor/autoload.php';

use Goutte\Client;


$client = new Client();
$crawler = $client->request('GET', 'https://anaki.uz/');

// Scrape the categories
$categories = $crawler->filter('div.product-item div a')->each(function ($node) {
    return $node->text();
});

// Scrape the products
$products = $crawler->filter('div.inner h4 a')->each(function ($node) {
    return [
        'name' => $node->text(),
        'url' => $node->attr('href'),
    ];
});


// Output the results as HTML
echo '<h1>Categories</h1>';
echo '<ul>';
foreach ($categories as $category) {
    echo "<li>$category</li>";
}
echo '</ul>';

echo '<h1>Products</h1>';
echo '<ul>';
foreach ($products as $product) {
    echo "<li><a href='{$product['url']}'>{$product['name']}</a></li>";
}
echo '</ul>';