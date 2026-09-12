<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'rut_empresa',
        'rubro',
        'razon_social',
        'telefono',
        'direccion',
        'nombre_contacto',
        'email_contacto',
    ];

    // Lista fija de rubros válidos, debe coincidir con el enum de la migración.
    // Centralizarla acá evita repetirla en el FormRequest y en la vista del select.
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