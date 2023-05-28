<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Service;
use Carbon\Carbon;

class PlanService
{
    public function index($request)
    {
        return Plan::with(['customer', 'service'])
            ->when(
                $request->search,
                fn ($query) => $query->whereHas('customer', fn ($query) => $query->where('name', 'LIKE', "%" . $request->search . "%"))
            )
            ->when(
                $request->type == 'expired',
                fn ($query) => $query->where('end_date', '<', now()->format('Y-m-d'))->orderBy('end_date', 'desc'),
                fn ($query) => $query->where('end_date', '>=', now()->format('Y-m-d'))->orderBy('end_date')
            )
            ->paginate(10);
    }

    public function edit($plan)
    {
        return [
            'services' => Service::with('prices')->get(['id', 'name']),
            'plan' => $plan->load('customer'),
            'isCurrentActive' => $plan->end_date >= now()->format('Y-m-d'),
        ];
    }

    public function createInstance($request): array
    {
        return [
            'period' => $request['period'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'amount' => $request['amount'],
            'discount' => $request['discount'],
            'note' => $request['note'],
            'service_id' => $request['service_id'],
        ];
    }
}
