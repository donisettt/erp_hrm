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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('id_karyawan', 10)->primary();
            $table->string('no_ktp', 20)->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('jabatan');
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->decimal('upah_harian', 10, 2)->default(0);
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
