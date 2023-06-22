<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class ExtendPlanController extends Controller
{
    public function __invoke(Request $request)
    {
        $plansCollection = collect($request);

        $plans = Plan::whereIn('id', $plansCollection->pluck('id'))->get();

        foreach ($plans as $plan) {
            $plan->update([
                'end_date' => $plansCollection->where('id', $plan->id)->value('end_date')
            ]);
        }

        return back();
    }
}
