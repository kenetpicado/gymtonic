<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Income;
use App\Models\Plan;
use App\Models\Service;

class PlanService
{
    public function index($request): array
    {
        return [
            'plans' => Plan::query()
                ->addSelect([
                    'service_name' => Service::select('name')
                        ->whereColumn('id', 'plans.service_id')
                        ->limit(1),
                    'customer_name' => Customer::select('name')
                        ->whereColumn('id', 'plans.customer_id')
                        ->limit(1),
                ])
                ->when(
                    $request->search,
                    fn ($query) => $query->whereHas('customer', fn ($query) => $query->where('name', 'LIKE', '%'.$request->search.'%'))
                )
                ->when(
                    $request->type == 'expired',
                    fn ($query) => $query->where('end_date', '<', now()->format('Y-m-d'))->orderBy('end_date', 'desc'),
                    fn ($query) => $query->where('end_date', '>=', now()->format('Y-m-d'))->orderBy('end_date')
                )
                ->paginate(10),
        ];
    }

    public function edit($plan): array
    {
        return [
            'services' => Service::with('prices')->get(['id', 'name']),
            'plan' => $plan->load('customer'),
            'isCurrentActive' => $plan->end_date >= now()->format('Y-m-d'),
        ];
    }

    public function update(array $request, Plan $plan): void
    {
        $plan->update($request);

        Income::create([
            'value' => $plan->price,
            'discount' => $plan->discount,
            'concept' => 'Pago de plan',
            'description' => $plan->service()->value('name').', '.$plan->period.' dia(s)',
            'incomeable_id' => $plan->customer_id,
            'incomeable_type' => 'App\Models\Customer',
        ]);
    }

    public static function updateOrCreate($request): Plan
    {
        return Plan::updateOrCreate([
            'customer_id' => $request['customer_id'],
        ], [
            'period' => $request['period'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'price' => $request['price'],
            'discount' => $request['discount'],
            'note' => $request['note'],
            'service_id' => $request['service_id'],
        ]);
    }

    public static function extend($request): void
    {
        $requestCollection = collect($request);

        $plans = Plan::whereIn('id', $requestCollection->pluck('id'))->get(['id', 'end_date']);

        foreach ($plans as $plan) {
            $plan->update([
                'end_date' => $requestCollection->where('id', $plan->id)->value('end_date'),
            ]);
        }
    }
}
