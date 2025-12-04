<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Laporan Stok Keluar</h2>

    <div class="flex gap-4 mb-4">
        <x-filament::button wire:click="downloadPdf">Download PDF</x-filament::button>
        <x-filament::button wire:click="downloadExcel">Download Excel</x-filament::button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Dari Tanggal
            </label>
            <input type="date" wire:model="start_date"
                class="mt-1 block w-full rounded-md border bg-white dark:bg-gray-900
                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-100
                       shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-0
                       focus:ring-primary-500 dark:focus:ring-primary-400
                       transition" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Sampai Tanggal
            </label>
            <div class="flex items-center gap-2">
                <input type="date" wire:model="end_date"
                    class="mt-1 block w-full rounded-md border bg-white dark:bg-gray-900
                           border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-100
                           shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-0
                           focus:ring-primary-500 dark:focus:ring-primary-400
                           transition" />
                <button type="button" wire:click="$refresh"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium
                           bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700
                           text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700
                           transition"
                    title="Refresh data">
                    Refresh
                </button>
            </div>
        </div>
    </div>


    <div class="overflow-auto">
        <table class="w-full border border-gray-300 dark:border-gray-700 rounded-lg">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="p-2 border border-gray-300 dark:border-gray-700">Tanggal</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-700">Invoice</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-700">Produk</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-700">Qty</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-700">Harga Jual</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-700">Total</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                @php
                    $totalQty = 0;
                    $totalJual = 0;
                @endphp

                @foreach ($this->getData() as $row)
                    @php
                        $rowTotal = $row->qty * $row->price;

                        $totalQty += $row->qty;
                        $totalJual += $rowTotal;
                    @endphp

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="p-2 border border-gray-300 dark:border-gray-700">{{ $row->date }}</td>
                        <td class="p-2 border border-gray-300 dark:border-gray-700">{{ $row->invoice }}</td>
                        <td class="p-2 border border-gray-300 dark:border-gray-700">{{ $row->product?->name }}</td>
                        <td class="p-2 border border-gray-300 dark:border-gray-700">{{ $row->qty }}</td>
                        <td class="p-2 border border-gray-300 dark:border-gray-700">
                            Rp {{ number_format($row->price) }}
                        </td>
                        <td class="p-2 border border-gray-300 dark:border-gray-700">
                            Rp {{ number_format($rowTotal) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot class="bg-gray-200 dark:bg-gray-800 font-bold text-gray-800 dark:text-gray-100">
                <tr>
                    <td class="p-2 border border-gray-300 dark:border-gray-700 text-center" colspan="3">TOTAL</td>
                    <td class="p-2 border border-gray-300 dark:border-gray-700">{{ $totalQty }}</td>
                    <td class="p-2 border border-gray-300 dark:border-gray-700"></td>
                    <td class="p-2 border border-gray-300 dark:border-gray-700">Rp {{ number_format($totalJual) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</x-filament::page>
