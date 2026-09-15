<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'rut_empr',
        'rubro',
        'razon_social',
        'telefono',
        'direccion',
        'nombre_contacto',
        'correo_contacto',
    ];

    public const RUBROS = [
        'retail',
        'manufactura',
        'tecnologia',
        'servicios',
        'construccion',
        'alimentos',
        'otro',
    ];
}