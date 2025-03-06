<?php
namespace App\Providers;

use App\Domains\ConversionDon\Repositories\ConversionDonRepository;
use App\Infrastructure\Persistence\Repositories\EloquentConversionDonRepository;
use Illuminate\Support\ServiceProvider;

class ConversionDonRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Lier l'interface à l'implémentation concrète
        $this->app->bind(ConversionDonRepository::class, EloquentConversionDonRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Pas besoin d'ajouter quelque chose ici pour l'instant
    }
}
