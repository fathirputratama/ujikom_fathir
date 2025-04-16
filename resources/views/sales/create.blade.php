<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Tambah Penjualan') }}
    </h2>
  </x-slot>

  <div class="container px-4 mx-auto">
    <!-- Search Bar -->
    <form method="GET" action="" class="m-6">
        <input
            type="text"
            name="search"
            value=""
            placeholder="Cari produk..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
        >
    </form>

    <!-- Daftar Produk -->
    <form action="" method="POST" class="max-w-2xl mx-auto">
        <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="flex items-center space-x-4">
                        <img src="" class="object-cover w-16 h-16 rounded-lg">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">makanan</h3>
                            <p class="text-gray-700 dark:text-gray-300">Rp 1000</p>
                            <p class="text-gray-700 dark:text-gray-300">Stok: 999</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input
                                type="number"
                                name="quantity"
                                min="0"
                                max=""
                                class="w-20 px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="Qty"
                            >
                        </div>
                    </div>
                </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-600">
                Selanjutnya
            </button>
        </div>
    </form>
</div>
  
</x-app-layout>