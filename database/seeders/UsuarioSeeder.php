<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'rut' => '11111111-1',
            'nombre' => 'El Mas',
            'apellido' => 'Capito',
            'correo' => 'elmas@camito.cl',
            'contraseña' => Hash::make('Papaya123'),
        ]);
    }
}