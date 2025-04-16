<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Kasir - #{{ $sale->id }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        padding: 30px;
        max-width: 800px;
        margin: auto;
    }

    h1 {
        margin-top: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    tfoot th {
        text-align: right;
    }

    .notes {
        margin-top: 20px;
        font-size: 14px;
    }

    address {
        margin-top: 20px;
        font-size: 14px;
        font-style: normal;
    }
</style>
</head>

<body>
    <h1>Invoice - #{{ $sale->id }}</h1>
    <p><strong>Nama Member:</strong> {{ $sale->member ? $sale->member->name : ($sale->customer_name ?? 'Non-Member') }}</p>
    <p><strong>No. HP:</strong> {{ $sale->member ? $sale->member->phone_number : '-' }}</p>
    <p><strong>Bergabung Sejak:</strong> {{ $sale->member ? $sale->member->created_at->format('d M Y') : '-' }}</p>
    <p><strong>Poin Member:</strong> {{ $sale->member ? $sale->member->point : '0' }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->saleDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>Rp. {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Harga Sebelum Diskon</th>
                <td>Rp. {{ number_format($sale->total_price + $sale->point_used, 0, ',', '.') }}</td>
            </tr>
            @if ($sale->point_used > 0)
                <tr>
                    <th colspan="3">Potongan Poin</th>
                    <td>Rp. {{ number_format($sale->point_used, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr>
                <th colspan="3">Harga Setelah Poin</th>
                <td>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3">Tunai</th>
                <td>Rp. {{ number_format($sale->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3">Kembalian</th>
                <td>Rp. {{ number_format($sale->change, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="notes">
        Terima kasih atas pembelian Anda.
    </div>

    <hr>

    <address>
        TzyStore<br>
        Alamat: SMK Wikrama Bogor<br>
        Email: tzybusiness@gmail.com
    </address>
</body>

</html>
