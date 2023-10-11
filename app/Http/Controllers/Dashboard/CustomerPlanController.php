<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Customer;
use App\Models\Service;
use App\Services\PlanService;
use Illuminate\Http\Request;

class CustomerPlanController extends Controller
{
    public function create(Customer $customer)
    {
        $plan = $customer->plan;

        if ($plan) {
            $isCurrentActive = $plan->end_date >= now()->format('Y-m-d');
        } else {
            $isCurrentActive = false;
        }

        return inertia('Customers/Plans/Create', [
            'customer' => $customer,
            'plan' => $plan,
            'services' => Service::with('prices')->get(['id', 'name']),
            'isCurrentActive' => $isCurrentActive,
        ]);
    }

    public function store(PlanRequest $request, Customer $customer)
    {
        (new PlanService)->update($request->validated(), $customer);

        return redirect()->route('dashboard.customers.index');
    }
}
