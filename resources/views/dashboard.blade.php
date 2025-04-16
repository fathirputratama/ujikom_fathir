<x-app-layout>
    <x-slot name="header">
     <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ Auth::user()->role === 'admin' ? __('Dashboard Admin') : __('Dashboard') }}
     </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
              <!-- Card Selamat Datang -->
      <div class="mb-6">
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
         <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
          Halo, {{ Auth::user()->name ?? 'Pengguna' }}!
         </h3>
         <p class="mt-2 text-gray-600 dark:text-gray-300">
          Selamat datang di dashboard penjualan
         </p>
        </div>
       </div>
        <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
         <div class="flex items-center justify-between">
          <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Penjualan Harian</h3>
          <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Persentase Penjualan Produk</h3>
         </div>
         <div class="flex justify-between">
          <div class="chart-container" style="position: relative; height: 48vh; width: 100%">
           <canvas id="dailySalesChart"></canvas>
          </div>
          <div class="chart-container" style="position: relative; height: 48vh; width: 100%">
           <canvas id="productSalesChart"></canvas>
          </div>
         </div>

        </div>

      <!-- Chart.js Script -->
      @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
       <script>
        // Bar Chart: Penjualan Harian
        const dailySalesData = {
         labels: [@foreach ($dailySales as $date => $count)'{{ $date }}', @endforeach],
         datasets: [{
          label: 'Jumlah Transaksi',
          data: [@foreach ($dailySales as $count) {{ $count }}, @endforeach],
          backgroundColor: 'rgba(59, 130, 246, 0.5)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1
         }]
        };

        const dailySalesChart = new Chart(document.getElementById('dailySalesChart'), {
         type: 'bar',
         data: dailySalesData,
         options: {
          scales: {
           y: {
            beginAtZero: true,
            title: {
             display: true,
             text: 'Transaksi'
            }
           },
           x: {
            title: {
             display: true,
             text: 'Tanggal'
            }
           }
          },
          plugins: {
           legend: {
            display: true
           }
          }
         }
        });

        // Doughnut Chart: Persentase Penjualan Produk
        const productSalesData = {
         labels: [@foreach ($productSales as $product)'{{ $product['name'] }}', @endforeach],
         datasets: [{
          label: 'Penjualan Produk',
          data: [@foreach ($productSales as $product) {{ $product['total_quantity'] }}, @endforeach],
          backgroundColor: [
           'rgba(59, 130, 246, 0.5)',
           'rgba(239, 68, 68, 0.5)',
           'rgba(34, 197, 94, 0.5)',
           'rgba(249, 115, 22, 0.5)',
           'rgba(168, 85, 247, 0.5)'
          ],
          borderColor: [
           'rgba(59, 130, 246, 1)',
           'rgba(239, 68, 68, 1)',
           'rgba(34, 197, 94, 1)',
           'rgba(249, 115, 22, 1)',
           'rgba(168, 85, 247, 1)'
          ],
          borderWidth: 1
         }]
        };

        const productSalesChart = new Chart(document.getElementById('productSalesChart'), {
         type: 'doughnut',
         data: productSalesData,
         options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
           legend: {
            position: 'right'
           }
          }
         }
        });
       </script>
      @endpush


      <!-- Card Jumlah Transaksi Hari Ini -->
      <div class="mb-6">
       <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="flex items-center justify-between">
         <div>
          <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
           Jumlah Transaksi Hari Ini
          </h4>
          <p class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">
           {{ $totalSalesToday }} Transaksi
          </p>
         </div>
         <div class="text-sm text-gray-500 dark:text-gray-400">
          Diperbarui: {{ $lastSale ? $lastSale->created_at->format('d M Y') : 'Belum ada transaksi' }}
         </div>
        </div>
       </div>
      </div>

      <!-- Total Penjualan Member dan Non-Member -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
       <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
         Total Penjualan Member
        </h4>
        <p class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">
         {{ $totalMemberSales }} Transaksi
        </p>
       </div>
       <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
         Total Penjualan Non-Member
        </h4>
        <p class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">
         {{ $totalNonMemberSales }} Transaksi
        </p>
       </div>
      </div>

      <!-- Daftar Produk Tersedia -->
      <div class="bg-white rounded-lg shadow-md dark:bg-gray-800">
       <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
         Produk Tersedia
        </h3>
        @if ($products->isEmpty())
         <p class="text-gray-600 dark:text-gray-300">
          Tidak ada produk tersedia saat ini.
         </p>
        @else
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach ($products as $product)
           <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
             {{ $product->name }}
            </h4>
            <p class="text-gray-600 dark:text-gray-300">
             Harga: Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
            <p class="text-gray-600 dark:text-gray-300">
             Stok: {{ $product->stock }}
            </p>
            <a href="{{ route('sales.create') }}"
              class="mt-3 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
             Buat Transaksi
            </a>
           </div>
          @endforeach
         </div>
        @endif
       </div>
      </div>
    </div>
   </x-app-layout>
