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
        Schema::create('detail_teknisi_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->string('karyawan_id');
            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
            $table->integer('qty_hari');
            $table->decimal('upah_satuan', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_teknisi_transaksi');
    }
};
