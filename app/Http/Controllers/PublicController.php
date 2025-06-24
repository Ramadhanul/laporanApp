<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MutasiExport;

class PublicController extends Controller
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
        $mutasi->where(function($q) use ($keyword) {
            $q->where('no_transaksi', 'like', "%$keyword%")
              ->orWhere('nama_barang', 'like', "%$keyword%")
              ->orWhere('asal', 'like', "%$keyword%")
              ->orWhere('tujuan', 'like', "%$keyword%");
        });
    }

    if ($tgl_mulai && $tgl_selesai) {
        $mutasi->whereBetween('tgl_pindah', [$tgl_mulai, $tgl_selesai]);
    }

    if ($harga_min !== null && $harga_max !== null) {
        $mutasi->whereBetween('harga_perolehan', [$harga_min, $harga_max]);
    }

    $data = $mutasi->latest()->paginate(15);

    $total = MutasiBarang::count();
    $bulan_ini = MutasiBarang::whereMonth('tgl_pindah', now()->month)->count();

    return view('public.index', compact('data', 'keyword', 'tgl_mulai', 'tgl_selesai', 'harga_min', 'harga_max', 'total', 'bulan_ini'));
}



public function cetakPdf(Request $request)
{
    $mutasi = $this->filterData($request)->get();

    $pdf = Pdf::loadView('public.pdf', compact('mutasi'))->setPaper('a4', 'landscape');
    return $pdf->stream('laporan-mutasi-publik.pdf');
}



public function exportExcel(Request $request)
{
    return Excel::download(new MutasiExport($request), 'mutasi_publik.xlsx');
}

private function filterData(Request $request)
{
    $query = MutasiBarang::query();

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('no_transaksi', 'like', "%{$request->search}%")
              ->orWhere('nama_barang', 'like', "%{$request->search}%")
              ->orWhere('asal', 'like', "%{$request->search}%")
              ->orWhere('tujuan', 'like', "%{$request->search}%");
        });
    }

    if ($request->tgl_mulai && $request->tgl_selesai) {
        $query->whereBetween('tgl_pindah', [$request->tgl_mulai, $request->tgl_selesai]);
    }

    if ($request->harga_min !== null && $request->harga_max !== null) {
        $query->whereBetween('harga_perolehan', [$request->harga_min, $request->harga_max]);
    }

    return $query;
}

public function dashboard()
{
    $total = MutasiBarang::count();
    $bulan_ini = MutasiBarang::whereMonth('tgl_pindah', now()->month)->count();

    $chart = MutasiBarang::selectRaw("DATE_FORMAT(tgl_pindah, '%Y-%m') as bulan, COUNT(*) as total")
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    return view('public.dashboard', compact('total', 'bulan_ini', 'chart'));
}

public function data(Request $request)
{
    $keyword = $request->search;
    $tgl_mulai = $request->tgl_mulai;
    $tgl_selesai = $request->tgl_selesai;
    $harga_min = $request->harga_min;
    $harga_max = $request->harga_max;

    $mutasi = MutasiBarang::query();

    if ($keyword) {
        $mutasi->where(function ($q) use ($keyword) {
            $q->where('no_transaksi', 'like', "%$keyword%")
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

    $data = $mutasi->latest()->paginate(15);

    return view('public.data', compact('data', 'keyword', 'tgl_mulai', 'tgl_selesai', 'harga_min', 'harga_max'));
}

}
