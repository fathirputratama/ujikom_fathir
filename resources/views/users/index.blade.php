<!-- resources/views/users/index.blade.php -->
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Pengguna') }}
      </h2>
  </x-slot>

  <div class="container px-4 mx-auto">
      <div class="flex items-center justify-between mb-6">
      <!-- Tombol Tambah User -->
      <div class="mt-6">
          <a href="{{ route('users.create') }}"class="px-4 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-600">
              Tambah User
          </a>
      </div>
      <div class="mt-6">
          <a href="{{ route('users.export') }}" class="px-4 py-2 text-white transition duration-200 bg-green-500 rounded-lg hover:bg-green-600">
              Export Excel
          </a>
      </div>
      </div>

      <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800 mt-2">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Nama</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Email</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Role</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($users as $user)
                <tr class="transition duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <!-- No -->
                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                    <!-- Nama -->
                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                    <!-- Email -->
                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $user->email }}</td>
                    <!-- Role -->
                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ ucfirst($user->role) }}</td>
                    <!-- Aksi -->
                    <td class="px-6 py-4">
                        <a href="{{ route('users.edit', $user->id) }}" class="gap-0 text-blue-500 hover:text-blue-700">
                            Edit
                        </a>
                        <span class="text-gray-400">|</span>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</x-app-layout>
