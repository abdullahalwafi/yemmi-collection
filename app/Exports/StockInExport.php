<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockInExport implements FromCollection
{
    public function __construct(public $start, public $end) {}

    public function collection()
    {
        return Stock::where('tipe', 'in')
            ->whereBetween('date', [$this->start, $this->end])
            ->with('product')
            ->get()
            ->map(function ($row) {
                return [
                    'Tanggal' => $row->date,
                    'Invoice' => $row->invoice,
                    'Produk'  => $row->product->name,
                    'Qty'     => $row->qty,
                    'Modal per Unit' => $row->product->capital_price,
                    'Total Modal'    => $row->qty * $row->product->capital_price,
                ];
            });
    }
}
