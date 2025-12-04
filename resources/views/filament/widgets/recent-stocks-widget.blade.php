<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-100 dark:border-gray-700">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Transaksi Terbaru</h3>
        <a href="{{ url('/admin/stocks') }}" class="text-xs text-primary-600 dark:text-primary-400">Lihat semua</a>
    </div>

    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
        @foreach ($items as $it)
            <li class="py-2 flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-800 dark:text-gray-100">
                        {{ $it->product?->name ?? '-' }}
                        <span class="ml-2 px-2 py-0.5 text-xs rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            {{ $it->tipe === 'in' ? 'Masuk' : 'Keluar' }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $it->invoice }} — {{ $it->date }}
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $it->qty }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Rp {{ number_format($it->price) }}</div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
