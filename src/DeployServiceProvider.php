<?php

namespace Roshandelpoor\Deploy;

use Illuminate\Support\ServiceProvider;
use Roshandelpoor\Deploy\commands\Deploy;

class DeployServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('deploy', function ($app) {
            return new Deploy();
        });

        $this->commands([
            'deploy',
        ]);
    }

    public function boot()
    {

    }
}
