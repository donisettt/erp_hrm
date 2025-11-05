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
        Schema::create('materials', function (Blueprint $table) {
            $table->string('id_material', 12)->primary();
            $table->string('nama');
            $table->string('satuan');
            $table->decimal('harga_satuan', 10, 2)->default(0);
            $table->integer('stok')->default(0);

            $table->string('supplier_id'); 
            $table->foreign('supplier_id')
                  ->references('id_supplier')
                  ->on('suppliers')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
