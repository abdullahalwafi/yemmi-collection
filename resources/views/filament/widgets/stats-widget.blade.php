<div class="space-y-6">
    {{-- BARIS 1 : STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-100 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Produk</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalProducts }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-100 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Stock Masuk</div>
            <div class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($totalStockIn) }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-100 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Stock Keluar</div>
            <div class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($totalStockOut) }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-100 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Modal Bulan ini</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalModalThisMonth) }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-100 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Pendapatan Bulan ini</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalRevenueThisMonth) }}</div>
        </div>
    </div>
</div>
