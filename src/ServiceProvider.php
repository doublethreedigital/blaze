<?php

namespace DoubleThreeDigital\Blaze;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $config = false;

    protected $scripts = [
        __DIR__.'/../resources/dist/js/cp.js',
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    public function boot()
    {
        parent::boot();

        $this->mergeConfigFrom(__DIR__.'/../config/blaze.php', 'blaze');

        $this->publishes([
            __DIR__.'/../config/blaze.php',
        ], 'blaze-config');
    }
}
