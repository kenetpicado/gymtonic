<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Inertia\Response;

class PlanController extends Controller
{
    public function __construct(
        private PlanService $planService
    ) {
    }

    public function index(Request $request): Response
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

    public function update(PlanRequest $request, Plan $plan)
    {
        $this->planService->update($request->validated(), $plan);

        return redirect()->route('dashboard.plans.index');
    }
}
