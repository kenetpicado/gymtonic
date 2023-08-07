<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Kenet Picado',
                'email' => 'kenetpicado1@gmail.com',
                'password' => Hash::make('26051998'),
                'role' => 'root'
            ],
            [
                'name' => 'Josiel Alonso',
                'email' => 'josielalonso@gmail.com',
                'password' =>  Hash::make('jdUR73jdh'),
                'role' => RoleEnum::ADMINISTRADOR
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
