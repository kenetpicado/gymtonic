<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(
        private PlanService $planService
    )
    {
    }
    
    public function index(Request $request): \Inertia\Response
    {
        return inertia('Plans/Index', [
            'plans' => $this->planService->index($request),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
