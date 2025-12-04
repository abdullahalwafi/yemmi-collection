<?php

namespace App\Filament\Pages;

use App\Models\Stock;
use Filament\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StockOutExport;

class ReportStockOut extends Page
{
    protected static string $view = 'filament.pages.report-stock-out';
    protected static bool $shouldRegisterNavigation = false;

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = now()->subMonth()->format('Y-m-d');
        $this->end_date   = now()->format('Y-m-d');
    }

    public function getData()
    {
        return Stock::with('product')
            ->where('tipe', 'out')
            ->whereBetween('date', [$this->start_date, $this->end_date])
            ->orderBy('date')
            ->get();
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('exports.stock-out', [
            'data' => $this->getData(),
            'start' => $this->start_date,
            'end' => $this->end_date,
        ]);

        return response()->streamDownload(fn() => print($pdf->output()), 'laporan-stock-keluar.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new StockOutExport($this->start_date, $this->end_date), 'laporan-stock-keluar.xlsx');
    }
}
