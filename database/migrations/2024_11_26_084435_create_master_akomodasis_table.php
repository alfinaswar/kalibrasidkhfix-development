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
        Schema::create('master_akomodasis', function (Blueprint $table) {
            $table->id();
            $table->string('Nama')->nullable();
            $table->string('Tarif')->nullable();
            $table->enum('NA', ['Y', 'N'])->nullable();
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
        Schema::dropIfExists('master_akomodasis');
    }
};
