<?php

require_once 'vendor/autoload.php';

use ButterCMS\ButterCMS;

$apiKey = getenv('API_KEY');
if (empty($apiKey)) {
    die("API_KEY environment variable is not set\n");
}

$client = new ButterCMS($apiKey);

try {
    $params = ['preview' => 1];
    $page = $client->fetchPage('*', 'test-page-1', $params);
    echo "Page Slug: " . $page->getSlug() . "\n";
    echo "Page Status: " . $page->getStatus() . "\n";
    echo "Page Scheduled Date: " . $page->getScheduled() . "\n";
} catch (Exception $e) {
    echo "Error fetching page: " . $e->getMessage() . "\n";
}

try {
    $postResponse = $client->fetchPost('test-blog-post');
    $post = $postResponse->getPost();
    echo "Post Slug: " . $post->getSlug() . "\n";
    echo "Post Status: " . $post->getStatus() . "\n";
    echo "Post Scheduled Date: " . $post->getScheduled() . "\n";
} catch (Exception $e) {
    echo "Error fetching post: " . $e->getMessage() . "\n";
}

?>