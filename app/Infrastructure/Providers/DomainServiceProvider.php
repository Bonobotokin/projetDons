<?php 
// app/Infrastructure/Providers/DomainServiceProvider.php
namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Budget\Services\BudgetService;
use App\Domains\ConversionDon\Services\ConversionDonService;
use App\Infrastructure\Persistence\Repositories\EloquentBudgetRepository;
use App\Infrastructure\Persistence\Repositories\EloquentConversionDonRepository;

class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BudgetService::class, function ($app) {
            return new BudgetService(new EloquentBudgetRepository());
        });

        $this->app->bind(ConversionDonService::class, function ($app) {
            return new ConversionDonService(new EloquentConversionDonRepository());
        });
    }

    public function boot()
    {
        //
    }
}
