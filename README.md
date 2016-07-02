## ButterCMS PHP API Wrapper
This wrapper is meant to enable PHP developers to quickly and easily get up and running with [ButterCMS](https://buttercms.com/). It is based of off the [API documentation](https://buttercms.com/docs/api/).

## Example Usage
```php
use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('<auth_token>');

// Feeds - returns a SimpleXMLElement object
$feed = $butterCms->getFeed('rss');

// Posts
$butterCms->getPost('post-slug');
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
```

## Composer Support
To install via Composer simply require `buttercms/api-wrapper` in your `composer.json` file.
