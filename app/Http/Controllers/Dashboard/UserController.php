<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        return inertia('Users/Index', [
            'users' => $this->userService->getAdministrativeUsers(),
            'roles' => RoleEnum::cases()
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->userService->createUser($request->validated());

        return back();
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return back();
    }
}
