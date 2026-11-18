<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('localizador', 20)->unique();
            $table->foreignId('cliente_id')->constrained('usuarios')->onDelete('restrict');
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos')->onDelete('set null');
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('restrict');
            $table->foreignId('comunidad_id')->nullable()->constrained('comunidades')->onDelete('set null');
            $table->foreignId('zona_id')->nullable()->constrained('zonas')->onDelete('set null');
            $table->text('descripcion');
            $table->string('direccion', 255);
            $table->dateTime('fecha_servicio');
            $table->enum('tipo_urgencia', ['Estándar', 'Urgente'])->default('Estándar');
            $table->enum('estado', ['Pendiente', 'Asignada', 'En curso', 'Finalizada', 'Cancelada'])->default('Pendiente');
            $table->timestamps();

            $table->index(['estado', 'zona_id']);
            $table->index('fecha_servicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};