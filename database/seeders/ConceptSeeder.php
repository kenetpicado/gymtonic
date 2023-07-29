<?php

namespace Database\Seeders;

use App\Models\Concept;
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
                'has_income' => true,
            ],
            [
                'name' => 'Tienda',
                'has_income' => true,
            ],
            [
                'name' => 'Suplementos',
                'has_income' => true,
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
            [
                'name' => 'Planes diarios',
                'has_income' => true,
                'has_expenditure' => false,
            ],
            [
                'name' => 'Otros',
                'has_income' => true,
                'has_expenditure' => true,
            ],
        ];

        foreach ($concepts as $concept) {
            Concept::create($concept);
        }
    }
}
