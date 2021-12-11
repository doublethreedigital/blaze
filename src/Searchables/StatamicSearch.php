<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection as IlluminateCollection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Search;

class StatamicSearch implements Searchable
{
    public function search(string $query): IlluminateCollection
    {
        return Search::index()
            ->ensureExists()
            ->search($query)
            ->get();
    }

    public function transform($result): array
    {
        if ($result instanceof \Statamic\Contracts\Entries\Entry) {
            return [
                'title'  => $result->get('title'),
                'icon'   => Blaze::svg('content-writing'),
                'url'    => $result->editUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => $result->collection()->title(),
                    'url' => $result->collection()->editUrl(),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Taxonomies\Term) {
            return [
                'title'  => $result->get('title'),
                'icon'   => Blaze::svg('tags'),
                'url'    => $result->editUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => $result->taxonomy()->title(),
                    'url' => $result->taxonomy()->editUrl(),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Assets\Asset) {
            return [
                'title'  => $result->filename(),
                'icon'   => Blaze::svg('assets'),
                'url'    => $result->url(),
                'target' => '_self',
                'parent' => [
                    'title' => $result->container()->handle(),
                    'url' => $result->container()->editUrl(),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Auth\User) {
            return [
                'title'  => $result->title(),
                'icon'   => Blaze::svg('users-box'),
                'url'    => $result->editUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => __('Users'),
                    'url' => cp_route('users.index'),
                ],
            ];
        }
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can('view', $result);
    }
}
