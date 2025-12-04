<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Stock;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class StatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.stats-widget';
    public int $totalProducts = 0;
    public int $totalStockIn = 0;
    public int $totalStockOut = 0;
    public float $totalStockValue = 0.0;

    public float $totalModalThisMonth = 0;
    public float $totalRevenueThisMonth = 0;

    public function mount(): void
    {
        $this->totalProducts = Product::count();

        $this->totalStockIn = Stock::where('tipe', 'in')->sum('qty');
        $this->totalStockOut = Stock::where('tipe', 'out')->sum('qty');

        // nilai stok = sum(products.qty * capital_price)
        $this->totalStockValue = Product::sum(DB::raw('qty * COALESCE(capital_price, 0)'));

        // periode bulan ini
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        // total modal this month = sum(qty * product.capital_price) for 'in' stocks month
        $modalRows = Stock::where('tipe', 'in')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with('product')
            ->get();

        $this->totalModalThisMonth = $modalRows->reduce(function ($carry, $row) {
            $capital = $row->product?->capital_price ?? 0;
            return $carry + ($row->qty * $capital);
        }, 0);

        // total revenue this month = sum(qty * price) for 'out' stocks month
        $revenueRows = Stock::where('tipe', 'out')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();

        $this->totalRevenueThisMonth = $revenueRows->reduce(function ($carry, $row) {
            return $carry + ($row->qty * ($row->price ?? 0));
        }, 0);
    }
}
