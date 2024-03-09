<?php

namespace App\Services;

use App\Models\Star;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAdministrativeUsers()
    {
        return User::where('role', '!=', 'root')->get();
    }

    public function createUser(array $request)
    {
        User::create($request + ['password' => Hash::make('Alonso#1234')]);
    }

    public function updatePassword(string $password): void
    {
        auth()->user()->update(['password' => Hash::make($password)]);
    }

    public function addStars($customer_id, $value)
    {
        $stars = Star::firstOrNew([
            'customer_id' => $customer_id,
        ]);

        $stars->value = $stars->value + $value;
        $stars->save();

    }
}
