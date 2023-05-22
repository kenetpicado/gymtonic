<?php

namespace App\Services;

use App\Enums\PeriodEnum;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Price;
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
            ->paginate(10);
    }

    public function create(): array
    {
        return [
            'periods' => PeriodEnum::get(),
            'services' => Service::all(['id', 'name']),
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
            'periods' => PeriodEnum::get(),
            'services' => Service::all(['id', 'name']),
        ];
    }

    public function update(array $request, $customer): void
    {
        $customer->update($request);

        $customer->plan()->updateOrCreate((new PlanService)->createInstance($request));
    }
}
