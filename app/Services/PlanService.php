<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Note;
use App\Models\Plan;
use App\Models\Service;
use Carbon\Carbon;

class PlanService
{
    public function index($request, $type = null): array
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
                    fn ($query) => $query->whereHas('customer', fn ($query) => $query->where('name', 'LIKE', '%' . $request->search . '%'))
                )
                ->when(
                    $type == 'expired',
                    fn ($query) => $query->where('end_date', '<', now()->format('Y-m-d'))->orderBy('end_date', 'desc'),
                    fn ($query) => $query->where('end_date', '>=', now()->format('Y-m-d'))->orderBy('end_date')
                )
                ->paginate(),
        ];
    }

    public function update(array $request, Customer $customer): void
    {
        $plan = $customer->plan;

        if ($plan) {
            $plan->update($request);

            $customer->incomes()->create([
                'value' => $plan->price,
                'discount' => $plan->discount,
                'concept' => "Pago de plan: " . $plan->service()->value('name') . ', ' . $plan->period . ' dia(s)',
                'description' => "Periodo: " . Carbon::parse($plan->start_date)->format('d/m/Y') . ' al ' . Carbon::parse($plan->end_date)->format('d/m/Y'),
            ]);
        } else {
            $customer->plan()->create($request);
        }

        if ($request['note'] && $request['save_note']) {
            Note::create([
                'text' => $customer->name . ': ' . $request['note'],
            ]);
        }
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
            'discount' => $request['discount'] ?? 0,
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
