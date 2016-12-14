<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(\App\Repositories\NasabahRepository::class, \App\Repositories\NasabahRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\KoperasiRepository::class, \App\Repositories\KoperasiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\JenisTransaksiRepository::class, \App\Repositories\JenisTransaksiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PegawaiRepository::class, \App\Repositories\PegawaiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NasabahRepository::class, \App\Repositories\NasabahRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\KoperasiRepository::class, \App\Repositories\KoperasiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TransaksiRepository::class, \App\Repositories\TransaksiRepositoryEloquent::class);
        //:end-bindings:
    }
}
