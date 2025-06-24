<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $fillable = [
    'no_transaksi', 'kode_barang', 'nama_barang', 'merk', 'tipe',
    'harga_perolehan', 'asal', 'tujuan', 'tgl_pindah', 'keterangan'
];

}
