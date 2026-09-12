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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('rut_empr', 12)->unique();
            $table->enum('rubro', [
                'retail',
                'manufactura',
                'tecnologia',
                'servicios',
                'construccion',
                'alimentos',
                'otro',
             ]);
            $table->string('razon_social', 150);
            $table->string('telefono', 20);
            $table->string('direccion', 150);
            $table->string('nombre_contacto', 100);
            $table->string('correo_contacto', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
