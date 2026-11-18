<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incidencia_id')->unique()->constrained('incidencias')->onDelete('cascade');
            $table->foreignId('empresa_gestora_id')->constrained('empresas_gestoras')->onDelete('restrict');
            $table->decimal('precio_base_aplicado', 10, 2);
            $table->decimal('porcentaje_aplicado', 5, 2);
            $table->decimal('importe_comision', 10, 2);
            $table->timestamp('fecha_generacion')->useCurrent();
            $table->timestamps();

            $table->index(['empresa_gestora_id', 'fecha_generacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comisiones');
    }
};