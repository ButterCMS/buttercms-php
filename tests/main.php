<?php

require_once __DIR__ . '/vendor/autoload.php';

// Easier for local dev to override the latest commit with the local version of the class
require_once __DIR__ . '/../src/ButterCMS.php';
require_once __DIR__ . '/../src/Model/Model.php';
require_once __DIR__ . '/../src/Model/Category.php';

use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('<auth_token>');
$butterCms->getCategories();
