<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::with(['member', 'user', 'saledetails.product'])
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function headings():array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk',
            'Total Harga Setelah Diskon',
            'Total Bayar',
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal Penjualan',
        ];
    }

    public function map($sale): array
    {
        $products = $sale->saledetails->map(function ($detail) {
            return "{$detail->product->name} x{$detail->quantity}";
        })->implode(', ');

        return [
            $sale->member ? $sale->member->name : 'Non-Member',
            $sale->member ? $sale->member->phone_number : '-',
            $sale->member ? (int) $sale->member->point : 0, // Cast to int to avoid decimals
            $products ?: '-',
            'Rp ' . number_format($sale->total_price, 0, ',', '.'), // Add 'Rp ' prefix
            'Rp ' . number_format($sale->amount_paid, 0, ',', '.'), // Add 'Rp ' prefix
            'Rp ' . number_format($sale->point_used, 0, ',', '.'), // Add 'Rp ' prefix
            'Rp ' . number_format($sale->change, 0, ',', '.'), // Add 'Rp ' prefix
            $sale->created_at->format('d M Y H:i'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
}

}
