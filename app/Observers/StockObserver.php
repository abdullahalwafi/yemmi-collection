<?php

namespace App\Observers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class StockObserver
{
    protected function applyEffect(Product $product, string $type, int|float $qty): void
    {
        if ($type === 'in') {
            // tambah
            $product->increment('qty', $qty);
        } else {
            // keluar: kurangi, tapi pastikan tidak negatif
            if ($product->qty < $qty) { 
                throw new Exception("Stok produk [{$product->name}] tidak cukup. (tersisa: {$product->qty}, diminta keluar: {$qty})");
            }
            $product->decrement('qty', $qty);
        }
    }

    protected function rollbackEffect(Product $product, string $type, int|float $qty): void
    {
        // rollback kebalikan dari applyEffect
        if ($type === 'in') {
            // rollback masuk -> kurangi
            if ($product->qty < $qty) {
                throw new Exception("Rollback gagal: stok produk [{$product->name}] tidak cukup untuk dikurangi saat rollback (qty: {$product->qty}, rollback: {$qty})");
            }
            $product->decrement('qty', $qty);
        } else {
            // rollback keluar -> tambah kembali
            $product->increment('qty', $qty);
        }
    }

    public function created(Stock $stock): void
    {
        DB::transaction(function () use ($stock) {
            $product = Product::find($stock->product_id);
            if (! $product) {
                throw new Exception("Produk dengan ID {$stock->product_id} tidak ditemukan.");
            }
            $this->applyEffect($product, $stock->tipe, $stock->qty);
        });
    }

    public function updated(Stock $stock): void
    {
        DB::transaction(function () use ($stock) {
            $original = $stock->getOriginal();

            $oldType = $original['tipe'] ?? null;
            $oldQty  = isset($original['qty']) ? (int) $original['qty'] : 0;

            $product = Product::find($stock->product_id);
            if (! $product) {
                throw new Exception("Produk dengan ID {$stock->product_id} tidak ditemukan.");
            }

            // Jika product_id berubah (pindah ke produk lain), kita perlu rollback pada produk lama
            if (isset($original['product_id']) && $original['product_id'] != $stock->product_id) {
                $oldProduct = Product::find($original['product_id']);
                if (! $oldProduct) {
                    throw new Exception("Produk lama dengan ID {$original['product_id']} tidak ditemukan untuk rollback.");
                }
                // rollback effect dari record lama pada oldProduct
                $this->rollbackEffect($oldProduct, $oldType, $oldQty);
                // apply effect baru pada current product
                $this->applyEffect($product, $stock->tipe, $stock->qty);
                return;
            }

            // sama product_id — rollback dulu efek lama pada product sekarang
            if ($oldType !== null) {
                $this->rollbackEffect($product, $oldType, $oldQty);
            }

            // lalu apply efek baru
            $this->applyEffect($product, $stock->tipe, $stock->qty);
        });
    }

    public function deleted(Stock $stock): void
    {
        DB::transaction(function () use ($stock) {
            $product = Product::find($stock->product_id);
            if (! $product) {
                // produk sudah hilang — lewati atau beri notifikasi
                throw new Exception("Produk dengan ID {$stock->product_id} tidak ditemukan saat menghapus stock.");
            }
            // rollback efek sesuai tipe
            $this->rollbackEffect($product, $stock->tipe, $stock->qty);
        });
    }

    // jika kamu memakai soft deletes, tangani restoring juga
    public function restored(Stock $stock): void
    {
        // saat restore, apply lagi efek
        DB::transaction(function () use ($stock) {
            $product = Product::find($stock->product_id);
            if (! $product) {
                throw new Exception("Produk dengan ID {$stock->product_id} tidak ditemukan saat restore stock.");
            }
            $this->applyEffect($product, $stock->tipe, $stock->qty);
        });
    }
}
