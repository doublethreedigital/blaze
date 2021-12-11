<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
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
            'icon'   => Blaze::svg('tags'),
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
