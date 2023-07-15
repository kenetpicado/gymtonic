<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Models\Concept;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function store(IncomeRequest $request)
    {
        Income::create($request->validated());

        return back();
    }

    public function update(IncomeRequest $request, $income)
    {
        Income::where('id', $income)->update($request->validated());

        return back();
    }
}
