<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\UserGroup as UserGroupFacade;

class UserGroup implements Searchable
{
    public function search(string $query): Collection
    {
        return UserGroupFacade::all()->filter(function ($userGroup) use ($query) {
            return false !== stristr($userGroup->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('users-multiple'),
            'url'    => cp_route('user-groups.show', [
                'user_group' => $result->handle(),
            ]),
            'target' => '_self',
            'parent' => [
                'title' => __('Groups'),
                'url' => cp_route('user-groups.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("edit user groups");
    }
}
