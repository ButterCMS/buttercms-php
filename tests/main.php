<?php

require_once __DIR__ . '/vendor/autoload.php';

use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('10de91e331dd67ae3e4ee5c383ec8ea8a9427f48');

// Feeds - returns a SimpleXMLElement object
$feed = $butterCms->fetchFeed('rss');

// Posts
$response = $butterCms->fetchPost('test-post');
$post = $response->getPost();
echo $post->getTitle();

$butterCms->fetchPosts(['page' => 1]);
$butterCms->searchPosts('query', ['page' => 1]);

// Authors
$butterCms->fetchAuthor('api-test');
$butterCms->fetchAuthors(['include' => 'recent_posts']);

// Categories
$butterCms->fetchCategory('test-category');
$butterCms->fetchCategories(['include' => 'recent_posts']);

// Content Fields - returns your fields turned in to a multidimensional array
$fields = $butterCms->fetchContentFields(['homepage_headline', 'faq'], ['locale' => 'es']);

var_dump($fields);
