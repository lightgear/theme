# Drop-in theme support for Laravel 4

## Overview
The Lightgear Theme package adds support for themes to a Laravel 4 application.

## Features

* Views overrides for both **app** and **packages**
* Theme assets (css, less and js) support via [Lightgear Asset](https://github.com/lightgear/asset "") package

## Installation

### Via Laravel 4 Package Installer
```bash
php artisan package:install lightgear/theme
```
### Manual
Just require
```json
"lightgear/theme": "dev-master"
```
in your composer.json
and run
```bash
composer update
```
Then register the service provider
```php
'Lightgear\Asset\ThemeServiceProvider'
```
and, optionally, the alias
```php
'Theme' => 'Lightgear\Theme\Facades\Theme'
```
in **app/config/app.php**

Important: regardless of the installation method, until I find a better way to handle this, make sure to have the ThemeServiceProvider as **the last registered** or, at least, **after the service providers containing the views you want to override**.  
This is needed in order to override the packages' views.

## Usage
First create the directory that will contain your themes.
By default this is "themes" located in the application root but this can be changed in the config file.
A tipical theme structure would be:

```php

themes
  |__mytheme
     |__css/
     |__less/
     |__js/
     |__views/
     |__info.php

```

As you notice each theme must have an **info.php** file with the following contents:

```php

return array(
    'name' => 'My theme',
    'description' => 'A good desc',
    'author' => 'Donato Rotunno',
    'version' => 1.0,
    'styles' => array(
        'paths' => array(
            'less',
            'css'
        ),
        'package' => 'mytheme',
        'group' => 'frontend' // optional asset group
    ),
    'scripts' => array(
        'paths' => array(
            'js',
        ),
        'package' => 'mytheme',
        'group' => 'frontend' // optional asset group
    ),
);

```
This is a pretty simple structure.
For more information about the theme assets, please refer to [Lightgear Asset](https://github.com/lightgear/asset "") documentation.

## Views overrides
To override any views (be it from app or package) just create the corresponding file in the views directory.  
For example, to override the view **package::posts.index** just create the file **views/package/posts/index.php**.
The same goes with the views located in the app.
The view **posts.index** would be overridden in **views/posts/index.php**.

## Configuration
Both the themes directory and the active theme can be set in the config file.

## Changelog
0.5: initial release
