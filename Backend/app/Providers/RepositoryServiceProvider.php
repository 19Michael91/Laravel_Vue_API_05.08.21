<?php

namespace App\Providers;

use App\Repositories\Interfaces\OrganisationRepositoryInterface;
use App\Repositories\OrganisationRepository;
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
        $this->app->bind(OrganisationRepositoryInterface::class, OrganisationRepository::class);
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
