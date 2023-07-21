<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConceptRequest;
use App\Models\Concept;

class ConceptController extends Controller
{
    public function index()
    {
        $concept = Concept::query()
            ->with('lastExpenditure')
            ->orderBy('name')
            ->paginate();

        return inertia('Concepts/Index', [
            'concepts' => $concept,
        ]);
    }

    public function store(ConceptRequest $request)
    {
        Concept::create($request->validated());

        return back();
    }

    public function update(ConceptRequest $request, $concept)
    {
        Concept::where('id', $concept)->update($request->validated());

        return back();
    }
}
