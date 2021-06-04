<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Contracts\Searchable;
use DoubleThreeDigital\Blaze\Blaze;
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
            'icon'   => Blaze::svg('hierarchy-files'),
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
