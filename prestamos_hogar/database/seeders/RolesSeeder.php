<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Rol::insert([
            ['nombre' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'gestor', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'usuario', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

