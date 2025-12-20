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

    public float $totalStockValue = 0;
    public float $totalModalThisMonth = 0;
    public float $totalRevenueThisMonth = 0;

    public function mount(): void
    {
        // ===== TOTAL PRODUK =====
        $this->totalProducts = Product::count();

        // ===== TOTAL STOCK IN & OUT (QTY) =====
        $this->totalStockIn = DB::table('stock_items')
            ->join('stocks', 'stocks.id', '=', 'stock_items.stock_id')
            ->where('stocks.tipe', 'in')
            ->sum('stock_items.qty');

        $this->totalStockOut = DB::table('stock_items')
            ->join('stocks', 'stocks.id', '=', 'stock_items.stock_id')
            ->where('stocks.tipe', 'out')
            ->sum('stock_items.qty');

        // ===== TOTAL NILAI STOK (CURRENT INVENTORY VALUE) =====
        $this->totalStockValue = Product::select(
            DB::raw('SUM(qty * COALESCE(capital_price, 0)) as total')
        )->value('total') ?? 0;

        // ===== RANGE BULAN INI =====
        $startOfMonth = now()->startOfMonth();
        $endOfMonth   = now()->endOfMonth();

        // ===== TOTAL MODAL BULAN INI (STOCK IN) =====
        $this->totalModalThisMonth = DB::table('stock_items')
            ->join('stocks', 'stocks.id', '=', 'stock_items.stock_id')
            ->join('products', 'products.id', '=', 'stock_items.product_id')
            ->where('stocks.tipe', 'in')
            ->whereBetween('stocks.date', [$startOfMonth, $endOfMonth])
            ->select(DB::raw('SUM(stock_items.qty * products.capital_price) as total'))
            ->value('total') ?? 0;

        // ===== TOTAL PENDAPATAN BULAN INI (STOCK OUT) =====
        $this->totalRevenueThisMonth = DB::table('stock_items')
            ->join('stocks', 'stocks.id', '=', 'stock_items.stock_id')
            ->where('stocks.tipe', 'out')
            ->whereBetween('stocks.date', [$startOfMonth, $endOfMonth])
            ->select(DB::raw('SUM(stock_items.qty * stock_items.price) as total'))
            ->value('total') ?? 0;
    }
}
