<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\GlobalSet as GlobalSetFacade;

class GlobalSet implements Searchable
{
    public function search(string $query): Collection
    {
        return GlobalSetFacade::all()->filter(function ($globalSet) use ($query) {
            return false !== stristr($globalSet->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('earth'),
            'url'    => $result->editUrl(),
            'target' => '_self',
            'parent' => [
                'title' => __('Globals'),
                'url' => cp_route('globals.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("edit {$result->handle()} globals");
    }
}
