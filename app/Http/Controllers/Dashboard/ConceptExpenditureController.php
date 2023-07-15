<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class ConceptExpenditureController extends Controller
{
    public function __invoke(Concept $concept)
    {
        return inertia('Concepts/Expenditures/Index', [
            'concept' => $concept,
            'expenditures' => $concept->expenditures()->orderBy('id', 'desc')->paginate(10),
        ]);
    }
}
