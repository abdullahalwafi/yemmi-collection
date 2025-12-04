<x-filament::page>

    <h2 class="text-xl font-bold mb-4">Laporan Produk</h2>

    <div class="flex gap-4 mb-4">
        <x-filament::button wire:click="downloadPdf">
            Download PDF
        </x-filament::button>

        <x-filament::button wire:click="downloadExcel">
            Download Excel
        </x-filament::button>
    </div>

    
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">#</th>
                <th class="p-2 border">Produk</th>
                <th class="p-2 border">Kategori</th>
                <th class="p-2 border">Stok</th>
                <th class="p-2 border">Harga Modal</th>
                <th class="p-2 border">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->getProducts() as $p)
                <tr>
                    <td class="p-2 border">{{ $loop->iteration }}</td>
                    <td class="p-2 border">{{ $p->name }}</td>
                    <td class="p-2 border">{{ $p->category->name }}</td>
                    <td class="p-2 border">{{ $p->qty }}</td>
                    <td class="p-2 border">Rp {{ number_format($p->capital_price) }}</td>
                    <td class="p-2 border">Rp {{ number_format($p->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    </x-filament-panels::page>
