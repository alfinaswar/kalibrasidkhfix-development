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
        Schema::create('akomodasi_details', function (Blueprint $table) {
            $table->id();
            $table->string('idQuotation')->nullable();
            $table->string('PoId')->nullable();
            $table->string('AkomodasiId')->nullable();
            $table->bigInteger('Qty')->nullable();
            $table->string('Price')->nullable();
            $table->longText('Deskripsi')->nullable();
            $table->string('idUser')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akomodasi_details');
    }
};
