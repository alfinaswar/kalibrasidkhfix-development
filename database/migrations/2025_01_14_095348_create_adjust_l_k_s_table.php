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
        Schema::create('adjust_lk', function (Blueprint $table) {
            $table->id();
            $table->string('InstrumenId')->nullable();
            $table->enum('PengukuranSuhu', ['Y', 'N'])->nullable()->default('Y');
            $table->enum('TeganganUtama', ['Y', 'N'])->nullable()->default('N');
            $table->json('FisikFungsi')->nullable();
            $table->json('KeselamatanListrik')->nullable();
            $table->enum('TelaahTeknis', ['Y', 'N'])->nullable()->default('Y');
            $table->string('idUser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjust_l_k_s');
    }
};
