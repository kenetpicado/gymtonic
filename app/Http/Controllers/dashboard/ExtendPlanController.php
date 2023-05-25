<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExtendPlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class ExtendPlanController extends Controller
{
    public function __invoke(ExtendPlanRequest $request)
    {
        $plans = Plan::whereIn('id', $request->get('plan_ids'))->get();

        foreach ($plans as $plan) {
            $plan->update([
                'end_date' => $plan->end_date->addDays($request->get('days')),
            ]);
        }

        return back();
    }
}
