<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConceptRequest;
use App\Models\Concept;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    public function index()
    {
        return inertia('Concepts/Index', [
            'concepts' => Concept::orderBy('name')->paginate()
        ]);
    }

    public function store(ConceptRequest $request)
    {
        Concept::create($request->validated());

        return back();
    }

    public function update(ConceptRequest $request, Concept $concept)
    {
        $concept->update($request->validated());

        return back();
    }
}
