<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiBarangController;
use App\Exports\MutasiExport;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ChatbotController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/public', [PublicController::class, 'index'])->name('public.index');
Route::get('/public/cetak-pdf', [PublicController::class, 'cetakPdf'])->name('public.cetak.pdf');
Route::get('/public/export-excel', [PublicController::class, 'exportExcel'])->name('public.export.excel');
Route::get('/public/data', [PublicController::class, 'data'])->name('public.data');
Route::get('/public/chatbot', [ChatbotController::class, 'index'])->name('public.chatbot');
Route::post('/public/chatbot/ask', [ChatbotController::class, 'ask'])->name('public.chatbot.ask');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [MutasiBarangController::class, 'index'])->name('mutasi.index');
    Route::get('/create', [MutasiBarangController::class, 'create'])->name('mutasi.create');
    Route::post('/store', [MutasiBarangController::class, 'store'])->name('mutasi.store');
    Route::get('/{id}/edit', [MutasiBarangController::class, 'edit'])->name('mutasi.edit');
    Route::put('/{id}', [MutasiBarangController::class, 'update'])->name('mutasi.update');
    Route::delete('/{id}', [MutasiBarangController::class, 'destroy'])->name('mutasi.destroy');
    Route::get('/cetak', [MutasiBarangController::class, 'cetak'])->name('mutasi.cetak');
    Route::get('/cetak-filter', [MutasiBarangController::class, 'cetakFilter'])->name('mutasi.cetak.filter');
    Route::get('/export-excel', [MutasiBarangController::class, 'exportExcel'])->name('mutasi.export.excel');
    Route::post('/import-excel', [MutasiBarangController::class, 'importExcel'])->name('mutasi.import.excel');
});

require __DIR__.'/auth.php';
