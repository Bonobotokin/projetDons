<?php 
// app/Providers/BudgetRepositoryServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Budget\Repositories\BudgetRepository;
use App\Infrastructure\Persistence\Repositories\EloquentBudgetRepository;

class BudgetRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Lier l'interface à l'implémentation concrète
        $this->app->bind(BudgetRepository::class, EloquentBudgetRepository::class);
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
