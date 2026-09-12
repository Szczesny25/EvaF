<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario Extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'rut',
        'nomrbe',
        'apellido',
        'correo',
        'contraseña',
    ];

    protected $hidden = [
        'contraseña'
    ];

    protected static function booted(): void{
        
        static::saving(function(Usuario $usuario){
            if ($usuario->isDirty('contraseña') && ! str_starts_with($usuario->contraseña, '$2y$')) {
                $usuario->contraseña = Hash::make($usuario->contraseña); 
            }
        });
    }
}