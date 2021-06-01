<?php

namespace DoubleThreeDigital\Zippy\Nav;

use Statamic\Facades\CP\Nav as NavFacade;

class Nav
{
    public static function search(string $query)
    {
        NavFacade::build();

        return collect(NavFacade::items())->filter(function ($navItem) use ($query) {
            return false !== stristr($navItem->name(), $query);
        });
    }
}
