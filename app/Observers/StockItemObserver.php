<?php

namespace App\Observers;

use App\Models\StockItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class StockItemObserver
{
    protected function apply(Product $product, string $tipe, int $qty): void
    {
        if ($tipe === 'in') {
            $product->increment('qty', $qty);
        } else {
            if ($product->qty < $qty) {
                throw new Exception(
                    "Stok produk [{$product->name}] tidak cukup " .
                        "(tersisa: {$product->qty}, diminta: {$qty})"
                );
            }
            $product->decrement('qty', $qty);
        }
    }

    protected function rollback(Product $product, string $tipe, int $qty): void
    {
        if ($tipe === 'in') {
            if ($product->qty < $qty) {
                throw new Exception("Rollback gagal untuk {$product->name}");
            }
            $product->decrement('qty', $qty);
        } else {
            $product->increment('qty', $qty);
        }
    }

    public function created(StockItem $item): void
    {
        DB::transaction(function () use ($item) {
            $product = Product::lockForUpdate()->find($item->product_id);
            $tipe    = $item->stock->tipe;

            if (! $product) {
                throw new Exception("Produk tidak ditemukan.");
            }

            $this->apply($product, $tipe, (int) $item->qty);
        });
    }

    public function updated(StockItem $item): void
    {
        DB::transaction(function () use ($item) {
            $original = $item->getOriginal();

            $oldQty     = (int) ($original['qty'] ?? 0);
            $oldProduct = Product::lockForUpdate()->find($original['product_id']);
            $newProduct = Product::lockForUpdate()->find($item->product_id);

            $tipe = $item->stock->tipe;

            if (! $oldProduct || ! $newProduct) {
                throw new Exception("Produk tidak ditemukan saat update.");
            }

            // rollback lama
            $this->rollback($oldProduct, $tipe, $oldQty);

            // apply baru
            $this->apply($newProduct, $tipe, (int) $item->qty);
        });
    }

    public function deleted(StockItem $item): void
    {
        DB::transaction(function () use ($item) {
            $product = Product::lockForUpdate()->find($item->product_id);
            $tipe    = $item->stock->tipe;

            if (! $product) {
                throw new Exception("Produk tidak ditemukan saat delete.");
            }

            $this->rollback($product, $tipe, (int) $item->qty);
        });
    }
}
