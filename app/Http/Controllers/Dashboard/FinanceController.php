<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Expenditure;
use App\Models\Income;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request, $type)
    {
        if ($type == 'incomes') {
            $finances = Income::orderBy('id', 'desc')
                ->when($request->search, function($query) use ($request) {
                    $query->whereHas('incomeable', fn($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->when($request->from, function($query) use ($request) {
                    $query->where('created_at', '>=', $request->from);
                })
                ->when($request->to, function($query) use ($request) {
                    $query->where('created_at', '<=', $request->to);
                })
                ->with('incomeable:id,name')
                ->paginate(10);
        } else {
            $finances = Expenditure::orderBy('id', 'desc')
                ->when($request->search, function($query) use ($request) {
                    $query->whereHas('expenditureable', fn($query) => $query->where('name', 'like', "%{$request->search}%"));
                })
                ->when($request->from, function($query) use ($request) {
                    $query->where('created_at', '>=', $request->from);
                })
                ->when($request->to, function($query) use ($request) {
                    $query->where('created_at', '<=', $request->to);
                })
                ->with('expenditureable:id,name')
                ->paginate(10);
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
}
