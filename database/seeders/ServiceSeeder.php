<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Pesas',
                'prices' => [
                    [
                        'period' => '1',
                        'value' => 50,
                    ],
                    [
                        'period' => '7',
                        'value' => 150,
                    ],
                    [
                        'period' => '15',
                        'value' => 200,
                    ],
                    [
                        'period' => '30',
                        'value' => 300,
                    ],
                ],
            ],
            [
                'name' => 'Zumba',
                'prices' => [
                    [
                        'period' => '30',
                        'value' => 350,
                    ],
                ],
            ],
            [
                'name' => 'Zumba + Pesas',
                'prices' => [
                    [
                        'period' => '30',
                        'value' => 550,
                    ],
                ],
            ],
        ];

        foreach ($services as $service) {
            $created = Service::create([
                'name' => $service['name'],
            ]);

            $created->prices()->createMany($service['prices']);
        }
    }
}
