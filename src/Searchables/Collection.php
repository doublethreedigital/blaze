<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection as IlluminateCollection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Collection as CollectionFacade;

class Collection implements Searchable
{
    public function search(string $query): IlluminateCollection
    {
        return CollectionFacade::all()->filter(function ($collection) use ($query) {
            return false !== stristr($collection->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('content-writing'),
            'url'    => $result->showUrl(),
            'target' => '_self',
            'parent' => [
                'title' => __('Collections'),
                'url' => cp_route('collections.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("view {$result->handle()} entries");
    }
}
