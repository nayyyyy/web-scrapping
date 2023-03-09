<?php

namespace App\Providers;

use App\Interfaces\ScrapRepositoryInterface;
use App\Repositories\ScrapRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ScrapRepositoryInterface::class, ScrapRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
