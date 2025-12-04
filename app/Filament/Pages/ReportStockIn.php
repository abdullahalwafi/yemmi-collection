<?php

namespace App\Filament\Pages;

use App\Models\Stock;
use Filament\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StockInExport;

class ReportStockIn extends Page
{
    protected static string $view = 'filament.pages.report-stock-in';
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
            ->where('tipe', 'in')
            ->whereBetween('date', [$this->start_date, $this->end_date])
            ->orderBy('date')
            ->get();
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('exports.stock-in', [
            'data' => $this->getData(),
            'start' => $this->start_date,
            'end' => $this->end_date,
        ]);

        return response()->streamDownload(fn() => print($pdf->output()), 'laporan-stock-masuk.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new StockInExport($this->start_date, $this->end_date), 'laporan-stock-masuk.xlsx');
    }
}
