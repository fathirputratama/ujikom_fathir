<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Detail Transaksi') }}
      </h2>
  </x-slot>

  <div class="container p-4 mx-auto">
      <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <!-- Tombol Kembali dan Unduh PDF -->
          <div class="flex items-center justify-between mb-6">
              <a href="{{ route('sales.index') }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                  Kembali
              </a>
              <a href="{{ route('sales.pdf', $sale->id) }}" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                  Unduh PDF
              </a>
          </div>

                    <!-- Daftar Produk -->
                    <div class="mb-8">
                        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Produk yang Dibeli</h2>
                        @if ($sale->products->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-600">
                                        <tr>
                                            <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Nama Produk</th>
                                            <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Harga</th>
                                            <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Qty</th>
                                            <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach ($sale->products as $product)
                                            <tr class="transition duration-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $product->pivot->quantity }}</td>
                                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">Rp {{ number_format($product->pivot->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-700 dark:text-gray-300">Tidak ada produk yang dibeli.</p>
                        @endif
                    </div>

          <!-- Detail Transaksi -->
          <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
              <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                  <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Transaksi</h2>
                  <div class="space-y-2">
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Invoice - #</span> {{ $sale->id }}
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Nama Pelanggan:</span> {{ $sale->member ? $sale->member->name : ($sale->customer_name ?? 'Non-Member') }}
                      </p>
                          <p class="text-gray-700 dark:text-gray-300">
                              <span class="font-medium">No. Telepon:</span> {{ $sale->member ? $sale->member->phone_number : '-' }}
                          </p>
                          <p class="text-gray-700 dark:text-gray-300">
                              <span class="font-medium">Member Sejak:</span> {{ $sale->member ? $sale->member->created_at->format('d M Y') : '-' }}
                          </p>
                          <p class="text-gray-700 dark:text-gray-300">
                              <span class="font-medium">Poin Member:</span> {{ $sale->member ? $sale->member->point : '-' }}
                          </p>
                  </div>
              </div>

              <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                  <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Ringkasan Pembayaran</h2>
                  <div class="space-y-2">
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Total Harga Sebelum Diskon:</span> Rp {{ number_format($sale->total_price + $sale->point_used, 0, ',', '.') }}
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Potongan Poin:</span> Rp {{ number_format($sale->point_used, 0, ',', '.') }} {{ $sale->point_used > 0 ? ' (' . $sale->point_used . ' Poin)' : '' }}
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Total Harga:</span> Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Jumlah Bayar:</span> Rp {{ number_format($sale->amount_paid, 0, ',', '.') }}
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Kembalian:</span> Rp {{ number_format($sale->change, 0, ',', '.') }}
                      </p>
                  </div>
              </div>
          </div>

          <h2>
              <p class="text-sm flex justify-center text-gray-700 dark:text-gray-300">
                  Dibuat pada: {{ $sale->created_at->format('d M Y') }}
              </p>

              <p class="text-sm flex justify-center text-gray-700 dark:text-gray-300">
                  Oleh: {{ $sale->user->name }}
              </p>

          </h2>
      </div>
  </div>
</x-app-layout>
