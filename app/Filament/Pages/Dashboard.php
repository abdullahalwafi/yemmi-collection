<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsWidget::class,
            \App\Filament\Widgets\RecentStocksWidget::class,
            \App\Filament\Widgets\ProductStockChart::class,
            \App\Filament\Widgets\DailyStockActivityChart::class, // chart baru
        ];
    }
}
