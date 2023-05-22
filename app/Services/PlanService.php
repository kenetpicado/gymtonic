<?php

namespace App\Services;

use App\Models\Plan;
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
                fn ($query) => $query->where('end_date', '<=', now()),
                fn ($query) => $query->where('end_date', '>', now())
            )
            ->orderBy('end_date')
            ->paginate(10);
    }

    public function createInstance($request): array
    {
        $start_date = Carbon::create($request['start_date']);

        $request['end_date'] = $request['period'] == '30'
            ? $start_date->addMonth()->format('Y-m-d')
            : $start_date->addDays($request['period'])->format('Y-m-d');

        if ($request['discount'] > 0) {
            $request['amount'] = $request['amount'] - $request['discount'];
        }

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
