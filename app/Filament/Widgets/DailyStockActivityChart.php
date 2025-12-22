<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DailyStockActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Pemasukan & Penjualan 30 Hari Terakhir';
    protected static ?string $maxHeight = '275px';

    protected function getData(): array
    {
        $start = now()->subDays(30)->startOfDay();

        // ===== STOCK MASUK (IN) =====
        $stockIn = Stock::query()
            ->join('stock_items', 'stocks.id', '=', 'stock_items.stock_id')
            ->where('stocks.tipe', 'in')
            ->whereDate('stocks.date', '>=', $start)
            ->selectRaw('DATE(stocks.date) as date, SUM(stock_items.qty * stock_items.price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // ===== STOCK KELUAR (OUT) =====
        $stockOut = Stock::query()
            ->join('stock_items', 'stocks.id', '=', 'stock_items.stock_id')
            ->where('stocks.tipe', 'out')
            ->whereDate('stocks.date', '>=', $start)
            ->selectRaw('DATE(stocks.date) as date, SUM(stock_items.qty * stock_items.price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // ===== RANGE TANGGAL =====
        $dates = [];
        $inData = [];
        $outData = [];

        for ($i = 30; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $dates[] = $day;
            $inData[] = (float) ($stockIn[$day] ?? 0);
            $outData[] = (float) ($stockOut[$day] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan Stok (IN)',
                    'data' => $inData,
                    'borderColor' => '#10B981', // emerald
                    'backgroundColor' => 'rgba(16, 185, 129, 0.3)',
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Penjualan (OUT)',
                    'data' => $outData,
                    'borderColor' => '#EF4444', // red
                    'backgroundColor' => 'rgba(239, 68, 68, 0.3)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
