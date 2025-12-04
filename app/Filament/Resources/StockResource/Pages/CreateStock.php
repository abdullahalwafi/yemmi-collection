<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Filament\Resources\StockResource;
use App\Models\Product;
use App\Models\Stock;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateStock extends CreateRecord
{
    protected static string $resource = StockResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $tipe  = $data['tipe'] ?? null;
        $date  = $data['date'] ?? null;
        $items = $data['items'] ?? [];
        $ket   = $data['ket'] ?? null;

        if (empty($items)) {
            Notification::make()
                ->title('Silakan tambahkan minimal 1 produk.')
                ->danger()
                ->send();

            return new Stock();
        }

        // Validasi stok untuk tipe 'out'
        if ($tipe === 'out') {
            foreach ($items as $item) {
                $product = Product::find($item['product_id'] ?? null);

                if (! $product) {
                    Notification::make()
                        ->title("Produk tidak ditemukan.")
                        ->danger()
                        ->send();

                    return new Stock();
                }

                $reqQty = (int) ($item['qty'] ?? 0);

                if ($product->qty < $reqQty) {
                    Notification::make()
                        ->title("Stok produk \"{$product->name}\" tidak cukup (tersisa: {$product->qty}).")
                        ->danger()
                        ->send();

                    return new Stock();
                }
            }
        }

        DB::beginTransaction();

        try {
            $invoice = 'INV-' . now()->format('Ymd') . '-' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $created = new Stock(); // fallback Model

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);

                if (! $product) {
                    DB::rollBack();
                    Notification::make()
                        ->title("Produk dengan ID {$item['product_id']} tidak ditemukan saat proses.")
                        ->danger()
                        ->send();

                    return new Stock();
                }

                $qty   = (int) ($item['qty'] ?? 0);
                $price = (float) ($item['price'] ?? 0);

                $stockData = [
                    'tipe'       => $tipe,
                    'invoice'    => $invoice,
                    'date'       => $date,
                    'product_id' => $product->id,
                    'qty'        => $qty,
                    'price'      => 0,
                    'ket'        => $ket,
                ];

                if ($tipe === 'in') {
                    // penambahan: update modal produk dan tambah qty
                    $product->increment('qty', $qty);
                    $stockData['price'] = $product->capital_price;
                    $product->save();
                } else {
                    // penjualan: pastikan stok cukup lalu kurangi
                    if ($product->qty < $qty) {
                        DB::rollBack();
                        Notification::make()
                            ->title("Stok produk \"{$product->name}\" tidak cukup saat proses. (tersisa: {$product->qty})")
                            ->danger()
                            ->send();

                        return new Stock();
                    }
                    $product->decrement('qty', $qty);
                    $stockData['price'] = $price;
                }

                $created = Stock::create($stockData);
            }

            DB::commit();

            Notification::make()
                ->title("Berhasil membuat stok (Invoice: {$invoice}).")
                ->success()
                ->send();

            return $created;
        } catch (\Throwable $e) {
            DB::rollBack();

            Notification::make()
                ->title('Terjadi kesalahan saat menyimpan stok.')
                ->body($e->getMessage())
                ->danger()
                ->send();

            return new Stock();
        }
    }
}
