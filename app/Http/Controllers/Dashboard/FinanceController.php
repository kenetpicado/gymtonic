<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Customer;
use App\Models\Expenditure;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request, $type)
    {
        $from = ($request->from ?? Carbon::now()->format('Y-m-d')) . " 00:00:00";
        $to = ($request->to ?? Carbon::now()->format('Y-m-d')) . " 23:59:59";

        if ($type == 'incomes') {
            $finances = Income::orderBy('id', 'desc')
                ->searchIncomeable($request)
                ->whereBetween('created_at', [$from, $to])
                ->with('incomeable:id,name')
                ->paginate();
            $total = Income::query()
                ->searchIncomeable($request)
                ->selectRaw('sum(value * quantity) as amount')
                ->whereBetween('created_at', [$from, $to])
                ->first()?->amount ?? 0;
            $plans_total = Income::query()
                ->searchIncomeable($request)
                ->where('incomeable_type', Customer::class)
                ->whereBetween('created_at', [$from, $to])
                ->count();

            $concepts = Income::query()
                ->searchIncomeable($request)
                ->where('incomeable_type', Concept::class)
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('incomeable_id')
                ->selectRaw('count(*) as total, incomeable_id, MAX(incomeable_type) as incomeable_type')
                ->with('incomeable:id,name')
                ->get();

        } else {
            $finances = Expenditure::orderBy('id', 'desc')
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('expenditureable', fn ($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->whereBetween('created_at', [$from, $to])
                ->with('expenditureable:id,name')
                ->paginate();
            $total = Expenditure::query()
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('expenditureable', fn ($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->selectRaw('sum(value * quantity) as amount')
                ->whereBetween('created_at', [$from, $to])
                ->first()?->amount ?? 0;
            $plans_total = Expenditure::query()
                ->where('expenditureable_type', Customer::class)
                ->whereBetween('created_at', [$from, $to])
                ->count();

            $concepts = Expenditure::query()
                ->where('expenditureable_type', Concept::class)
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('expenditureable_id')
                ->selectRaw('count(*) as total, expenditureable_id, MAX(expenditureable_type) as expenditureable_type')
                ->with('expenditureable:id,name')
                ->get();
        }

        return inertia('Finances/Index', [
            'type' => $type,
            'total' => $total,
            'plans_total' => $plans_total,
            'concepts' => $concepts ?? [],
            'finances' => $finances,
        ]);
    }

    public function create($type)
    {
        if ($type == 'incomes') {
            $concepts = Concept::where('has_income', true)->get(['id', 'name']);
        } else {
            $concepts = Concept::where('has_expenditure', true)->get(['id', 'name']);
        }

        return inertia('Finances/Create', [
            'type' => $type,
            'concepts' => $concepts,
        ]);
    }

    public function destroy(Request $request, $type)
    {
        DB::table($type)->where('id', $request->id)->delete();

        return back();
    }
}
