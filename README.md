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
$feed = $butterCms->fetchFeed('rss');

// Posts
$result = $butterCms->fetchPosts(['page' => 1]);

$meta = $result->getMeta(); // Meta information like pagination
print_r($meta);

$posts = $result->getPosts(); // Get posts array off of result

$post = $posts[0]; // Get the first post
echo $post->getTitle(); // Access attributes using getXxxx() format.
echo $post->getSlug();

$author = $post->getAuthor(); // Access nested objects: Author, Tags, Categories like so
echo $author->getFirstName();
echo $author->getLastName();

// Loop through posts
foreach ($posts as $post) {
    echo $post->getTitle();
}

// Query for one post
$response = $butterCms->fetchPost('post-slug');
$post = $response->getPost();
echo $post->getTitle();

// Search
$butterCms->searchPosts('query', ['page' => 1]);

// Authors
$butterCms->fetchAuthor('author-slug');
$butterCms->fetchAuthors(['include' => 'recent_posts']);

// Categories
$butterCms->fetchCategory('category-slug');
$butterCms->fetchCategories(['include' => 'recent_posts']);

// Pages
$page = $butterCms->fetchPage('about', 'welcome-to-the-site');

// These are equivalent
echo $page->getFields()['some-field'];
echo $page->getField('some-field');

$pagesResponse = $butterCms->fetchPages('news', ['breaking-news' => true]);
var_dump($pagesResponse->getMeta()['count']);
foreach ($pagesResponse->getPages() as $page) {
    echo $page->getSlug();
}

// Tags
$butterCms->fetchTag('tag-slug');
$butterCms->fetchTags();

// Content Fields - returns your fields turned in to a multidimensional array
$butterCms->fetchContentFields(['headline', 'FAQ'], ['test' => '1']);
// This results in https://api.buttercms.com/v2/content/?keys=headline,FAQ&test=1&auth_token=

// Error Handling
try {
    $butterCms->fetchPage('about', 'non-existent-page');
} catch (GuzzleHttp\Exception\BadResponseException $e) {
    // Happens for any non-200 response from the API
    var_dump($e->getMessage());
} catch (\UnexpectedValueException $e) {
    // Happens if there is an issue parsing the JSON response
    var_dump($e->getMessage());
}
```

### Other

View PHP [Blog engine](https://buttercms.com/php-blog-engine/) and [Full CMS](https://buttercms.com/php-cms/) for other examples of using ButterCMS with PHP.
