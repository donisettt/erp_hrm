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
        Schema::create('proyek', function (Blueprint $table) {
            $table->string('id_proyek', 15)->primary();
            $table->string('nama_proyek');
            $table->decimal('harga_borongan', 15, 2)->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->string('customer_id'); 
            $table->foreign('customer_id')
                  ->references('id_customer')
                  ->on('customers')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('spbu_id');
            $table->foreign('spbu_id')
                  ->references('id')
                  ->on('spbu')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
