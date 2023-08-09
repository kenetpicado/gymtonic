<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Expenditure;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request, $type)
    {
        $from = $request->from ?? date('Y-m-d');
        $to = $request->to ?? date('Y-m-d');

        if ($type == 'incomes') {
            $finances = Income::orderBy('id', 'desc')
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('incomeable', fn ($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->whereBetween('created_at', [$from  . " 00:00:00", $to . " 23:59:59"])
                ->with('incomeable:id,name')
                ->get();
        } else {
            $finances = Expenditure::orderBy('id', 'desc')
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('expenditureable', fn ($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"])
                ->with('expenditureable:id,name')
                ->get();
        }

        return inertia('Finances/Index', [
            'type' => $type,
            "from_date" => $from,
            "to_date" => $to,
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
