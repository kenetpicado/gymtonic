<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;

class ExpiredPlanController extends Controller
{
    public function __construct(
        private PlanService $planService
    ) {
    }

    public function __invoke(Request $request)
    {
        return inertia('Plans/Expired', $this->planService->index($request, 'expired'));
    }
}
