<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
}
