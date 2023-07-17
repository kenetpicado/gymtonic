<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Expenditure;
use App\Models\Income;

class FinanceController extends Controller
{
    public function index($type)
    {
        if ($type == 'incomes') {
            $finances = Income::orderBy('id', 'desc')->with('incomeable:id,name')->paginate(10);
        } else {
            $finances = Expenditure::orderBy('id', 'desc')->with('expenditureable:id,name')->paginate(10);
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
