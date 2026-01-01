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
        return DB::transaction(function () use ($data) {

            // 1️⃣ SIMPAN HEADER STOCK
            $stock = Stock::create([
                'tipe'    => $data['tipe'],
                'invoice' => 'INV-' . now()->format('YmdHis'),
                'date'    => $data['date'],
                'ket'     => $data['ket'] ?? null,
            ]);

            // 2️⃣ SIMPAN DETAIL (STOCK_ITEMS)
            foreach ($data['items'] as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                // harga otomatis
                $price = $stock->tipe === 'in'
                    ? $product->capital_price   // modal
                    : $product->price;          // jual

                $stock->items()->create([
                    'product_id' => $product->id,
                    'qty'        => (int) $item['qty'],
                    'price'      => $price,
                ]);
            }

            return $stock;
        });
    }
}
