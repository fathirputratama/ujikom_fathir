<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Checkout') }}
      </h2>
  </x-slot>

  <div class="container px-4 mx-auto">
      <form action="" method="POST" class="max-w-6xl mt-6 mx-auto" id="checkout-form">
          <div class="p-6 bg-white shadow-lg rounded-xl dark:bg-gray-800">
              <div class="flex flex-col gap-8 md:flex-row">
                  <!-- Daftar Produk -->
                  <div class="flex-1">
                      <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Produk Dipilih</h2>
                      <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                          <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-700">
                              <div class="flex items-center gap-4">
                                  <img src=""
                                      class="w-16 h-16 rounded-lg object-cover">
                                  <div class="flex-1">
                                      <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                                          makanan
                                          <input type="hidden" name="products[][id]" value="">
                                          <input type="hidden" name="products[][quantity]" value="">
                                      </h3>
                                      <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                          Harga: Rp 1000 | Qty: 999
                                      </div>
                                      <div class="text-sm font-medium text-blue-600 dark:text-blue-400 mt-1">
                                          Subtotal: 999000
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="p-3 mt-4 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                          <p class="text-lg font-bold text-blue-700 dark:text-blue-300" id="total-price">
                              Total: Rp 999000
                              <input type="hidden" id="total-price-value" value="">
                          </p>
                      </div>
                  </div>

                  <!-- Form Pembayaran -->
                  <div class="md:w-96 space-y-5">
                      <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Pembayaran</h2>

                      <!-- Status Pelanggan -->
                      <div>
                          <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Status Pelanggan</label>
                          <select name="status" id="customer-status" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                              <option value="non-member">Non-Member</option>
                              <option value="member">Member</option>
                          </select>
                      </div>

                      <!-- Input Nomor Telepon Member -->
                      <div id="phone-input" class="hidden">
                          <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">No. Telepon Member</label>
                          <input type="text" name="phone" id="phone" placeholder="08xxxxxxxxxx"
                              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                      </div>

                      <!-- Input Jumlah Bayar -->
                      <div>
                          <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Jumlah Bayar</label>
                          <input type="number" name="amount_paid" id="amount-paid" placeholder="0"
                              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" min="0" step="1">
                      </div>

                      <!-- Tombol Submit -->
                      <button type="submit"
                          class="w-full px-6 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                          Proses Pembayaran
                      </button>
                  </div>
              </div>
          </div>
      </form>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
      const statusSelect = document.getElementById('customer-status');
      const phoneInput = document.getElementById('phone-input');
      const form = document.getElementById('checkout-form');
      const amountPaidInput = document.getElementById('amount-paid');
      const totalPriceValue = parseFloat(document.getElementById('total-price-value').value);

      // Toggle phone input berdasarkan status pelanggan
      statusSelect.addEventListener('change', () => {
          if (statusSelect.value === 'member') {
              phoneInput.classList.remove('hidden');
          } else {
              phoneInput.classList.add('hidden');
          }
      });

      form.addEventListener('submit', (event) => {
          const amountPaid = parseFloat(amountPaidInput.value) || 0;

          if (amountPaid < totalPriceValue) {
              event.preventDefault();
              alert('Jumlah bayar tidak mencukupi. Harap masukkan jumlah yang sama atau lebih besar dari total harga.');
              amountPaidInput.focus();
              return;
          }

          if (statusSelect.value === 'member') {
              const phoneField = document.querySelector('input[name="phone"]');
              if (!phoneField.value.trim()) {
                  event.preventDefault();
                  alert('No. Telepon wajib diisi untuk pelanggan Member.');
                  phoneField.focus();
              }
          }
      });
  });
  </script>
</x-app-layout>