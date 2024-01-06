<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function index(): array
    {
        $firstDayOfMonth = now()->firstOfMonth()->format('Y-m-d');

        return [
            'incomes_month' => DB::table('incomes')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->select(DB::raw('COALESCE(SUM(value * quantity), 0) as total, COALESCE(SUM(discount), 0) as discount'))
                ->first(),

            'plans' => Plan::query()
                ->where('end_date', '>=', now()->format('Y-m-d'))
                ->groupBy('service_id')
                ->with('service:id,name')
                ->get(['service_id', DB::raw('count(*) as total')]),

            'expenditures_month' => DB::table('expenditures')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->select(DB::raw('COALESCE(SUM(value * quantity), 0)as total'))
                ->value('total'),

            'active_customers' => DB::table('customers')
                ->leftJoin('plans', 'customers.id', '=', 'plans.customer_id')
                ->where('plans.end_date', '>=', now()->format('Y-m-d'))
                ->groupBy('gender')
                ->get(['gender', DB::raw('count(*) as total')]),

            'customers_count' => DB::table('customers')->count(),
        ];
    }
}
