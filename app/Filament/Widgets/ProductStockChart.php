<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

class ProductStockChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Stok Produk';
    protected static ?string $maxHeight = '275px';
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
            ],
        ];
    }
    protected function getData(): array
    {
        $products = Product::orderBy('name')->get();
        return [
            'datasets' => [
                [
                    'label' => 'Stok Produk',
                    'data'  => $products->pluck('qty'),
                    'backgroundColor' => [
                        '#F59E0B',
                        '#10B981',
                        '#3B82F6',
                        '#EF4444',
                        '#8B5CF6',
                        '#EC4899',
                        '#14B8A6',
                        '#A78BFA'
                    ],
                ],
            ],
            'labels' => $products->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
