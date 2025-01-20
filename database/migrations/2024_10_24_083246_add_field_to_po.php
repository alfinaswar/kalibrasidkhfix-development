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
        Schema::table('pos', function (Blueprint $table) {
            $table->enum('Approve', ['Y', 'N'])->nullable()->after('Disetujui');
            $table->string('ApproveBy', 10)->nullable()->after('Approve');
            $table->timestamp('ApproveDate')->nullable()->useCurrent()->after('ApproveBy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            //
        });
    }
};
