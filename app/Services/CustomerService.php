<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Income;
use App\Models\Plan;
use App\Models\Service;

class CustomerService
{
    public function index($request): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Customer::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%" . $search . "%");
            })
            ->addSelect([
                'active_plans' => Plan::selectRaw('count(*)')
                    ->whereColumn('customer_id', 'customers.id')
                    ->where('end_date', '>', now()),
            ])
            ->orderByDesc('id')
            ->paginate(20);
    }

    public function create(): array
    {
        return [
            'services' => Service::with('prices')->get(['id', 'name']),
        ];
    }

    public function show(Customer $customer): array
    {
        $customer->load('weights');

        return [
            'customer' => $customer,
        ];
    }

    public function store(array $request): void
    {
        $customer = Customer::create($request);
        $customer->plan()->create((new PlanService)->createInstance($request));
    }

    public function edit($customer): array
    {
        $customer->load('plan');

        return [
            'customer' => $customer,
            'isNew' => false,
            'services' => Service::with('prices')->get(['id', 'name']),
        ];
    }

    public function update(array $request, $customer): void
    {
        $customer->update($request);

        $plan = Plan::where('customer_id', $customer->id)->first();

        if (!$plan) {
            Plan::create((new PlanService)->createInstance($request) + ['customer_id' => $customer->id]);
        } else {
            $plan->update((new PlanService)->createInstance($request));
            $income = $customer->incomes()->latest()->first();

            if ($income) {
                $income->update([
                    'amount' => $plan->amount,
                    'discount' => $plan->discount,
                    'description' => $plan->service()->value('name') . ', ' . $plan->period . ' dia(s)',
                ]);
            }
        }
    }
}
