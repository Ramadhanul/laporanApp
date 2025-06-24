<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MutasiBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MutasiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MutasiImport;

class MutasiBarangController extends Controller
{
    public function index(Request $request)
{
    $keyword = $request->input('search');
    $tgl_mulai = $request->input('tgl_mulai');
    $tgl_selesai = $request->input('tgl_selesai');
    $harga_min = $request->input('harga_min');
    $harga_max = $request->input('harga_max');

    $mutasi = MutasiBarang::query();

    if ($keyword) {
        $mutasi->where(function($query) use ($keyword) {
            $query->where('no_transaksi', 'like', "%$keyword%")
                  ->orWhere('nama_barang', 'like', "%$keyword%")
                  ->orWhere('asal', 'like', "%$keyword%")
                  ->orWhere('kode_barang', 'like', "%$keyword%")
                  ->orWhere('merk', 'like', "%$keyword%")
                  ->orWhere('tipe', 'like', "%$keyword%")
                  ->orWhere('keterangan', 'like', "%$keyword%")
                  ->orWhere('tujuan', 'like', "%$keyword%");
        });
    }

    if ($tgl_mulai && $tgl_selesai) {
        $mutasi->whereBetween('tgl_pindah', [$tgl_mulai, $tgl_selesai]);
    }

    if ($harga_min !== null && $harga_max !== null) {
        $mutasi->whereBetween('harga_perolehan', [$harga_min, $harga_max]);
    }

    $data = $mutasi->get();

    return view('mutasi.index', [
        'mutasi' => $data,
        'keyword' => $keyword,
        'tgl_mulai' => $tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'harga_min' => $harga_min,
        'harga_max' => $harga_max,
    ]);
}



public function cetak()
{
    $mutasi = MutasiBarang::all();
    $pdf = Pdf::loadView('mutasi.laporan', compact('mutasi'));
    return $pdf->stream('laporan-mutasi.pdf');
}

public function create()
{
    return view('mutasi.create');
}

public function store(Request $request)
{
    $request->validate([
        'no_transaksi' => 'required|unique:mutasi_barangs',
        'kode_barang' => 'required',
        'nama_barang' => 'required',
        'merk' => 'required',
        'tipe' => 'required',
        'harga_perolehan' => 'required|numeric',
        'asal' => 'required',
        'tujuan' => 'required',
        'tgl_pindah' => 'required|date',
        'keterangan' => 'nullable',
    ]);

    MutasiBarang::create($request->all());

    return redirect()->route('mutasi.index')->with('success', 'Data berhasil ditambahkan');
}

public function edit($id)
{
    $mutasi = MutasiBarang::findOrFail($id);
    return view('mutasi.edit', compact('mutasi'));
}

public function update(Request $request, $id)
{
    $mutasi = MutasiBarang::findOrFail($id);

    $request->validate([
        'no_transaksi' => 'required|unique:mutasi_barangs,no_transaksi,' . $mutasi->id,
        'kode_barang' => 'required',
        'nama_barang' => 'required',
        'merk' => 'required',
        'tipe' => 'required',
        'harga_perolehan' => 'required|numeric',
        'asal' => 'required',
        'tujuan' => 'required',
        'tgl_pindah' => 'required|date',
        'keterangan' => 'nullable',
    ]);

    $mutasi->update($request->all());

    return redirect()->route('mutasi.index')->with('success', 'Data berhasil diupdate');
}

public function destroy($id)
{
    $mutasi = MutasiBarang::findOrFail($id);
    $mutasi->delete();

    return redirect()->route('mutasi.index')->with('success', 'Data berhasil dihapus');
}

public function cetakFilter(Request $request)
{
    $keyword = $request->input('search');
    $tgl_mulai = $request->input('tgl_mulai');
    $tgl_selesai = $request->input('tgl_selesai');
    $harga_min = $request->input('harga_min');
    $harga_max = $request->input('harga_max');

    $mutasi = MutasiBarang::query();

    if ($keyword) {
        $mutasi->where(function($query) use ($keyword) {
            $query->where('no_transaksi', 'like', "%$keyword%")
                  ->orWhere('nama_barang', 'like', "%$keyword%")
                  ->orWhere('asal', 'like', "%$keyword%")
                  ->orWhere('kode_barang', 'like', "%$keyword%")
                  ->orWhere('merk', 'like', "%$keyword%")
                  ->orWhere('tipe', 'like', "%$keyword%")
                  ->orWhere('keterangan', 'like', "%$keyword%")
                  ->orWhere('tujuan', 'like', "%$keyword%");
        });
    }

    if ($tgl_mulai && $tgl_selesai) {
        $mutasi->whereBetween('tgl_pindah', [$tgl_mulai, $tgl_selesai]);
    }

    if ($harga_min !== null && $harga_max !== null) {
        $mutasi->whereBetween('harga_perolehan', [$harga_min, $harga_max]);
    }

    $data = $mutasi->get();

    $pdf = Pdf::loadView('mutasi.laporan', ['mutasi' => $data]);
    return $pdf->stream('laporan-filtered.pdf');
}


public function exportExcel(Request $request)
{
    return Excel::download(new MutasiExport($request), 'laporan_mutasi.xlsx');
}

public function importExcel(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new MutasiImport, $request->file('file'));

    return redirect()->route('mutasi.index')->with('success', 'Data berhasil diimpor dari Excel.');
}

}
