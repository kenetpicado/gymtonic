<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Note;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function getCustomers(array $request)
    {
        $now = Carbon::now()->format('Y-m-d 00:00:00');

        return DB::table('customers')
            ->when(isset($request['search']), fn ($query) => $query->where('name', 'like', "%{$request['search']}%"))
            ->leftJoin('stars', 'customers.id', '=', 'stars.customer_id')
            ->select(
                'customers.id',
                'name',
                'phone',
                'gender',
                'stars.value as stars',
                DB::raw("(SELECT COUNT(*) FROM plans WHERE customer_id = customers.id AND end_date >= '{$now}') as active_plans")
            )
            ->orderByDesc('id')
            ->paginate();
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

        if ($request['note'] && $request['save_note']) {
            Note::create([
                'text' => $customer->name . ': ' . $request['note'],
            ]);
        }

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

        if ($request['note'] && $request['save_note']) {
            Note::create([
                'text' => $customer->name . ': ' . $request['note'],
            ]);
        }

        $plan = PlanService::updateOrCreate($request + ['customer_id' => $customer->id]);

        $income = $customer->incomes()->latest()->first();

        if ($income) {
            $income->update([
                'value' => $plan->price,
                'discount' => $plan->discount,
                'description' => $plan->service()->value('name') . ', ' . $plan->period . ' dia(s)',
            ]);
        }
    }
}
