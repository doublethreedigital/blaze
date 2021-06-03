<?php

namespace DoubleThreeDigital\Zippy\Searchables;

use DoubleThreeDigital\Zippy\Contracts\Searchable;
use DoubleThreeDigital\Zippy\Zippy;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Nav as NavFacade;

class Navigation implements Searchable
{
    public function search(string $query): Collection
    {
        return NavFacade::all()->filter(function ($navigation) use ($query) {
            return false !== stristr($navigation->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Zippy::svg('hierarchy-files'),
            'url'    => $result->showUrl(),
            'target' => '_self',
            'parent' => [
                'title' => __('Navigation'),
                'url' => cp_route('navigation.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("view {$result->handle()} nav");
    }
}
