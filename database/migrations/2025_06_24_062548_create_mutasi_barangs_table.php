<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('merk');
            $table->string('tipe');
            $table->decimal('harga_perolehan', 15, 2)->default(0);
            $table->string('asal');
            $table->string('tujuan');
            $table->date('tgl_pindah');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_barangs');
    }
};
