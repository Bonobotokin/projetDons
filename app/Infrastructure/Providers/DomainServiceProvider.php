<?php 
// app/Infrastructure/Providers/DomainServiceProvider.php
namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Budget\Services\BudgetService;
use App\Domains\ConversionDon\Services\ConversionDonService;
use App\Domains\Dons\Services\DonsService;
use App\Infrastructure\Persistence\Repositories\EloquentBudgetRepository;
use App\Infrastructure\Persistence\Repositories\EloquentConversionDonRepository;
use App\Infrastructure\Persistence\Repositories\EloquentDonsRepository;

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

        $this->app->bind(DonsService::class, function ($app) {
            return new DonsService(new EloquentDonsRepository());
        });
    }

    public function boot()
    {
        //
    }
}
