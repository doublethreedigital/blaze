<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Utility as UtilityFacade;

class Utility implements Searchable
{
    public function search(string $query): Collection
    {
        return UtilityFacade::all()->filter(function ($collection) use ($query) {
            return false !== stristr($collection->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg($result->icon()),
            'url'    => $result->url(),
            'target' => '_self',
            'parent' => [
                'title' => __('Utilities'),
                'url' => cp_route('utilities.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("access {$result->handle()} utility");
    }
}
