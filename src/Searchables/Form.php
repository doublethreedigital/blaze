<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\Form as FormFacade;

class Form implements Searchable
{
    public function search(string $query): Collection
    {
        return FormFacade::all()->filter(function ($form) use ($query) {
            return false !== stristr($form->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('drawer-file'),
            'url'    => $result->editUrl(),
            'target' => '_self',
            'parent' => [
                'title' => __('Forms'),
                'url' => cp_route('forms.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can("edit {$result->handle()} globals");
    }
}
