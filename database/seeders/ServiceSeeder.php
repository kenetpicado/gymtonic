<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'Pesas',
            'Zumba',
            'Zumba + Pesas',
        ];

        foreach ($services as $service) {
            \App\Models\Service::create([
                'name' => $service
            ]);
        }
    }
}
