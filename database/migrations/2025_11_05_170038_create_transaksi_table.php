<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('proyek_id')->unique();
            $table->foreign('proyek_id')->references('id_proyek')->on('proyek')->onDelete('cascade');
            $table->enum('pembayaran', ['Belum Bayar', 'DP', 'Lunas'])->default('Belum Bayar');
            $table->enum('status_transaksi', ['Diproses', 'Selesai', 'Batal'])->default('Diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
