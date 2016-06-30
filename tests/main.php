<?php

require_once __DIR__ . '/vendor/autoload.php';

// Easier for local dev to override the latest commit with the local version of the class
require_once __DIR__ . '/../src/ButterCMS.php';
require_once __DIR__ . '/../src/Model/Model.php';
require_once __DIR__ . '/../src/Model/Author.php';
require_once __DIR__ . '/../src/Model/Category.php';
require_once __DIR__ . '/../src/Model/Post.php';
require_once __DIR__ . '/../src/Model/PostResponse.php';
require_once __DIR__ . '/../src/Model/PostsResponse.php';

use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('<auth_token>');
$butterCms->getCategories();
