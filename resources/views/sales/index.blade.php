<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Penjualan') }}
      </h2>
  </x-slot>

  <div class="container p-4 mx-auto">
      <!-- Action Bar -->
      <div class="flex items-center justify-between mb-6">

          <!-- Tambah Penjualan -->
          @if (Auth::user()->role === 'kasir')
          <a href="{{ route('sales.create') }}"
              class="px-4 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-600">
              Tambah Penjualan
          </a>
          @endif

                  <!-- Export Excel -->
                  <a href="{{ route('sales.export') }}" class="px-4 py-2 text-white transition duration-200 bg-green-500 rounded-lg hover:bg-green-600">
                    Export Excel
                </a>
      </div>

      <!-- Search Bar -->
      <div class="mb-6">
          <form action="" method="GET" class="flex items-center">
              <input type="text" name="search" placeholder="Cari penjualan..." value=""
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
              <button type="submit"
                  class="px-4 py-2 ml-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-600">
                  Cari
              </button>
          </form>
      </div>

      <!-- Table -->
      <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
          <table class="min-w-full">
              <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                      <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">ID</th>
                      <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Nama Pelanggan</th>
                      <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Tanggal Penjualan</th>
                      <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Total Harga</th>
                      <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Dibuat Oleh</th>
                      <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($sales as $sale)
                      <tr class="transition duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                          <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $sale->id }}</td>
                          <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                              {{ $sale->member ? $sale->member->name : ($sale->customer_name ?? 'Non-Member') }}
                          </td>
                          <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{$sale->created_at->format('Y-m-d')}}</td>
                          <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                          <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{  $sale->user->name }}</td>
                          <td class="px-6 py-4">
                              <div class="flex items-center space-x-2">
                                  <a href="{{ route('sales.result', $sale->id) }}') }}"
                                     class="text-blue-500 transition duration-200 hover:text-blue-700 dark:hover:text-blue-400">
                                      Lihat
                                  </a>
                                  <span class="text-gray-400">|</span>
                                  <a href=""
                                     class="text-red-500 transition duration-200 hover:text-red-700 dark:hover:text-red-400"
                                     title="Cetak PDF">
                                      <svg class="inline w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                      </svg>
                                  </a>
                              </div>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>

      <!-- Pagination -->
      <div class="pt-6">
        {{ $sales->links() }}
      </div>
  </div>
</x-app-layout>
