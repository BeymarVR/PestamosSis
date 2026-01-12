<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        Usuario::create([
            'nombre_completo' => 'Admin Principal',
            'correo' => 'admin@hogar.com',
            'contrasena' => Hash::make('admin123'),
            'ci' => '9999999',
            'expedido' => 'LP',
            'celular' => '70000000',
            'rol_id' => 1,
        ]);
    }
}
