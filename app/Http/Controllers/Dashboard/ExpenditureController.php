<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenditureRequest;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        return inertia('Expenditures/Index', [
            'expenditures' => Expenditure::all()
        ]);
    }

    public function store(ExpenditureRequest $request)
    {
        Expenditure::create($request->validated());

        return back();
    }

    public function update(ExpenditureRequest $request, $expenditure_id)
    {
        Expenditure::where('id', $expenditure_id)->update($request->validated());

        return back();
    }
}
