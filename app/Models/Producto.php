<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'sku',
        'nombre',
        'descr_corta',
        'descr_larga',
        'imagen',
        'precio_neto',
        'Precio_Cimpuesto',
        'stock_actual',
        'stock_minimo',
        'stock_bajo',
        'stock_alto',
    ];

    public const PORCENTAJE_IVA = 0.19;

    protected static function booted(): void
    {
        static::saving(function (Producto $producto) {
            if ($producto->isDirty('precio_neto')) {
                $producto->Precio_Cimpuesto = (int) round(
                    $producto->precio_neto * (1 + self::PORCENTAJE_IVA)
                );
            }
        });
    }

    public function getEstadoStockAttribute(): string
    {
        if ($this->stock_actual <= $this->stock_bajo) {
            return 'bajo';
        }

        if ($this->stock_actual >= $this->stock_alto) {
            return 'alto';
        }

        return 'normal';
    }
}
