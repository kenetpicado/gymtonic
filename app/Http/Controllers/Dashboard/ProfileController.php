<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return inertia('Profile/Index');
    }

    public function store(ProfileRequest $request)
    {
        User::where('id', auth()->id())->update($request->validated());

        return back();
    }
}
