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
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')->constrained('penjualan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_barang')->constrained('barang')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('jumlah', 8, 0)->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
