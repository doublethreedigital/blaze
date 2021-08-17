<!-- statamic:hide -->

![Banner](https://raw.githubusercontent.com/doublethreedigital/blaze/main/banner.png)

## Blaze

<!-- /statamic:hide -->

Blaze amplifies the search inside the Control Panel - linking you to entries, collections, nav items & documentation. It's almost like [Alfred](https://www.alfredapp.com/), but built inside the CP. <!-- statamic:hide --> [**Watch a short demo video**](https://www.loom.com/share/921195d9d2074811af4ba1179623008b) <!-- /statamic:hide -->

This repository contains the source code for Blaze. While Blaze itself is free and doesn't require a license, you can [donate to Duncan](https://duncanmcclean.com/donate), the developer behind it to show your appreciation.

## Installation

1. Install via Composer `composer require doublethreedigital/blaze`
2. That's it. All done! Use it with: `⌘ P` (or `Ctrl P`)

## Documentation

### Configuration

Out of the box, Blaze is pre-configured. However, you may wish to manually publish Blaze's config file to use your own settings. The following command will publish the file for you:

```
php artisan vendor:publish --tag="blaze-config"
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
    | Which keyboard shortcut should open Blaze's search overlay?
    | ⌘ and X?
    |
    */

    'keyboard_shortcut' => 'P',

    /*
    |--------------------------------------------------------------------------
    | Searchables
    |--------------------------------------------------------------------------
    |
    | What should Blaze be able to search through?
    | (the order of the searchables will influence the order in the results)
    |
    */

    'searchables' => [
        \DoubleThreeDigital\Blaze\Searchables\StatamicSearch::class,
        \DoubleThreeDigital\Blaze\Searchables\Collection::class,
        \DoubleThreeDigital\Blaze\Searchables\Navigation::class,
        \DoubleThreeDigital\Blaze\Searchables\Taxonomy::class,
        \DoubleThreeDigital\Blaze\Searchables\GlobalSet::class,
        \DoubleThreeDigital\Blaze\Searchables\CPNav::class,
        \DoubleThreeDigital\Blaze\Searchables\Blueprint::class,
        \DoubleThreeDigital\Blaze\Searchables\Fieldset::class,
        \DoubleThreeDigital\Blaze\Searchables\Utility::class,
        \DoubleThreeDigital\Blaze\Searchables\UserGroup::class,
        \DoubleThreeDigital\Blaze\Searchables\UserRole::class,
        \DoubleThreeDigital\Blaze\Searchables\Documentation\Documentation::class,
    ],

];
```

#### `keyboard_shortcut`

Blaze is triggered by a keyboard shortcut. By default, this is `⌘ P`, to match a similar menu in VS Code. You can obviously change this to your liking.

However, bear in mind that the keyboard shortcut will always be '⌘ something' (Ctrl on Windows). Right now, there's no way to change this.

#### `searchables`

You can think of 'searchables' as like drivers for 'things' you can search for. For example, Statamic's native search is its own driver, Collection search lives in its own driver, so on.

If you want, you can create your own searchables. Just create a class which implements the [`Searchable`](https://github.com/doublethreedigital/blaze/blob/main/src/Contracts/Searchable.php) interface and add it to the `searchables` array. You can also remove a searchable, just by removing it from that array.

### Usage

To open the Blaze modal, press `⌘ P` on Mac or `Ctrl P` on Windows (unless you've configured otherwise). You can either press the same keyboard shortcut again to exit or you can press `Escape`. You may then search for anything you like, out of the box, the following 'searchables' are supported:

* Statamic's Native Search (covers entries, terms and users)
* Collections
* Navigation
* Taxonomies
* Globals
* CP Nav Items
* Blueprints / Fieldsets
* Utilities
* User Groups & Permissions
* Statamic Documentation

## Security

From a security perspective, only the latest version will receive a security release if a vulnerability is found.

If you discover a security vulnerability within Blaze, please report it [via email](mailto:duncan@doublethree.digital) straight away. Please don't report security issues in the issue tracker.

## Resources

* [**Issue Tracker**](https://github.com/doublethreedigital/blaze/issues): Find & report bugs in Blaze
* [**Email**](mailto:help@doublethree.digital): Support from the developer behind the addon

<!-- statamic:hide -->

---

<p>
<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge" alt="Compatible with Statamic v3"></a>
<a href="https://packagist.org/packages/doublethreedigital/blaze/stats"><img src="https://img.shields.io/packagist/v/doublethreedigital/blaze?style=for-the-badge" alt="Blaze on Packagist"></a>
</p>

<!-- /statamic:hide -->
