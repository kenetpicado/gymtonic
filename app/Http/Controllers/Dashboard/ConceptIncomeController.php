<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;

class ConceptIncomeController extends Controller
{
    public function index(Concept $concept)
    {
        return inertia('Concepts/Incomes/Index', [
            'concept' => $concept,
            'incomes' => $concept->incomes()->orderBy('id', 'desc')->paginate(10),
        ]);
    }
}
