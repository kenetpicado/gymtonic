<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(
        private PlanService $planService
    ) {
    }

    public function index(Request $request): \Inertia\Response
    {
        return inertia('Plans/Index', [
            'plans' => $this->planService->index($request),
            'today' => now()->format('Y-m-d'),
        ]);
    }

    public function edit(Plan $plan)
    {
        return inertia('Plans/Edit', $this->planService->edit($plan));
    }
}
