<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function __invoke(Request $request)
    {
        $incomes = DB::table('incomes')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->whereYear('created_at', 2023)
            ->when($request->model_id, function($query) use ($request) {
                $query->where('incomeable_type', 'App\Models\Concept')->where('incomeable_id', $request->model_id);
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $expenditures = DB::table('expenditures')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->whereYear('created_at', 2023)
            ->when($request->model_id, function($query) use ($request) {
                $query->where('expenditureable_type', 'App\Models\Concept')->where('expenditureable_id', $request->model_id);
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $concepts = Concept::orderby('name')->get(['id', 'name']);

        return inertia('Summary/Index', [
            'incomes' => $incomes,
            'expenditures' => $expenditures,
            'concepts' => $concepts
        ]);
    }
}
