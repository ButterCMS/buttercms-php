<?php

require_once __DIR__ . '/vendor/autoload.php';

use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('fe7098cde166d497fbac00bc5d1b94cc8ce51d0f');

// Feeds - returns a SimpleXMLElement object
$feed = $butterCms->getFeed('rss');

// Posts
$response = $butterCms->getPost('test-post');
$post = $response->getPost();
echo $post->getTitle();


$butterCms->getPosts(['page' => 1]);
$butterCms->searchPosts('query', ['page' => 1]);

// Authors
$butterCms->getAuthor('author-slug');
$butterCms->getAuthors(['include' => 'recent_posts']);

// Categories
$butterCms->getCategory('category-slug');
$butterCms->getCategories(['include' => 'recent_posts']);

// Content Fields - returns your fields turned in to a multidimensional array
$butterCms->getContentFields(['headline', 'FAQ']);
