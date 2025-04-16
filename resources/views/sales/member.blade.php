<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Member') }}
      </h2>
  </x-slot>

  <div class="container px-4 mx-auto">
      <form action="{{ route('sales.store') }}" method="POST" class="max-w-6xl mt-6 mx-auto">
          @csrf
          <input type="hidden" name="phone" value="{{ $phone }}">
          <input type="hidden" name="amount_paid" value="{{ $amount_paid }}">
          @foreach ($selectedProducts as $product)
              <input type="hidden" name="products[{{ $product['id'] }}][id]" value="{{ $product['id'] }}">
              <input type="hidden" name="products[{{ $product['id'] }}][quantity]" value="{{ $product['quantity'] }}">
          @endforeach
          <input type="hidden" name="status" value="member">
          @if ($member && $member->point > 0)
              <input type="hidden" id="points_to_use" name="points_to_use" value="0">
          @endif
          <div class="flex flex-col md:flex-row gap-6">
              <!-- KIRI: Daftar Produk -->
              <div class="w-full md:w-2/3 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                  <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Detail Penjualan</h2>
                  <div class="space-y-2">
                    @foreach ($selectedProducts as $item)
                          <div class="flex justify-between items-center pb-2">
                              <div>
                                  <p class="font-semibold text-lg text-gray-700 dark:text-gray-300">{{ $item['name'] }}</p>
                                  <p class="text-sm text-gray-700 dark:text-gray-300">
                                      Qty: {{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                                  </p>
                              </div>
                              <p class="text-right font-semibold text-green-600 dark:text-green-300">
                                  Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                              </p>
                          </div>
                      @endforeach
                  </div>

                  <div class="mt-6 border-t pt-4 space-y-2">
                      <div class="flex justify-between">
                          <p class="font-semibold text-lg text-gray-700 dark:text-gray-300">Total Harga:</p>
                          <p class="text-green-700 dark:text-green-300 font-semibold">
                              Rp {{ number_format($totalPrice, 0, ',', '.') }}
                          </p>
                      </div>
                      <div class="flex justify-between">
                          <p class="font-semibold text-lg text-gray-700 dark:text-gray-300">Total Bayar:</p>
                          <p class="text-blue-700 dark:text-blue-300 font-semibold">
                              Rp {{ number_format($amount_paid, 0, ',', '.') }}
                          </p>
                      </div>
                  </div>
              </div>

              <!-- KANAN: Member Info -->
              <div class="w-full md:w-1/3 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                  <h2 class="text-xl font-bold mb-4">Informasi Member</h2>

                  <div class="space-y-4">
                      <div>
                          <label for="member_name" class="block text-sm font-medium">Nama Member</label>
                          <input type="text" id="member_name" name="member_name"
                              class="mt-1 block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:text-white"
                              value="{{ $member ? $member->name : old('member_name') }}" {{ $member ? 'readonly' : '' }}
                               />
                               @error('member_name')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                      </div>

                      <div>
                          <label for="points" class="block text-sm font-medium">Poin Saat Ini</label>
                          <input type="text" id="points" name="points" readonly
                              class="mt-1 block w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:text-white"
                              value="{{ $member ? $member->point : 0 }}" />
                      </div>

                      @if ($member && $member->point > 0)
                          <div class="flex items-center gap-2">
                              <input type="checkbox" id="use_points" name="use_points" value="1"
                                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                              <label for="use_points" class="text-sm">Gunakan semua poin ({{ $member->point }} poin)</label>
                          </div>
                          @endif

                      <button type="submit"
                          class="w-full px-6 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                          Simpan Transaksi
                      </button>
                  </div>
              </div>
          </div>
      </form>
  </div>
  <script>
            document.addEventListener('DOMContentLoaded', () => {
                const usePointsCheckbox = document.getElementById('use_points');
                const pointsToUseInput = document.getElementById('points_to_use');

                if (usePointsCheckbox && pointsToUseInput) {
                    // Default: checkbox dicentang, gunakan semua poin
                    const maxPoints = Math.min({{ $member ? $member->point : 0 }}, {{ $totalPrice }});
                    pointsToUseInput.value = usePointsCheckbox.checked ? maxPoints : 0;

                    // Update poin saat checkbox berubah
                    usePointsCheckbox.addEventListener('change', () => {
                        pointsToUseInput.value = usePointsCheckbox.checked ? maxPoints : 0;
                    });
                }
            });
        </script>

</x-app-layout>
