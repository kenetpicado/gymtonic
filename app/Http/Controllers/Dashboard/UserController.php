<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return inertia('Users/Index', [
            'users' => User::where('role', '!=', 'root')->get(),
            'roles' => RoleEnum::cases()
        ]);
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated() + ['password' => Hash::make('Alonso#1234')]);

        return back();
    }

    public function update(UserRequest $request, $user)
    {
        User::where('id', $user)->update($request->validated());

        return back();
    }
}
