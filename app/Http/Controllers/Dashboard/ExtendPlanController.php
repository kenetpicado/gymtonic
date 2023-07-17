<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;

class ExtendPlanController extends Controller
{
    public function __invoke(Request $request)
    {
        PlanService::extend($request);

        return back();
    }
}
