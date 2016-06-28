# ButterCMS PHP API Wrapper

## Local Development
The `/tests` folder is set up to make local development and testing a little easier.
Running the following commands will use the latest commit of the code as the package.

```
cd tests
composer install
php main.php
```

When new files are added, they must first be committed before the local dev environment will find them.
Once they are committed, run the following command in the `/tests` folder.
```
composer update
```

## Composer Support
To install via Composer simply require `buttercms/api-wrapper` in your `composer.json` file.
