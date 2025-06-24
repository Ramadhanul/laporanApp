<?php

namespace App\Imports;

use App\Models\MutasiBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MutasiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MutasiBarang([
            'no_transaksi' => $row['no_transaksi'],
            'kode_barang' => $row['kode_barang'],
            'nama_barang' => $row['nama_barang'],
            'merk' => $row['merk'],
            'tipe' => $row['tipe'],
            'harga_perolehan' => $row['harga_perolehan'],
            'asal' => $row['asal'],
            'tujuan' => $row['tujuan'],
            'tgl_pindah' => $row['tgl_pindah'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}

