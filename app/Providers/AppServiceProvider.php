<?php

namespace App\Providers;

use App\Filament\Widgets\ProductStockChart;
use App\Livewire\ExpenseChart;
use App\Livewire\IncomeChart;
use App\Models\Stock;
use App\Observers\StockObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Stock::observe(StockObserver::class);

    }
}
