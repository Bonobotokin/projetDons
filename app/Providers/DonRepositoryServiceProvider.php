<?php

namespace App\Providers;

use App\Domains\Dons\Repositories\DonRepository;
use App\Infrastructure\Persistence\Repositories\EloquentDonsRepository;
use Illuminate\Support\ServiceProvider;

class DonRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(DonRepository::class, EloquentDonsRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
