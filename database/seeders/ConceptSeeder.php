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
                'image' => 'https://i.postimg.cc/gjqYGL9N/drinks.png'
            ],
            [
                'name' => 'Tienda',
                'image' => 'https://i.postimg.cc/T2r2VFyg/shop.png'
            ],
            [
                'name' => 'Suplementos',
                'image' => 'https://i.postimg.cc/tCpq2kPf/supplements.png'
            ],
            [
                'name' => 'Agua',
                'image' => 'https://i.postimg.cc/XqtQgWV5/water.png'
            ],
            [
                'name' => 'Articulos de limpieza',
                'image' => 'https://i.postimg.cc/T1sHHmcp/cleaner.png'
            ],
            [
                'name' => 'Energia',
                'image' => 'https://i.postimg.cc/6QhbxF0s/energy.png'
            ],
            [
                'name' => 'Equipo y maquinaria',
                'image' => 'https://i.postimg.cc/yNKp570X/gym-dumbbell.png'
            ],
            [
                'name' => 'Impuestos',
                'image' => 'https://i.postimg.cc/2y10vyfm/tax.png'
            ],
            [
                'name' => 'Internet',
                'image' => 'https://i.postimg.cc/76YsHXs5/internet.png'
            ],
            [
                'name' => 'Limpieza',
                'image' => 'https://i.postimg.cc/RZKbXWJZ/cleaner-person.png'
            ],
            [
                'name' => 'Papeleria',
                'image' => 'https://i.postimg.cc/BQ8zPYqD/papers.png'
            ],
            [
                'name' => 'Publicidad',
                'image' => 'https://i.postimg.cc/HWvKxDCd/promotion.png'
            ],
            [
                'name' => 'Servicios',
                'image' => 'https://i.postimg.cc/G27MHYVq/services.png'
            ],
        ];

        foreach ($concepts as $concept) {
            Concept::create($concept);
        }
    }
}
