<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Josiel Alonso',
                'email' => 'josielalonso@gmail.com',
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
