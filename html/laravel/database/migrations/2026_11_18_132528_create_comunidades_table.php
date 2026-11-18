<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comunidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_gestora_id')->constrained('empresas_gestoras')->onDelete('cascade');
            $table->foreignId('zona_id')->constrained('zonas')->onDelete('restrict');
            $table->string('nombre', 150);
            $table->string('direccion', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comunidades');
    }
};