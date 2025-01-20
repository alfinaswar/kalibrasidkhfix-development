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
        Schema::create('master_keselamatan_listriks', function (Blueprint $table) {
            $table->id();
            $table->string('Parameter')->nullable();
            $table->string('ParameterEng')->nullable();
            $table->string('Satuan')->nullable();
            $table->string('AmbangBatas')->nullable();
            $table->string('MappingExcel')->nullable();
            $table->string('created_by')->nullable();
            $table->string('edited_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_keselamatan_listriks');
    }
};
