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
        Schema::table('barang', function (Blueprint $table) {
            $table->softDeletes()->nullable();
        });

        Schema::table('satuan', function (Blueprint $table) {
            $table->softDeletes()->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('satuan', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
