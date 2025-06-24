<?php

namespace App\Exports;

use App\Models\MutasiBarang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MutasiExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = MutasiBarang::query();

        if ($this->request->search) {
            $query->where(function ($q) {
                $q->where('no_transaksi', 'like', "%{$this->request->search}%")
                  ->orWhere('nama_barang', 'like', "%{$this->request->search}%")
                  ->orWhere('asal', 'like', "%{$this->request->search}%")
                  ->orWhere('tujuan', 'like', "%{$this->request->search}%");
            });
        }

        if ($this->request->tgl_mulai && $this->request->tgl_selesai) {
            $query->whereBetween('tgl_pindah', [$this->request->tgl_mulai, $this->request->tgl_selesai]);
        }

        if ($this->request->harga_min !== null && $this->request->harga_max !== null) {
            $query->whereBetween('harga_perolehan', [$this->request->harga_min, $this->request->harga_max]);
        }

        return view('mutasi.excel', [
            'mutasi' => $query->get()
        ]);
    }
}
