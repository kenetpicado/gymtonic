<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Star;
use App\Services\UserService;
use Illuminate\Http\Request;

class StarController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function __invoke(Request $request, $customer)
    {
        $this->userService->addStars($customer, $request->get('value'));

        return back();
    }
}
