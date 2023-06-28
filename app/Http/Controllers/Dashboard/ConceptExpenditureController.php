<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class ConceptExpenditureController extends Controller
{
    public function index(Concept $concept)
    {
        return inertia('Concepts/Expenditures/Index', [
            'concept' => $concept,
            'expenditures' => $concept->expenditures()->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function store(Request $request, $concept)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:0',
            'concept' => 'required',
        ]);

        Expenditure::create($request->all());

        return back();
    }
}
