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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('subtotal', 8, 0)->default(0);
            $table->integer('total_item')->default(0);
            $table->timestamps();
        });

        Schema::create('cart_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cart')->constrained('cart')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_barang')->constrained('barang')->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('subtotal', 8, 0)->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
