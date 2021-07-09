<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Role;

class UserRole implements Searchable
{
    public function search(string $query): Collection
    {
        return Role::all()->filter(function ($role) use ($query) {
            return false !== stristr($role->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('shield-key'),
            'url'    => cp_route('roles.show', [
                'role' => $result->handle(),
            ]),
            'target' => '_self',
            'parent' => [
                'title' => __('Permissions'),
                'url' => cp_route('roles.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("edit roles");
    }
}
