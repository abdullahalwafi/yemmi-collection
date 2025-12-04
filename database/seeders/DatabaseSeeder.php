<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@admin.com'),
        ]);
        $now = now();

        Supplier::insert([
            ['name' => 'PT Sumber Makmur', 'address' => 'Jl. Mawar No.12', 'telepon' => '081234567890', 'email' => 'supplier1@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'CV Berkah Jaya', 'address' => 'Jl. Melati No.7', 'telepon' => '081298765432', 'email' => 'supplier2@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'UD Sentosa', 'address' => 'Jl. Kamboja No.5', 'telepon' => '081377712233', 'email' => 'supplier3@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'PT Maju Jaya', 'address' => 'Jl. Kenanga No.3', 'telepon' => '081244455666', 'email' => 'supplier4@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'CV Prima', 'address' => 'Jl. Dahlia No.8', 'telepon' => '081299988877', 'email' => 'supplier5@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'PT Anugerah', 'address' => 'Jl. Flamboyan No.2', 'telepon' => '081233344455', 'email' => 'supplier6@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Toko Makmur', 'address' => 'Jl. Anggrek No.10', 'telepon' => '081255577799', 'email' => 'supplier7@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'CV Nusantara', 'address' => 'Jl. Teratai No.4', 'telepon' => '081266688899', 'email' => 'supplier8@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'PT Gemilang', 'address' => 'Jl. Bougainvillea No.6', 'telepon' => '081277700011', 'email' => 'supplier9@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'UD Sejahtera', 'address' => 'Jl. Cemara No.1', 'telepon' => '081288899900', 'email' => 'supplier10@example.com', 'created_at' => $now, 'updated_at' => $now],
        ]);

        Category::insert([
            ['name' => 'Kosmetik', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pakaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aksesoris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Elektronik', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Makanan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Minuman', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Perawatan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kecantikan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pelengkap', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Peralatan Rumah', 'created_at' => $now, 'updated_at' => $now],
        ]);

        Product::insert([
            ['name' => 'Lipstick Matte', 'category_id' => 1, 'deskripsi' => 'Lipstick warna merah matte.', 'qty' => 100, 'price' => 45000, 'capital_price' => 42000, 'supplier_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kemeja Casual', 'category_id' => 2, 'deskripsi' => 'Kemeja bahan katun premium.', 'qty' => 80, 'price' => 120000, 'capital_price' => 80000, 'supplier_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kalung Silver', 'category_id' => 3, 'deskripsi' => 'Kalung perak bergaya minimalis.', 'qty' => 60, 'price' => 75000, 'capital_price' => 70000, 'supplier_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Headphone Wireless', 'category_id' => 4, 'deskripsi' => 'Headphone bluetooth, noise cancelling.', 'qty' => 40, 'price' => 350000, 'capital_price' => 300000, 'supplier_id' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kopi Robusta 500g', 'category_id' => 5, 'deskripsi' => 'Biji kopi robusta lokal.', 'qty' => 200, 'price' => 60000, 'capital_price' => 55000, 'supplier_id' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Teh Melati 200g', 'category_id' => 6, 'deskripsi' => 'Teh melati berkualitas.', 'qty' => 150, 'price' => 25000, 'capital_price' => 23000, 'supplier_id' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sabun Mandi', 'category_id' => 7, 'deskripsi' => 'Sabun cair wangi segar.', 'qty' => 300, 'price' => 15000, 'capital_price' => 12000, 'supplier_id' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pelembap Wajah', 'category_id' => 8, 'deskripsi' => 'Cream pelembap untuk kulit normal.', 'qty' => 120, 'price' => 90000, 'capital_price' => 70000, 'supplier_id' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gantungan Kunci', 'category_id' => 9, 'deskripsi' => 'Gantungan kunci lucu dan awet.', 'qty' => 500, 'price' => 5000, 'capital_price' => 3000, 'supplier_id' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sapu Lantai', 'category_id' => 10, 'deskripsi' => 'Sapu berkualitas untuk rumah tangga.', 'qty' => 75, 'price' => 30000, 'capital_price' => 22000, 'supplier_id' => 10, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $date = now();

        Stock::insert([
            // 1-5: IN (price = 0)
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0001', 'date' => $date->copy()->subDays(10), 'product_id' => 1, 'qty' => 20,  'price' => 42000,     'ket' => 'Pembelian awal', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0002', 'date' => $date->copy()->subDays(9),  'product_id' => 2, 'qty' => 30,  'price' => 42000,     'ket' => 'Pembelian awal', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0003', 'date' => $date->copy()->subDays(8),  'product_id' => 3, 'qty' => 10,  'price' => 42000,     'ket' => 'Pembelian awal', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0004', 'date' => $date->copy()->subDays(7),  'product_id' => 4, 'qty' => 15,  'price' => 42000,     'ket' => 'Pembelian awal', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0005', 'date' => $date->copy()->subDays(6),  'product_id' => 5, 'qty' => 50,  'price' => 42000,     'ket' => 'Pembelian awal', 'created_at' => $now, 'updated_at' => $now],

            // 6-8: OUT (price diisi)
            ['tipe' => 'out', 'invoice' => 'INV-' . now()->format('Ymd') . '-0006', 'date' => $date->copy()->subDays(5),  'product_id' => 1, 'qty' => 10,  'price' => 52000, 'ket' => 'Penjualan', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'out', 'invoice' => 'INV-' . now()->format('Ymd') . '-0007', 'date' => $date->copy()->subDays(4),  'product_id' => 2, 'qty' => 5,   'price' => 130000, 'ket' => 'Penjualan', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'out', 'invoice' => 'INV-' . now()->format('Ymd') . '-0008', 'date' => $date->copy()->subDays(3),  'product_id' => 5, 'qty' => 20,  'price' => 70000, 'ket' => 'Penjualan', 'created_at' => $now, 'updated_at' => $now],

            // 9-10: IN (restock)
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0009', 'date' => $date->copy()->subDays(2),  'product_id' => 6, 'qty' => 40,  'price' => 42000,     'ket' => 'Restock', 'created_at' => $now, 'updated_at' => $now],
            ['tipe' => 'in',  'invoice' => 'INV-' . now()->format('Ymd') . '-0010', 'date' => $date->copy()->subDay(),      'product_id' => 7, 'qty' => 100, 'price' => 42000,     'ket' => 'Restock', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
