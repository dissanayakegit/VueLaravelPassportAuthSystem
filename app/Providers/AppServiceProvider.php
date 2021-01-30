<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Modules\Files\Contracts\FilesRepositoryInterface', 'App\Modules\Files\Repositories\FilesRepository');
        $this->app->bind('App\Modules\Customers\Contracts\CustomersRepositoryInterface', 'App\Modules\Customers\Repositories\CustomersRepository');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
