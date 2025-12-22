<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Laporan Stok Masuk</h2>

    <div class="flex gap-4 mb-4">
        <x-filament::button wire:click="downloadPdf">Download PDF</x-filament::button>
        <x-filament::button wire:click="downloadExcel" color="success">Download Excel</x-filament::button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Dari Tanggal
            </label>
            <input
                type="date"
                wire:model="start_date"
                class="mt-1 block w-full rounded-md border bg-white dark:bg-gray-900
                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-100
                       shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500
                       dark:focus:ring-primary-400 transition"
            />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Sampai Tanggal
            </label>
            <div class="flex items-center gap-2">
                <input
                    type="date"
                    wire:model="end_date"
                    class="mt-1 block w-full rounded-md border bg-white dark:bg-gray-900
                           border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-100
                           shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500
                           dark:focus:ring-primary-400 transition"
                />
                <button
                    type="button"
                    wire:click="$refresh"
                    class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium
                           bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700
                           text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700"
                >
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-auto">
        <table class="w-full border border-gray-300 dark:border-gray-700 rounded-lg">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Invoice</th>
                    <th class="p-2 border">Produk</th>
                    <th class="p-2 border text-right">Qty</th>
                    <th class="p-2 border text-right">Modal / Unit</th>
                    <th class="p-2 border text-right">Total Modal</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                @php
                    $totalQty = 0;
                    $totalModal = 0;
                @endphp

                @forelse ($this->getData() as $row)
                    @php
                        $totalQty += $row->qty;
                        $totalModal += $row->total_modal;
                    @endphp

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                        <td class="p-2 border">{{ $row->invoice }}</td>
                        <td class="p-2 border">{{ $row->product_name }}</td>
                        <td class="p-2 border text-right">{{ $row->qty }}</td>
                        <td class="p-2 border text-right">
                            Rp {{ number_format($row->capital_price, 0, ',', '.') }}
                        </td>
                        <td class="p-2 border text-right">
                            Rp {{ number_format($row->total_modal, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            Tidak ada data pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot class="bg-gray-200 dark:bg-gray-800 font-bold text-gray-800 dark:text-gray-100">
                <tr>
                    <td colspan="3" class="p-2 border text-center">TOTAL</td>
                    <td class="p-2 border text-right">{{ $totalQty }}</td>
                    <td class="p-2 border"></td>
                    <td class="p-2 border text-right">
                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-filament::page>
