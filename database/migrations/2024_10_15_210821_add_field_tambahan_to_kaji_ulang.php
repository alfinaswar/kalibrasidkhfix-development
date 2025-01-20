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
        Schema::table('kaji_ulangs', function (Blueprint $table) {
            $table->enum('Tambahan', ['YA', 'TIDAK'])->nullable()->default(null)->after('Catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kaji_ulangs', function (Blueprint $table) {
            //
        });
    }
};
