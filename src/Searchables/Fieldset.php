<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Fieldset as FieldsetFacade;

class Fieldset implements Searchable
{
    public function search(string $query): Collection
    {
        return FieldsetFacade::all()->filter(function ($fieldset) use ($query) {
            return false !== stristr($fieldset->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('fieldsets'),
            'url'    => cp_route('fieldsets.edit', [
                'fieldset' => $result->handle(),
            ]),
            'target' => '_self',
            'parent' => [
                'title' => __('Fieldsets'),
                'url' => cp_route('fieldsets.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("configure fields");
    }
}
