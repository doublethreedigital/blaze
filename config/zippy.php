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
