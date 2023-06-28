<?php

namespace Database\Seeders;

use App\Models\Concept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concepts = [
            [
                'name' => 'Bebidas',
            ],
            [
                'name' => 'Tienda',
            ],
            [
                'name' => 'Suplementos',
            ],
            [
                'name' => 'Agua',
            ],
            [
                'name' => 'Articulos de limpieza',
            ],
            [
                'name' => 'Energia',
            ],
            [
                'name' => 'Equipo y maquinaria',
            ],
            [
                'name' => 'Impuestos',
            ],
            [
                'name' => 'Internet',
            ],
            [
                'name' => 'Limpieza',
            ],
            [
                'name' => 'Papeleria',
            ],
            [
                'name' => 'Publicidad',
            ],
            [
                'name' => 'Servicios',
            ],
        ];

        foreach ($concepts as $concept) {
            Concept::create($concept);
        }
    }
}
