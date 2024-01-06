<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function __invoke(Request $request)
    {
        $incomes = DB::table('incomes')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->when($request->year, function($query) use ($request) {
                $query->whereYear('created_at', $request->year);
            }, function($query) {
                $query->whereYear('created_at', Carbon::now()->year);
            })
            ->when($request->model_id, function($query) use ($request) {
                $query->where('incomeable_type', 'App\Models\Concept')->where('incomeable_id', $request->model_id);
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $expenditures = DB::table('expenditures')
            ->select(DB::raw("MONTH(created_at) as month, sum(value * quantity) as total"))
            ->when($request->year, function($query) use ($request) {
                $query->whereYear('created_at', $request->year);
            }, function($query) {
                $query->whereYear('created_at', Carbon::now()->year);
            })
            ->when($request->model_id, function($query) use ($request) {
                $query->where('expenditureable_type', 'App\Models\Concept')->where('expenditureable_id', $request->model_id);
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $clients = DB::table('customers')
            ->select(DB::raw("MONTH(created_at) as month, count(*) as total"))
            ->when($request->year, function($query) use ($request) {
                $query->whereYear('created_at', $request->year);
            }, function($query) {
                $query->whereYear('created_at', Carbon::now()->year);
            })
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $plans = DB::table('plans')
            ->select(DB::raw("MONTH(updated_at) as month, count(*) as total"))
            ->when($request->year, function($query) use ($request) {
                $query->whereYear('updated_at', $request->year);
            }, function($query) {
                $query->whereYear('updated_at', Carbon::now()->year);
            })
            ->groupByRaw('MONTH(updated_at)')
            ->orderBy('month')
            ->get();

        return inertia('Summary/Index', [
            'incomes' => $incomes,
            'expenditures' => $expenditures,
            'concepts' => Concept::orderby('name')->get(['id', 'name']),
            'clients' => $clients,
            'plans' => $plans,
        ]);
    }
}
