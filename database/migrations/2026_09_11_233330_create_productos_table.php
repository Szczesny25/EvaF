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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descr_corta');
            $table->text('descr_larga');
            $table->string('imagen');
            $table->unsignedInteger('Precio_neto');
            $table->unsignedInteger('Precio_Cimpuesto');
            $table->unsignedInteger('stock_actual');
            $table->unsignedInteger('stock_minimo');
            $table->unsignedInteger('stock_bajo');
            $table->unsignedInteger('stock_alto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
