<?php

namespace DoubleThreeDigital\Zippy;

use Illuminate\Support\Collection;
use Statamic\Facades\Collection as StatamicCollection;
use Statamic\Facades\GlobalSet as StatamicGlobalSet;
use Statamic\Facades\Nav as StatamicNavigation;
use Statamic\Facades\Search;
use Statamic\Facades\Taxonomy as StatamicTaxonomy;
use Statamic\Facades\User;
use Statamic\Statamic;

class Zippy
{
    public static function search(string $query): Collection
    {
        return Search::index()
            ->ensureExists()
            ->search($query)
            ->get()
            ->filter(function ($item) {
                return User::current()->can('view', $item);
            })
            ->merge(StatamicCollection::all()->filter(function ($collection) use ($query) {
                return false !== stristr($collection->title(), $query);
            }))
            ->merge(StatamicNavigation::all()->filter(function ($navigation) use ($query) {
                return false !== stristr($navigation->title(), $query);
            }))
            ->merge(StatamicTaxonomy::all()->filter(function ($taxonomy) use ($query) {
                return false !== stristr($taxonomy->title(), $query);
            }))
            ->merge(StatamicGlobalSet::all()->filter(function ($globalSet) use ($query) {
                return false !== stristr($globalSet->title(), $query);
            }))
            ->merge(Nav\Nav::search($query))
            ->merge(Documentation\Documentation::search($query))
            ->take(10)
            ->map(function ($result) {
                return static::transformResult($result);
            });
    }

    /**
     * Transforms objects into a suitable array for
     * Zippy's frontend.
     */
    protected static function transformResult($result): array
    {
        if ($result instanceof \Statamic\Contracts\Entries\Entry) {
            return [
                'title'  => $result->get('title'),
                'icon'   => static::svg('content-writing'),
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
                'icon'   => static::svg('tags'),
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
                'icon'   => static::svg('assets'),
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
                'icon'   => static::svg('users-box'),
                'url'    => $result->editUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => __('Users'),
                    'url' => cp_route('users.index'),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Entries\Collection) {
            return [
                'title'  => $result->title(),
                'icon'   => static::svg('content-writing'),
                'url'    => $result->showUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => __('Collections'),
                    'url' => cp_route('collections.index'),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Structures\Nav) {
            return [
                'title'  => $result->title(),
                'icon'   => static::svg('hierarchy-files'),
                'url'    => $result->showUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => __('Navigation'),
                    'url' => cp_route('navigation.index'),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Taxonomies\Taxonomy) {
            return [
                'title'  => $result->title(),
                'icon'   => static::svg('tags'),
                'url'    => $result->showUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => __('Taxonomies'),
                    'url' => cp_route('taxonomies.index'),
                ],
            ];
        }

        if ($result instanceof \Statamic\Contracts\Globals\GlobalSet) {
            return [
                'title'  => $result->title(),
                'icon'   => static::svg('earth'),
                'url'    => $result->editUrl(),
                'target' => '_self',
                'parent' => [
                    'title' => __('Globals'),
                    'url' => cp_route('globals.index'),
                ],
            ];
        }

        if ($result instanceof \Statamic\CP\Navigation\NavItem) {
            return [
                'title'  => $result->name(),
                'icon'   => $result->icon(),
                'url'    => $result->url(),
                'target' => '_self',
                'parent' => [
                    'title' => 'Control Panel',
                    'url' => cp_route('dashboard'),
                ],
            ];
        }

        if ($result instanceof Documentation\DocumentationHit) {
            return [
                'title'  => $result->title(),
                'icon'   => static::svg('statamic-rad-logo'),
                'url'    => $result->url(),
                'target' => '_blank',
                'parent' => [
                    'title' => 'Documentation',
                    'url' => 'https://statamic.dev',
                ],
            ];
        }

        throw new \Exception("Zippy: Unknown result type.");
    }

    protected static function svg(string $name): string
    {
        if (app()->environment('testing')) {
            return '';
        }

        if ($svg = Statamic::svg($name)) {
            return $svg;
        }

        return file_get_contents(__DIR__.'/../resources/svg/'.$name.'.svg');
    }
}
