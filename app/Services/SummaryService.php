<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SummaryService
{
    public function getSummaryInformation(array $request): array
    {
        $incomes = DB::table('incomes')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->when(
                isset($request['year']),
                fn ($query) => $query->whereYear('created_at', $request['year']),
                fn ($query) => $query->whereYear('created_at', Carbon::now()->year),
            )
            ->when(isset($request['model_id']), function ($query) use ($request) {
                $query->when(
                    $request['model_id'] == 'plans',
                    fn ($query) => $query->where('incomeable_type', Customer::class),
                    fn ($query) => $query->where('incomeable_type', Concept::class)->where('incomeable_id', $request['model_id'])
                );
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $expenditures = DB::table('expenditures')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->when(
                isset($request['year']),
                fn ($query) => $query->whereYear('created_at', $request['year']),
                fn ($query) => $query->whereYear('created_at', Carbon::now()->year),
            )
            ->when(isset($request['model_id']), function ($query) use ($request) {
                $query->when(
                    $request['model_id'] == 'plans',
                    fn ($query) => $query->where('expenditureable_type', Customer::class),
                    fn ($query) => $query->where('expenditureable_type', Concept::class)->where('expenditureable_id', $request['model_id'])
                );
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $clients = DB::table('customers')
            ->select(DB::raw("MONTH(created_at) as month, count(*) as total"))
            ->when(
                isset($request['year']),
                fn ($query) => $query->whereYear('created_at', $request['year']),
                fn ($query) => $query->whereYear('created_at', Carbon::now()->year),
            )
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $plans = DB::table('plans')
            ->select(DB::raw("MONTH(updated_at) as month, count(*) as total"))
            ->when(
                isset($request['year']),
                fn ($query) => $query->whereYear('updated_at', $request['year']),
                fn ($query) => $query->whereYear('updated_at', Carbon::now()->year),
            )
            ->groupByRaw('MONTH(updated_at)')
            ->orderBy('month')
            ->get();

        return [
            'incomes' => $incomes,
            'expenditures' => $expenditures,
            'clients' => $clients,
            'plans' => $plans,
        ];
    }
}
