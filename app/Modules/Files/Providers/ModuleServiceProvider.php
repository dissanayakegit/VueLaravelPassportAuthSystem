<?php

namespace App\Modules\Files\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('files', 'Resources/Lang', 'app'), 'files');
        $this->loadViewsFrom(module_path('files', 'Resources/Views', 'app'), 'files');
        $this->loadMigrationsFrom(module_path('files', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('files', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('files', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
