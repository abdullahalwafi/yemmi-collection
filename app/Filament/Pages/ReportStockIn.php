<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StockInExport;

class ReportStockIn extends Page
{
    protected static string $view = 'filament.pages.report-stock-in';
    protected static bool $shouldRegisterNavigation = false;

    public string $start_date;
    public string $end_date;

    public function mount(): void
    {
        $this->start_date = now()->subMonth()->format('Y-m-d');
        $this->end_date   = now()->format('Y-m-d');
    }

    /**
     * Data laporan (flatten per item)
     */
    public function getData()
    {
        return DB::table('stocks')
            ->join('stock_items', 'stocks.id', '=', 'stock_items.stock_id')
            ->join('products', 'products.id', '=', 'stock_items.product_id')
            ->where('stocks.tipe', 'in')
            ->whereDate('stocks.date', '>=', $this->start_date)
            ->whereDate('stocks.date', '<=', $this->end_date)
            ->select([
                'stocks.invoice',
                'stocks.date',
                'products.name as product_name',
                'stock_items.qty',
                'products.capital_price',
                DB::raw('(stock_items.qty * products.capital_price) as total_modal'),
            ])
            ->orderBy('stocks.date')
            ->get();
    }


    public function downloadPdf()
    {
        $pdf = Pdf::loadView('exports.stock-in', [
            'data'  => $this->getData(),
            'start' => $this->start_date,
            'end'   => $this->end_date,
        ])->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'laporan-stock-masuk.pdf'
        );
    }

    public function downloadExcel()
    {
        return Excel::download(
            new StockInExport($this->start_date, $this->end_date),
            'laporan-stock-masuk.xlsx'
        );
    }
}
