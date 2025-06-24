<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mutasi Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 5px; text-align: left; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Mutasi Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Transaksi</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>Harga Perolehan</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Tgl Pindah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mutasi as $i => $m)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $m->no_transaksi }}</td>
                <td>{{ $m->kode_barang }}</td>
                <td>{{ $m->nama_barang }}</td>
                <td>{{ $m->merk }}</td>
                <td>{{ $m->tipe }}</td>
                <td>{{ number_format($m->harga_perolehan, 0, ',', '.') }}</td>
                <td>{{ $m->asal }}</td>
                <td>{{ $m->tujuan }}</td>
                <td>{{ \Carbon\Carbon::parse($m->tgl_pindah)->format('d/m/Y') }}</td>
                <td>{{ $m->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
