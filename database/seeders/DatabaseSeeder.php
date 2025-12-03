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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Supplier::insert([
            [
                'name' => 'PT Sumber Makmur',
                'address' => 'Jl. Mawar No.12',
                'telepon' => '081234567890',
                'email' => 'supplier1@example.com',
                'created_at' => now(),
            ],
            [
                'name' => 'CV Berkah Jaya',
                'address' => 'Jl. Melati No.7',
                'telepon' => '081298765432',
                'email' => 'supplier2@example.com',
                'created_at' => now(),
            ],
        ]);

        Category::insert([
            ['name' => 'Kosmetik', 'created_at' => now()],
            ['name' => 'Pakaian', 'created_at' => now()],
            ['name' => 'Aksesoris', 'created_at' => now()],
        ]);

        Product::insert([
            [
                'name' => 'Lipstick Matte',
                'category_id' => 1,
                'deskripsi' => 'Lipstick warna merah matte.',
                'qty' => 50,
                'price' => 45000,
                'supplier_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Kemeja Casual',
                'category_id' => 2,
                'deskripsi' => 'Kemeja bahan katun premium.',
                'qty' => 30,
                'price' => 120000,
                'supplier_id' => 2,
                'created_at' => now(),
            ],
        ]);

        Stock::insert([
            [
                'tipe' => 'in',
                'date' => now()->subDays(2),
                'product_id' => 1,
                'qty' => 20,
                'price' => 45000,
                'ket' => 'Barang masuk awal bulan',
                'created_at' => now(),
            ],
            [
                'tipe' => 'out',
                'date' => now()->subDay(1),
                'product_id' => 1,
                'qty' => 5,
                'price' => 45000,
                'ket' => 'Penjualan toko',
                'created_at' => now(),
            ],
            [
                'tipe' => 'in',
                'date' => now()->subDays(3),
                'product_id' => 2,
                'qty' => 10,
                'price' => 120000,
                'ket' => 'Restock barang',
                'created_at' => now(),
            ],
        ]);
    }
}
