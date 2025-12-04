<x-filament::page>

    <h2 class="text-xl font-bold mb-4">Pilih Jenis Laporan</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <a href="{{ route('filament.admin.pages.report-products') }}">
            <x-filament::card>
                <h3 class="font-semibold">Laporan Produk</h3>
                <p class="text-sm text-gray-500">Daftar produk lengkap beserta stok & modal.</p>
            </x-filament::card>
        </a>

        <a href="{{ route('filament.admin.pages.report-stock-in') }}">
            <x-filament::card>
                <h3 class="font-semibold">Laporan Stok Masuk</h3>
                <p class="text-sm text-gray-500">Transaksi penambahan stok.</p>
            </x-filament::card>
        </a>

        <a href="{{ route('filament.admin.pages.report-stock-out') }}">
            <x-filament::card>
                <h3 class="font-semibold">Laporan Stok Keluar</h3>
                <p class="text-sm text-gray-500">Transaksi penjualan stok.</p>
            </x-filament::card>
        </a>

    </div>

    </x-filament-panels::page>
