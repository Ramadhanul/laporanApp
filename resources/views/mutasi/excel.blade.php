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
                <td>{{ $m->harga_perolehan }}</td>
                <td>{{ $m->asal }}</td>
                <td>{{ $m->tujuan }}</td>
                <td>{{ $m->tgl_pindah }}</td>
                <td>{{ $m->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
