<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Modalidade;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // <name>_<abreviation>|<name>_<abreviation>

        Modalidade::create([
            'name' => 'Escolarizado',
            'descripcion' => 'Turnos durante la semana',
            'activo' => true,
            'contents' => 'Parcial 1_P1|Parcial 2_P2|Parcial 3_P3|Final_F|Extraordinario_Extra'
        ]);

        Modalidade::create([
            'name' => 'Ejecutivo',
            'descripcion' => 'Turnos en los sabados',
            'activo' => true,
            'contents' => 'Bloque 1_B1|Bloque 2_B2'
        ]);
    }
}
