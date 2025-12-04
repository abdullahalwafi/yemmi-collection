<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin/laporan/produk', \App\Filament\Pages\ReportProducts::class)
    ->name('filament.admin.pages.report-products');

Route::get('/admin/laporan/stock-in', \App\Filament\Pages\ReportStockIn::class)
    ->name('filament.admin.pages.report-stock-in');

Route::get('/admin/laporan/stock-out', \App\Filament\Pages\ReportStockOut::class)
    ->name('filament.admin.pages.report-stock-out');
