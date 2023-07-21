<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function __invoke(PasswordRequest $request)
    {
        User::where('id', auth()->id())->update(['password' => Hash::make($request->password)]);

        return back();
    }
}
