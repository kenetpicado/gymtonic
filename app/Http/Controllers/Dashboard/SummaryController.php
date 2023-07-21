<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function __invoke()
    {
        $incomes = DB::table('incomes')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->whereYear('created_at', 2023)
            // ->where('incomeable_type', 'App\Models\Concept')
            // ->where('incomeable_id', 4)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $expenditures = DB::table('expenditures')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->whereYear('created_at', 2023)
            // ->where('expenditureable_type', 'App\Models\Concept')
            // ->where('expenditureable_id', 4)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        return inertia('Summary/Index', [
            'incomes' => $incomes,
            'expenditures' => $expenditures,
        ]);
    }
}
