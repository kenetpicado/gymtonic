<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Models\Concept;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return inertia('Incomes/Index', [
            'incomes' => Income::orderBy('id','desc')->with('incomeable:id,name')->paginate(10)
        ]);
    }

    public function create()
    {
        return inertia('Incomes/Create', [
            'concepts' => Concept::all(['id', 'name'])
        ]);
    }

    public function store(IncomeRequest $request)
    {
        Income::create($request->validated());

        return back();
    }

    public function update(IncomeRequest $request, Income $income)
    {
        $income->update($request->validated());

        return back();
    }
}
