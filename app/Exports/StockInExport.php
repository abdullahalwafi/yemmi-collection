<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockInExport implements FromCollection, WithHeadings
{
    public function __construct(
        public string $start,
        public string $end
    ) {}

    public function collection()
    {
        return DB::table('stocks')
            ->join('stock_items', 'stocks.id', '=', 'stock_items.stock_id')
            ->join('products', 'products.id', '=', 'stock_items.product_id')
            ->where('stocks.tipe', 'in')
            ->whereDate('stocks.date', '>=', $this->start)
            ->whereDate('stocks.date', '<=', $this->end)
            ->orderBy('stocks.date')
            ->select([
                'stocks.date as tanggal',
                'stocks.invoice as invoice',
                'products.name as produk',
                'stock_items.qty as qty',
                'products.capital_price as modal_per_unit',
                DB::raw('(stock_items.qty * products.capital_price) as total_modal'),
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Invoice',
            'Produk',
            'Qty',
            'Modal / Unit',
            'Total Modal',
        ];
    }
}
