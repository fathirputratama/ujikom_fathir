<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Kasir - </title>
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
    <h1>Invoice - #</h1>
    <p><strong>Nama Member:</strong> Rudi / Non-member</p>
    <p><strong>No. HP:</strong> 081234567890</p>
    <p><strong>Bergabung Sejak:</strong> 2023-01-01</p>
    <p><strong>Poin Member:</strong> 999</p>

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
                <tr>
                    <td>makanan</td>
                    <td>Rp. 1000</td>
                    <td>999</td>
                    <td>Rp. 999000</td>
                </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Harga Sebelum Diskon</th>
                <td>Rp. 999000</td>
            </tr>
                <tr>
                    <th colspan="3">Potongan Poin</th>
                    <td>Rp. 0</td>
                </tr>
            <tr>
                <th colspan="3">Harga Setelah Poin</th>
                <td>Rp. 999000</td>
            </tr>
            <tr>
                <th colspan="3">Tunai</th>
                <td>Rp. 999000</td>
            </tr>
            <tr>
                <th colspan="3">Kembalian</th>
                <td>Rp. 0</td>
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
