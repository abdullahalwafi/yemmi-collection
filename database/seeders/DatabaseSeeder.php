<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        /* =====================
         * USERS (10)
         * ===================== */
        User::insert([
            ['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => Hash::make('admin@admin.com')],
            ['name' => 'Owner', 'email' => 'owner@owner.com', 'password' => Hash::make('owner@owner.com')],
        ]);

        /* =====================
         * SUPPLIERS (10)
         * ===================== */
        Supplier::insert([
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
        ]);

        /* =====================
         * CATEGORIES (10)
         * ===================== */
        Category::insert([
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
        ]);

        /* =====================
         * PRODUCTS (10)
         * ===================== */
        Product::insert([
            ['name' => 'Libby Bodysuit Bayi Lengan Pendek', 'category_id' => 1, 'deskripsi' => 'Bodysuit bayi katun lembut', 'qty' => 50, 'price' => 49000, 'capital_price' => 35000, 'supplier_id' => 4],
            ['name' => 'Kiko Kids Kaos Anak Laki-laki', 'category_id' => 2, 'deskripsi' => 'Kaos anak motif dinosaurus', 'qty' => 40, 'price' => 69000, 'capital_price' => 45000, 'supplier_id' => 2],
            ['name' => 'Velvet Junior Dress Anak', 'category_id' => 6, 'deskripsi' => 'Dress anak perempuan casual', 'qty' => 30, 'price' => 129000, 'capital_price' => 90000, 'supplier_id' => 3],
            ['name' => 'Mothercare Jaket Anak', 'category_id' => 5, 'deskripsi' => 'Jaket anak hangat dan ringan', 'qty' => 25, 'price' => 199000, 'capital_price' => 150000, 'supplier_id' => 1],
            ['name' => 'Poney Setelan Anak', 'category_id' => 7, 'deskripsi' => 'Setelan anak premium', 'qty' => 20, 'price' => 179000, 'capital_price' => 130000, 'supplier_id' => 5],
            ['name' => 'OshKosh Celana Jeans Anak', 'category_id' => 4, 'deskripsi' => 'Celana jeans anak kuat', 'qty' => 35, 'price' => 159000, 'capital_price' => 120000, 'supplier_id' => 7],
            ['name' => 'Hey Baby Piyama Anak', 'category_id' => 8, 'deskripsi' => 'Piyama anak motif lucu', 'qty' => 45, 'price' => 89000, 'capital_price' => 60000, 'supplier_id' => 8],
            ['name' => 'Little Palmerhaus Dress Anak', 'category_id' => 6, 'deskripsi' => 'Dress anak handmade', 'qty' => 15, 'price' => 219000, 'capital_price' => 160000, 'supplier_id' => 6],
            ['name' => 'Cotton On Kids Topi Anak', 'category_id' => 9, 'deskripsi' => 'Topi anak katun', 'qty' => 60, 'price' => 59000, 'capital_price' => 40000, 'supplier_id' => 9],
            ['name' => 'Sepatu Anak Sekolah Hitam', 'category_id' => 10, 'deskripsi' => 'Sepatu sekolah anak', 'qty' => 50, 'price' => 149000, 'capital_price' => 110000, 'supplier_id' => 10],
        ]);

        /* =====================
         * STOCKS (10)
         * ===================== */
        Stock::insert([
            ['tipe' => 'in', 'invoice' => 'INV-202501-001', 'date' => now()->subDays(14), 'product_id' => 1, 'qty' => 20, 'price' => 35000, 'ket' => 'Stok awal'],
            ['tipe' => 'in', 'invoice' => 'INV-202501-002', 'date' => now()->subDays(13), 'product_id' => 2, 'qty' => 15, 'price' => 45000, 'ket' => 'Stok awal'],
            ['tipe' => 'out', 'invoice' => 'INV-202501-003', 'date' => now()->subDays(10), 'product_id' => 1, 'qty' => 5,  'price' => 49000, 'ket' => 'Penjualan'],
            ['tipe' => 'out', 'invoice' => 'INV-202501-004', 'date' => now()->subDays(9),  'product_id' => 3, 'qty' => 3,  'price' => 129000, 'ket' => 'Penjualan'],
            ['tipe' => 'in', 'invoice' => 'INV-202501-005', 'date' => now()->subDays(7),  'product_id' => 4, 'qty' => 10, 'price' => 150000, 'ket' => 'Restock'],
            ['tipe' => 'out', 'invoice' => 'INV-202501-006', 'date' => now()->subDays(6),  'product_id' => 2, 'qty' => 4,  'price' => 69000, 'ket' => 'Penjualan'],
            ['tipe' => 'in', 'invoice' => 'INV-202501-007', 'date' => now()->subDays(4),  'product_id' => 5, 'qty' => 8,  'price' => 130000, 'ket' => 'Restock'],
            ['tipe' => 'out', 'invoice' => 'INV-202501-008', 'date' => now()->subDays(3),  'product_id' => 6, 'qty' => 6,  'price' => 159000, 'ket' => 'Penjualan'],
            ['tipe' => 'in', 'invoice' => 'INV-202501-009', 'date' => now()->subDays(2),  'product_id' => 7, 'qty' => 12, 'price' => 60000, 'ket' => 'Restock'],
            ['tipe' => 'out', 'invoice' => 'INV-202501-010', 'date' => now()->subDay(),    'product_id' => 10, 'qty' => 5,  'price' => 149000, 'ket' => 'Penjualan'],
        ]);
    }
}
