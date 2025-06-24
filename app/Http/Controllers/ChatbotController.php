<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MutasiBarang;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('public.chatbot');
    }

    public function ask(Request $request)
    {
        $question = $request->input('question');

        $data = MutasiBarang::latest()->limit(20)->get();

        $dataSummary = $data->map(function($item) {
            return "No: {$item->no_transaksi}, Kode: {$item->kode_barang}, Nama: {$item->nama_barang}, Merk: {$item->merk}, Tipe: {$item->tipe}, Harga: {$item->harga_perolehan}, Asal: {$item->asal}, Tujuan: {$item->tujuan}, Tgl: {$item->tgl_pindah}, Keterangan: {$item->keterangan}";
        })->implode("\n");

        $prompt = "Berikut adalah 20 data mutasi barang terakhir:\n\n" . $dataSummary . "\n\nPertanyaan:\n" . $question;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY'),
            [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ]
        );


        if (!$response->successful()) {
            return response()->json(['reply' => 'Gagal menghubungi Gemini API.']);
        }

        $text = $response->json('candidates.0.content.parts.0.text') ?? 'Tidak ada jawaban.';
        return response()->json(['reply' => $text]);


        return response()->json(['reply' => $text]);
    }
}

