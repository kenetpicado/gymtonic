<?php

namespace App\Http\Controllers\dashboard;

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
}
