![Banner](https://raw.githubusercontent.com/doublethreedigital/zippy/main/banner.png)

## Zippy

Zippy allows you to zip around the Statamic Control Panel through the power of search. It's basically [Alfred](https://www.alfredapp.com/), if it lived in the CP.

This repository contains the source code for Zippy. While Zippy itself is free and doesn't require a license, you can [donate to Duncan](https://duncanmcclean.com/donate), the developer behind it to show your appreciation.

## Installation

1. Install via Composer `composer require doublethreedigital/zippy`

## Documentation

### Configuration

Out of the box, Zippy is pre-configured. However, you may wish to manually publish Zippy's config file to use your own settings. The following command will publish the file for you:

```
php artisan vendor:publish --tag="zippy-config"
```

Once published, the config file will look a little something like this:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Keyboard Shortcut
    |--------------------------------------------------------------------------
    |
    | Which keyboard shortcut should open Zippy's search overlay?
    | ⌘ and X?
    |
    */

    'keyboard_shortcut' => 'P',

    /*
    |--------------------------------------------------------------------------
    | Searchables
    |--------------------------------------------------------------------------
    |
    | What should Zippy be able to search through?
    | (the order of the searchables will influence the order in the results)
    |
    */

    'searchables' => [
        \DoubleThreeDigital\Zippy\Searchables\StatamicSearch::class,
        \DoubleThreeDigital\Zippy\Searchables\Collection::class,
        \DoubleThreeDigital\Zippy\Searchables\Navigation::class,
        \DoubleThreeDigital\Zippy\Searchables\Taxonomy::class,
        \DoubleThreeDigital\Zippy\Searchables\GlobalSet::class,
        \DoubleThreeDigital\Zippy\Searchables\CPNav::class,
        \DoubleThreeDigital\Zippy\Searchables\Documentation\Documentation::class,
    ],

];
```

#### `keyboard_shortcut`

Zippy is triggered by a keyboard shortcut. By default, this is `⌘ P`, to match a similar menu in VS Code. You can obviously change this to your liking.

However, bear in mind that the keyboard shortcut will always be '⌘ something' (Ctrl on Windows). Right now, there's no way to change this.

#### `searchables`

You can think of 'searchables' as like drivers for 'things' you can search for. For example, Statamic's native search is its own driver, Collection search lives in its own driver, so on.

If you want, you can create your own searchables. Just create a class which implements the [`Searchable`](https://github.com/doublethreedigital/zippy/blob/main/src/Contracts/Searchable.php) interface and add it to the `searchables` array. You can also remove a searchable, just by removing it from that array.

### Usage

To open the Zippy modal, press `⌘ P` on Mac or `Ctrl P` on Windows (unless you've configured otherwise). You may then search for anything you like, out of the box, the following 'searchables' are supported:

* Statamic's Native Search (covers entries, terms and users)
* Collections
* Navigation
* Taxonomies
* Globals
* CP Nav Items
* Statamic Documentation

## Security

From a security perspective, only the latest version will receive a security release if a vulnerability is found.

If you discover a security vulnerability within Zippy, please report it [via email](mailto:duncan@doublethree.digital) straight away. Please don't report security issues in the issue tracker.

## Resources

* [**Issue Tracker**](https://github.com/doublethreedigital/zippy/issues): Find & report bugs in Zippy
* [**Email**](mailto:duncan@doublethree.digital): Support from the developer behind the addon

---

<p>
<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge" alt="Compatible with Statamic v3"></a>
<a href="https://packagist.org/packages/doublethreedigital/zippy/stats"><img src="https://img.shields.io/packagist/v/doublethreedigital/zippy?style=for-the-badge" alt="Zippy on Packagist"></a>
</p>
