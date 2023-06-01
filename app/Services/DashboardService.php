<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function index()
    {
        $firstDayOfMonth = now()->firstOfMonth()->format('Y-m-d');

        return [
            'plans_count' => DB::table('plans')->where('end_date', '>=', now()->format('Y-m-d'))->count(),

            'incomes_month' => DB::table('incomes')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->select(DB::raw('SUM(amount * quantity) as total, SUM(discount) as discount'))
                ->first(),

            'expenditures_month' => DB::table('expenditures')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->select(DB::raw('SUM(amount * quantity) as total'))
                ->value('total'),

            'customers' => DB::table('customers')->groupBy('gender')->orderBy('total', 'desc')->get(['gender', DB::raw('count(*) as total')])
        ];
    }
}
