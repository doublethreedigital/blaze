<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\CP\Nav as NavFacade;

class CPNav implements Searchable
{
    public function search(string $query): Collection
    {
        NavFacade::build();

        return collect(NavFacade::items())->filter(function ($navItem) use ($query) {
            return false !== stristr($navItem->name(), $query);
        });
    }

    public function transform($result): array
    {
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

    public function authorize(User $user, $result): bool
    {
        // TODO: maybe we shouldn't always authorize this to true?
        if (! $result->authorization()) {
            return true;
        }

        return $user->can($result->authorization()->ability);
    }
}
