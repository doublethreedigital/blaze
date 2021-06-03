<?php

namespace DoubleThreeDigital\Zippy\Searchables;

use DoubleThreeDigital\Zippy\Contracts\Searchable;
use DoubleThreeDigital\Zippy\Zippy;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Taxonomy as TaxonomyFacade;

class Taxonomy implements Searchable
{
    public function search(string $query): Collection
    {
        return TaxonomyFacade::all()->filter(function ($taxonomy) use ($query) {
            return false !== stristr($taxonomy->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Zippy::svg('tags'),
            'url'    => $result->showUrl(),
            'target' => '_self',
            'parent' => [
                'title' => __('Taxonomies'),
                'url' => cp_route('taxonomies.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("view {$result->handle()} terms");
    }
}
