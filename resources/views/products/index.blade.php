<!-- resources/views/products/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-between mb-6">
        <!-- Tombol Tambah Produk -->
        @if (Auth::user()->role !== 'kasir')
        <div class="mt-6">
            <a href="{{ route('products.create') }}" class="px-4 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-600">
                Tambah Produk
            </a>
        </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('products.export') }}" class="px-4 py-2 text-white transition duration-200 bg-green-500 rounded-lg hover:bg-green-600">
                Export Excel
            </a>
        </div>
        </div>

        
    

    <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800 mt-2">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr class="border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Nama Produk</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Harga</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Stok</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Gambar</th>
                    @if (Auth::user()->role !== 'kasir')
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                    @endif                
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="transition duration-200">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                        <td class="px-6 py-2 text-gray-900 dark:text-gray-100">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-2 text-gray-900 dark:text-gray-100">{{ $product->stock }}</td>
                        <td class="px-6 py-2">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover w-16 h-16 rounded-lg">
                            @else
                                <span class="text-gray-500 dark:text-gray-400">Tidak ada gambar</span>
                            @endif
                        </td>
                        @if (Auth::user()->role !== 'kasir')
                        <td class="px-4 py-2">
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-500 transition duration-200 hover:text-blue-700 dark:hover:text-blue-400">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-red-500 transition duration-200 hover:text-red-700 dark:hover:text-red-400" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</x-app-layout>
