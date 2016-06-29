# ButterCMS PHP API Wrapper

## Example Usage
```php
use ButterCMS\ButterCMS;

$butterCms = new ButterCMS('<auth_token>');
$posts = $butterCms->getPosts('rss');
```

## Composer Support
To install via Composer simply require `buttercms/api-wrapper` in your `composer.json` file.
