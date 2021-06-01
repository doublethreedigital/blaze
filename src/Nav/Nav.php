<?php

namespace DoubleThreeDigital\Zippy\Nav;

use Statamic\Facades\CP\Nav as NavFacade;

class Nav
{
    public static function search(string $query)
    {
        NavFacade::build();

        return NavFacade::items();
    }
}
