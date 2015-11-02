<?php

namespace Projeto\Providers;

use Illuminate\Support\ServiceProvider;

class ProjetoRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Projeto\Repositories\ClientRepository::class, \Projeto\Repositories\ClientRepositoryEloquent::class);
    }
}
