<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function index(): array
    {
        $firstDayOfMonth = now()->firstOfMonth()->format('Y-m-d');

        return [
            'incomes_month' => DB::table('incomes')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->select(DB::raw('SUM(value * quantity) as total, SUM(discount) as discount'))
                ->first(),

            'plans' => DB::table('plans')
                ->where('end_date', '>=', now()->format('Y-m-d'))
                ->groupBy('service_id')
                ->get(['service_id', DB::raw('count(*) as total')]),

            'expenditures_month' => DB::table('expenditures')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->select(DB::raw('SUM(value * quantity) as total'))
                ->value('total'),

            'customers' => DB::table('customers')->groupBy('gender')->get(['gender', DB::raw('count(*) as total')])
        ];
    }
}
