<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /* =====================
             * USERS
             * ===================== */
            User::insert([
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => Hash::make('admin@admin.com'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Owner',
                    'email' => 'owner@owner.com',
                    'password' => Hash::make('owner@owner.com'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);

            /* =====================
             * SUPPLIERS (10)
             * ===================== */
            Supplier::insert(array_map(function ($supplier) {
                return array_merge($supplier, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }, [
                ['name' => 'PT Mothercare Indonesia', 'address' => 'Jakarta Selatan', 'telepon' => '02178889900', 'email' => 'info@mothercare.co.id'],
                ['name' => 'PT Kiko Kids Indonesia', 'address' => 'Jakarta Barat', 'telepon' => '0215552233', 'email' => 'sales@kikokids.id'],
                ['name' => 'CV Velvet Junior', 'address' => 'Bandung', 'telepon' => '0227334455', 'email' => 'velvetjunior@gmail.com'],
                ['name' => 'PT Libby Baby Wear', 'address' => 'Tangerang', 'telepon' => '0215901122', 'email' => 'cs@libby.co.id'],
                ['name' => 'PT Poney Indonesia', 'address' => 'Jakarta Pusat', 'telepon' => '0213928822', 'email' => 'info@poney.com'],
                ['name' => 'CV Little Palmerhaus', 'address' => 'Surabaya', 'telepon' => '0315678899', 'email' => 'palmerhaus@gmail.com'],
                ['name' => 'PT OshKosh Indonesia', 'address' => 'Jakarta Selatan', 'telepon' => '0217223344', 'email' => 'info@oshkosh.co.id'],
                ['name' => 'CV Hey Baby Wear', 'address' => 'Bandung', 'telepon' => '0227001122', 'email' => 'heybaby@gmail.com'],
                ['name' => 'PT Cotton On Kids Indonesia', 'address' => 'Jakarta Selatan', 'telepon' => '02129033000', 'email' => 'kids@cottonon.com'],
                ['name' => 'UD Grosir Tanah Abang Kids', 'address' => 'Jakarta Pusat', 'telepon' => '081234556677', 'email' => 'tanahabangkids@gmail.com'],
            ]));

            /* =====================
             * CATEGORIES (10)
             * ===================== */
            Category::insert(array_map(function ($category) {
                return array_merge($category, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }, [
                ['name' => 'Baju Bayi'],
                ['name' => 'Baju Anak Laki-laki'],
                ['name' => 'Baju Anak Perempuan'],
                ['name' => 'Celana Anak'],
                ['name' => 'Jaket Anak'],
                ['name' => 'Dress Anak'],
                ['name' => 'Setelan Anak'],
                ['name' => 'Piyama Anak'],
                ['name' => 'Aksesoris Anak'],
                ['name' => 'Sepatu Anak'],
            ]));

            /* =====================
             * PRODUCTS (10)
             * ===================== */
            Product::insert(array_map(function ($product) {
                return array_merge($product, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }, [
                ['name' => 'Libby Bodysuit Bayi', 'category_id' => 1, 'deskripsi' => 'Bodysuit bayi', 'qty' => rand(0, 100), 'price' => 49000, 'capital_price' => 35000, 'supplier_id' => 4],
                ['name' => 'Kiko Kids Kaos Anak', 'category_id' => 2, 'deskripsi' => 'Kaos anak', 'qty' => rand(0, 100), 'price' => 69000, 'capital_price' => 45000, 'supplier_id' => 2],
                ['name' => 'Velvet Dress Anak', 'category_id' => 6, 'deskripsi' => 'Dress anak', 'qty' => rand(0, 100), 'price' => 129000, 'capital_price' => 90000, 'supplier_id' => 3],
                ['name' => 'Mothercare Jaket Anak', 'category_id' => 5, 'deskripsi' => 'Jaket anak', 'qty' => rand(0, 100), 'price' => 199000, 'capital_price' => 150000, 'supplier_id' => 1],
                ['name' => 'Poney Setelan Anak', 'category_id' => 7, 'deskripsi' => 'Setelan anak', 'qty' => rand(0, 100), 'price' => 179000, 'capital_price' => 130000, 'supplier_id' => 5],
                ['name' => 'OshKosh Celana Anak', 'category_id' => 4, 'deskripsi' => 'Celana anak', 'qty' => rand(0, 100), 'price' => 159000, 'capital_price' => 120000, 'supplier_id' => 7],
                ['name' => 'Hey Baby Piyama', 'category_id' => 8, 'deskripsi' => 'Piyama anak', 'qty' => rand(0, 100), 'price' => 89000, 'capital_price' => 60000, 'supplier_id' => 8],
                ['name' => 'Palmerhaus Dress', 'category_id' => 6, 'deskripsi' => 'Dress handmade', 'qty' => rand(0, 100), 'price' => 219000, 'capital_price' => 160000, 'supplier_id' => 6],
            ]));

            /* =====================
             * STOCKS + STOCK_ITEMS
             * ===================== */

            // ===== INVOICE 1 (STOK MASUK) =====
            $stock1 = Stock::create([
                'tipe' => 'in',
                'invoice' => 'INV-202501-001',
                'date' => now()->subDays(10),
                'ket' => 'Stok awal',
            ]);

            StockItem::insert([
                ['stock_id' => $stock1->id, 'product_id' => 1, 'qty' => 20, 'price' => 35000],
                ['stock_id' => $stock1->id, 'product_id' => 2, 'qty' => 15, 'price' => 45000],
            ]);

            // ===== INVOICE 2 (STOK MASUK) =====
            $stock2 = Stock::create([
                'tipe' => 'in',
                'invoice' => 'INV-202501-002',
                'date' => now()->subDays(8),
                'ket' => 'Restock',
            ]);

            StockItem::insert([
                ['stock_id' => $stock2->id, 'product_id' => 3, 'qty' => 10, 'price' => 90000],
                ['stock_id' => $stock2->id, 'product_id' => 4, 'qty' => 8,  'price' => 150000],
            ]);

            // ===== INVOICE 3 (PENJUALAN) =====
            $stock3 = Stock::create([
                'tipe' => 'out',
                'invoice' => 'INV-202501-003',
                'date' => now()->subDays(5),
                'ket' => 'Penjualan',
            ]);

            StockItem::insert([
                ['stock_id' => $stock3->id, 'product_id' => 1, 'qty' => 5, 'price' => 49000],
                ['stock_id' => $stock3->id, 'product_id' => 2, 'qty' => 4, 'price' => 69000],
            ]);
        });
    }
}
