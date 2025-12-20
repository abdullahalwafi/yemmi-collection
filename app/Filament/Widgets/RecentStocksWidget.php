<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Widgets\Widget;

class RecentStocksWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-stocks-widget';

    protected static ?int $sort = 1; // urutan di dashboard

    public array $items = [];

    public function mount(): void
    {
        $this->items = Stock::with(['items.product'])
            ->orderByDesc('date')
            ->limit(6)
            ->get()
            ->map(function ($stock) {
                return [
                    'invoice' => $stock->invoice,
                    'tipe'    => $stock->tipe,
                    'date'    => $stock->date,
                    'items'   => $stock->items->map(fn($item) => [
                        'product' => $item->product->name,
                        'qty'     => $item->qty,
                    ]),
                ];
            })
            ->toArray();
    }
}
