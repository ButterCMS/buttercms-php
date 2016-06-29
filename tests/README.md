# ButterCMS PHP API Wrapper
This README contains instructions on how to develop updates or fixes to this wrapper locally.

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
