<?php

namespace DoubleThreeDigital\Blaze\Searchables;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Contracts\Searchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Statamic\Contracts\Auth\User;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Blueprint as BlueprintFacade;
use Statamic\Fields\Blueprint as FieldsBlueprint;

class Blueprint implements Searchable
{
    public function search(string $query): Collection
    {
        $paths = $this->getPossibleBlueprintNamespaces();
        $bluerints = $this->getBlueprints($paths);

        return collect($bluerints)->filter(function ($blueprint) use ($query) {
            return false !== stristr($blueprint->title(), $query);
        });
    }

    public function transform($result): array
    {
        return [
            'title'  => $result->title(),
            'icon'   => Blaze::svg('blueprint'),
            'url'    => $this->getBlueprintUrl($result),
            'target' => '_self',
            'parent' => [
                'title' => __('Blueprints'),
                'url' => cp_route('blueprints.index'),
            ],
        ];
    }

    public function authorize(User $user, $result): bool
    {
        return $user->can('configure fields');
    }

    protected function getPossibleBlueprintNamespaces()
    {
        $paths = [];

        foreach (File::directories(BlueprintFacade::directory()) as $directory) {
            $paths[] = str_after($directory, BlueprintFacade::directory());

            foreach (File::directories($directory) as $secondDirectory) {
                $paths[] = str_after($secondDirectory, BlueprintFacade::directory());
            }
        }

        return $paths;
    }

    protected function getBlueprints(array $paths)
    {
        $blueprints = [];

        foreach ($paths as $path) {
            $blueprints = array_merge($blueprints, BlueprintFacade::in($path)->all());
        }

        return $blueprints;
    }

    protected function getBlueprintUrl(FieldsBlueprint $blueprint)
    {
        if (str_starts_with($blueprint->namespace(), 'assets')) {
            return cp_route('asset-containers.blueprint.edit', [
                'asset_container' => AssetContainer::all()->first()->id(), // TODO
            ]);
        }

        if (str_starts_with($blueprint->namespace(), 'collections')) {
            $collectionHandle = explode('.', $blueprint->namespace())[1];

            return cp_route('collections.blueprints.edit', [
                'collection' => $collectionHandle,
                'blueprint'  => $blueprint->handle(),
            ]);
        }

        if (str_starts_with($blueprint->namespace(), 'form')) {
            $form = explode('.', $blueprint->namespace())[1];

            return cp_route('forms.blueprints.edit', [
                'form' => $form,
                'blueprint'  => $blueprint->handle(),
            ]);
        }

        if (str_starts_with($blueprint->namespace(), 'global')) {
            $globalSet = explode('.', $blueprint->namespace())[1];

            return cp_route('globals.blueprints.edit', [
                'global_set' => $globalSet,
                'blueprint'  => $blueprint->handle(),
            ]);
        }

        if (str_starts_with($blueprint->namespace(), 'taxonomies')) {
            $taxonomy = explode('.', $blueprint->namespace())[1];

            return cp_route('taxonomies.blueprints.edit', [
                'taxonomy' => $taxonomy,
                'blueprint'  => $blueprint->handle(),
            ]);
        }

        if (str_starts_with($blueprint->namespace(), 'users')) {
            return cp_route('users.blueprints.edit');
        }

        return '#';
    }
}
