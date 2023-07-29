<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function index($request): array
    {
        return [
            'customers' => DB::table('customers')
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->leftJoin('stars', 'customers.id', '=', 'stars.customer_id')
                ->select(
                    'customers.id',
                    'name',
                    'phone',
                    'gender',
                    'stars.value as stars',
                    DB::raw('(SELECT COUNT(*) FROM plans WHERE customer_id = customers.id AND end_date >= NOW()) as active_plans')
                )
                ->orderByDesc('id')
                ->paginate(10),
        ];
    }

    public function create(): array
    {
        return [
            'services' => Service::with('prices')->get(['id', 'name']),
        ];
    }

    public function show(Customer $customer): array
    {
        return [
            'customer' => $customer->load('weights'),
        ];
    }

    public function store(array $request): void
    {
        $customer = Customer::create($request);

        PlanService::updateOrCreate($request + ['customer_id' => $customer->id]);
    }

    public function edit($customer): array
    {
        return [
            'customer' => $customer->load('plan'),
            'isNew' => false,
            'services' => Service::with('prices')->get(['id', 'name']),
        ];
    }

    public function update(array $request, $customer): void
    {
        $customer->update($request);

        $plan = PlanService::updateOrCreate($request + ['customer_id' => $customer->id]);

        $income = $customer->incomes()->latest()->first();

        if ($income) {
            $income->update([
                'value' => $plan->price,
                'discount' => $plan->discount,
                'description' => $plan->service()->value('name').', '.$plan->period.' dia(s)',
            ]);
        }
    }
}
