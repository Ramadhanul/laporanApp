<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MutasiBarang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $totalMutasi = MutasiBarang::count();

    $bulanIni = MutasiBarang::whereMonth('tgl_pindah', now()->month)
        ->whereYear('tgl_pindah', now()->year)
        ->count();

    $perBulan = MutasiBarang::select(
        DB::raw("DATE_FORMAT(tgl_pindah, '%Y-%m') as bulan"),
        DB::raw("COUNT(*) as total")
    )
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();

    return view('dashboard', compact('totalMutasi', 'bulanIni', 'perBulan'));
}
}
