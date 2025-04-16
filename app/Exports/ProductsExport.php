<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Harga',
            'Stok',
            'Gambar',
        ];
    }

    public function map($product): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $product->name,
            'Rp. ' . number_format($product->price, 0, ',', '.'),
            $product->stock,
            $product->image ? asset('storage/' . $product->image) : 'Tidak ada gambar',
        ];
    }
}
