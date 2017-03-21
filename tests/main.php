<?php

require_once __DIR__ . '/vendor/autoload.php';

use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('fe7098cde166d497fbac00bc5d1b94cc8ce51d0f');

// Feeds - returns a SimpleXMLElement object
$feed = $butterCms->getFeed('rss');

// Posts
$response = $butterCms->fetchPost('test-post');
$post = $response->getPost();
echo $post->getTitle();

$butterCms->fetchPosts(['page' => 1]);
$butterCms->searchPosts('query', ['page' => 1]);

// Authors
$butterCms->fetchAuthor('author-slug');
$butterCms->fetchAuthors(['include' => 'recent_posts']);

// Categories
$butterCms->fetchCategory('category-slug');
$butterCms->fetchCategories(['include' => 'recent_posts']);

// Content Fields - returns your fields turned in to a multidimensional array
$butterCms->fetchContentFields(['headline', 'FAQ']);
