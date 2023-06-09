<?php

namespace App\Http\Controllers\Dashboard;

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
        return inertia('Plans/Index', $this->planService->index($request));
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
