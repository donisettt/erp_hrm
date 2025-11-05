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
        Schema::create('spbu', function (Blueprint $table) {
            $table->id();
            $table->string('no_spbu')->unique();
            $table->string('manajer');
            $table->string('nama_lokasi');
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('jam_operasional')->nullable();
            $table->string('customer_id');
            $table->foreign('customer_id')->references('id_customer')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spbu');
    }
};
