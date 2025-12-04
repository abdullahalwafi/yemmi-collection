<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Widgets\Widget;

class RecentStocksWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-stocks-widget';

    public $items = [];

    public function mount(): void
    {
        $this->items = Stock::with('product')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();
        
    }
}
