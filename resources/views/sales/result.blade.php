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
              <a href="" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                  Kembali
              </a>
              <a href="" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                  Unduh PDF
              </a>
          </div>

          <!-- Detail Transaksi -->
          <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
              <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                  <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Transaksi</h2>
                  <div class="space-y-2">
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Invoice - #</span> 01
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Nama Pelanggan:</span> Rudy / Non-member
                      </p>
                          <p class="text-gray-700 dark:text-gray-300">
                              <span class="font-medium">No. Telepon:</span> 081234567890
                          </p>
                          <p class="text-gray-700 dark:text-gray-300">
                              <span class="font-medium">Member Sejak:</span> 2023-01-01
                          </p>
                          <p class="text-gray-700 dark:text-gray-300">
                              <span class="font-medium">Poin Member:</span> 999
                          </p>
                  </div>
              </div>

              <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                  <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Ringkasan Pembayaran</h2>
                  <div class="space-y-2">
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Total Harga Sebelum Diskon:</span> Rp 1000
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Potongan Poin:</span> Rp 0 (0 poin)
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Total Harga:</span> Rp 999000
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Jumlah Bayar:</span> Rp 999000
                      </p>
                      <p class="text-gray-700 dark:text-gray-300">
                          <span class="font-medium">Kembalian:</span> Rp 0
                      </p>
                  </div>
              </div>
          </div>

          <!-- Daftar Produk -->
          <div class="mb-8">
              <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Produk yang Dibeli</h2>
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
                                  <tr class="transition duration-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                      <td class="px-4 py-3 text-gray-900 dark:text-gray-100">makanan</td>
                                      <td class="px-4 py-3 text-gray-900 dark:text-gray-100">Rp 1000</td>
                                      <td class="px-4 py-3 text-gray-900 dark:text-gray-100">999</td>
                                      <td class="px-4 py-3 text-gray-900 dark:text-gray-100">Rp 999000</td>
                                  </tr>
                          </tbody>
                      </table>
                  </div>
          </div>
          <h2>
              <p class="text-sm flex justify-center text-gray-700 dark:text-gray-300">
                  Dibuat pada: 
              </p>

              <p class="text-sm flex justify-center text-gray-700 dark:text-gray-300">
                  Oleh: 
              </p>

          </h2>
      </div>
  </div>
</x-app-layout>