## Configuration

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

### `keyboard_shortcut`

Blaze is triggered by a keyboard shortcut. By default, this is `⌘ P`, to match a similar menu in VS Code. You can obviously change this to your liking.

However, bear in mind that the keyboard shortcut will always be '⌘ something' (Ctrl on Windows). Right now, there's no way to change this.

### `searchables`

You can think of 'searchables' as like drivers for 'things' you can search for. For example, Statamic's native search is its own driver, Collection search lives in its own driver, so on.

If you want, you can create your own searchables. Just create a class which implements the [`Searchable`](https://github.com/doublethreedigital/blaze/blob/main/src/Contracts/Searchable.php) interface and add it to the `searchables` array. You can also remove a searchable, just by removing it from that array.

## Usage

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
