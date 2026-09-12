<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table;

    protected $fillable = [
        'sku',
        'nomrbe',
        'descr_corta',
        'descr_larga',
        'imagen',
        'Precio_neto',
        'Precio_Cimpuesto',
        'stock_actual',
        'stock_minimo',
        'stock_bajo',
        'stock_alto',
    ];
    
    public const El_malvado_IVA = 0.19;

    protected static function booted(): void
    {
        static::saving(function(Producto $producto){
            if ($producto->isDirty('precio_neto')) {
                $producto->precio_Cimpuesto = (int) round(
                    $producto->Precio_neto * (1 + self::El_malvado_IVA) 
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

