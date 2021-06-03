<?php

namespace DoubleThreeDigital\Zippy;

use Illuminate\Support\Collection;
use Statamic\Facades\User;
use Statamic\Statamic;

class Zippy
{
    public static function search(string $query): Collection
    {
        return collect(config('zippy.searchables'))
            ->flatMap(function ($searchable) use ($query) {
                $searchable = resolve($searchable);

                if (! $searchable instanceof Contracts\Searchable) {
                    throw new \Exception("Zippy: Searchable [$searchable] does not implement the `Searchable` interface.");
                }

                return collect($searchable->search($query))
                    ->filter(function ($result) use ($searchable) {
                        return $searchable->authorize(User::current(), $result);
                    })
                    ->map(function ($result) use ($searchable) {
                        return $searchable->transform($result);
                    })
                    ->toArray();
            })
            ->take(10);
    }

    public static function svg(string $name): string
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
