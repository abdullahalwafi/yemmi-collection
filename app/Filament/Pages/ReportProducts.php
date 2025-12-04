<?php

namespace App\Filament\Pages;

use App\Models\Product;
use Filament\Pages\Page;
use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductsExport;

class ReportProducts extends Page
{
    protected static ?string $navigationLabel = null;
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.report-products';

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = now()->subMonth()->format('Y-m-d');
        $this->end_date = now()->format('Y-m-d');
    }

    public function getProducts()
    {
        return Product::orderBy('name')->get();
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('exports.products', [
            'data' => $this->getProducts(),
        ]);

        return response()->streamDownload(fn() => print($pdf->output()), 'laporan-produk.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new ProductsExport, 'laporan-produk.xlsx');
    }
}
