<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DailyStockActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan dan Pemasukan bulan ini';
    
    protected function getData(): array
    {
        // Ambil data 30 hari terakhir
        $start = now()->subDays(30)->format('Y-m-d');

        $in = Stock::select(DB::raw('DATE(date) as date'), DB::raw('SUM(price) as total'))
            ->where('tipe', 'in')
            ->where('date', '>=', $start)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $out = Stock::select(DB::raw('DATE(date) as date'), DB::raw('SUM(price) as total'))
            ->where('tipe', 'out')
            ->where('date', '>=', $start)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Generate tanggal lengkap 30 hari
        $dates = [];
        $stockIn = [];
        $stockOut = [];

        for ($i = 30; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $dates[] = $day;
            $stockIn[] = $in[$day]->total ?? 0;
            $stockOut[] = $out[$day]->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran',
                    'data' => $stockIn,
                    'borderColor' => '#10B981', // emerald-500
                    'backgroundColor' => 'rgba(16, 185, 129, 0.3)',
                ],
                [
                    'label' => 'Pemasukan',
                    'data' => $stockOut,
                    'borderColor' => '#EF4444', // red-500
                    'backgroundColor' => 'rgba(239, 68, 68, 0.3)',
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
