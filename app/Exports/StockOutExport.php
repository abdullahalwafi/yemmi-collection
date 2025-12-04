<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockOutExport implements FromCollection
{
    public function __construct(public $start, public $end) {}

    public function collection()
    {
        return Stock::where('tipe', 'out')
            ->whereBetween('date', [$this->start, $this->end])
            ->with('product')
            ->get()
            ->map(function ($row) {
                return [
                    'Tanggal' => $row->date,
                    'Invoice' => $row->invoice,
                    'Produk'  => $row->product->name,
                    'Qty'     => $row->qty,
                    'Harga Jual' => $row->price,
                    'Total'      => $row->qty * $row->price,
                ];
            });
    }
}
