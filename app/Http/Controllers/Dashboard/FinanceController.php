<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
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
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('incomeable', fn ($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->whereBetween('created_at', [$from, $to])
                ->with('incomeable:id,name')
                ->paginate();
        } else {
            $finances = Expenditure::orderBy('id', 'desc')
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('expenditureable', fn ($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->whereBetween('created_at', [$from, $to])
                ->with('expenditureable:id,name')
                ->paginate();
        }

        return inertia('Finances/Index', [
            'type' => $type,
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
