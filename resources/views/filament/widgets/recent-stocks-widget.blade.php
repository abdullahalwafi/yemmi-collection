<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Transaksi Terbaru</h2>
        </div>

        <div class="space-y-3">
            @forelse ($items as $stock)
                <div
                    class="p-3 rounded-lg border
                    bg-white dark:bg-gray-900
                    border-gray-200 dark:border-gray-700">

                    <div class="flex justify-between items-center mb-1">
                        <div class="font-semibold">
                            {{ $stock['invoice'] }}
                        </div>

                        <span
                            class="text-xs px-2 py-1 rounded
                            {{ $stock['tipe'] === 'in'
                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300'
                                : 'bg-rose-100 text-rose-700 dark:bg-rose-900 dark:text-rose-300' }}">
                            {{ $stock['tipe'] === 'in' ? 'Penambahan' : 'Penjualan' }}
                        </span>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                        {{ \Carbon\Carbon::parse($stock['date'])->format('d M Y') }}
                    </div>

                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        {{ collect($stock['items'])->map(fn($i) => $i['product'] . ' (' . $i['qty'] . ')')->implode(', ') }}
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500">
                    Belum ada transaksi.
                </div>
            @endforelse
        </div>
    </x-filament::card>
</x-filament::widget>
