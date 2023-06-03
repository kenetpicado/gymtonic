<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return inertia('Incomes/Index', [
            'incomes' => Income::orderBy('id','desc')->with('incomeable')->paginate(20)
        ]);
    }

    public function create()
    {
        return inertia('Incomes/Create');
    }

    public function store(IncomeRequest $request)
    {
        Income::create($request->validated());

        return back();
    }
}
