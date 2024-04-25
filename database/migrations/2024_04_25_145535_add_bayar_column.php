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
        Schema::table('penjualan', function ($table) {
            $table->decimal('bayar', 8, 0)->default(0);
            $table->decimal('kembali', 8, 0)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function ($table) {
            $table->dropColumn('bayar', 8, 0);
            $table->dropColumn('kembali', 8, 0);
        });
    }
};
