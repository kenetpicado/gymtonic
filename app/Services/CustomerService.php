<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Plan;
use App\Models\Service;
use Carbon\Carbon;

class CustomerService
{
    public function index($request)
    {
        return Customer::withCount('plan')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%" . $search . "%");
            })
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function create(): array
    {
        return [
            'periods' => (new Plan)->periods,
            'services' => Service::all(['id', 'name']),
        ];
    }

    public function show(Customer $customer)
    {
        $customer->load('weights');

        return [
            'customer' => $customer,
        ];
    }

    public function store(array $request): void
    {
        $customer = Customer::create($request);
        $start_date = Carbon::parse($request['start_date']);

        $request['end_date'] = match ($request['period']) {
            30 => $start_date->addMonth(1),
            default => $start_date->addDays($request['period']),
        };

        $customer->plan()->create($request);
    }

    public function edit($customer)
    {
        $customer->load('plan');

        return [
            'customer' => $customer,
            'isNew' => false,
            'periods' => (new Plan())->periods,
            'services' => Service::all(['id', 'name']),
        ];
    }
}
