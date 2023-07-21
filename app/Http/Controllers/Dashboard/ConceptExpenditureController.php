<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;

class ConceptExpenditureController extends Controller
{
    public function __invoke(Concept $concept)
    {
        return inertia('Concepts/Expenditures/Index', [
            'concept' => $concept,
            'expenditures' => $concept->expenditures()->latest()->paginate(10),
        ]);
    }
}
