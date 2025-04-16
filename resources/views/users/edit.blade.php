<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Produk') }}
    </h2>
  </x-slot>

  <div class="container p-6 mx-auto">
  <form action="" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto">
      <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
          <div>
              <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nama</label>
              <input type="text" name="name" value="" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" required>
          </div>
          <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
              <input type="email" name="email" id="email" value="" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" required>
          </div>
      </div>

      <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
          <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
              <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
              <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Role</label>
              <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" required>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
              </select>
          </div>
      </div>

      <!-- Tombol Submit -->
      <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
          Simpan
      </button>
  </form>
</div>
</x-app-layout>