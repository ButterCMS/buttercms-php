# ButterCMS PHP API Wrapper

This wrapper enables PHP developers to quickly and easily get up and running with [ButterCMS](https://buttercms.com/). It is based of off the [API documentation](https://buttercms.com/docs/api/).

## Requirements

PHP 5.3.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require buttercms/buttercms-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/buttercms/buttercms-php/releases). Then, to use the bindings, include the `src/ButterCMS.php` file.

```php
require_once('/path/to/buttercms-php/src/ButterCMS.php');
```

## Example Usage

```php
use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('<auth_token>');

// Feeds - returns a SimpleXMLElement object
$feed = $butterCms->getFeed('rss');

// Posts
$result = $butterCms->getPosts(['page' => 1]);

$meta = $result->getMeta(); // Meta information like pagination
print_r($meta);

$posts = $result->getPosts(); // Get posts array off of result

$post = $posts[0]; // Get the first post
echo $post->getTitle(); // Access attributes using getXxxx() format.
echo $post->getSlug();

$author = $post->getAuthor(); // Access nested objects: Author, Tags, Categories like so
echo $author->getFirstName();
echo $author->getLastName();

// Query for one post
$response = $butterCms->getPost('post-slug');
$post = $response->getPost();
echo $post->getTitle();

// Search
$butterCms->searchPosts('query', ['page' => 1]);

// Authors
$butterCms->getAuthor('author-slug');
$butterCms->getAuthors(['include' => 'recent_posts']);

// Categories
$butterCms->getCategory('category-slug');
$butterCms->getCategories(['include' => 'recent_posts']);

// Tags
$butterCms->getTag('tag-slug');
$butterCms->getTags();

// Content Fields - returns your fields turned in to a multidimensional array
$butterCms->getContentFields(['headline', 'FAQ']);
```
