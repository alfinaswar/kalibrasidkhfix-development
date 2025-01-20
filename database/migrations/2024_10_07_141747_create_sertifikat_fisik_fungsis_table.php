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
        Schema::create('sertifikat_fisik_fungsis', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->json('Parameter1')->nullable();
            $table->json('Parameter2')->nullable();
            $table->json('Parameter3')->nullable();
            $table->json('Parameter4')->nullable();
            $table->json('Parameter5')->nullable();
            $table->json('Parameter6')->nullable();
            $table->json('Parameter7')->nullable();
            $table->json('Parameter8')->nullable();
            $table->json('Parameter9')->nullable();
            $table->json('Parameter10')->nullable();
            $table->json('Parameter11')->nullable();
            $table->json('Parameter12')->nullable();
            $table->json('Parameter13')->nullable();
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
        Schema::dropIfExists('sertifikat_fisik_fungsis');
    }
};
