<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConceptRequest;
use App\Models\Concept;
use App\Services\ConceptService;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    private ConceptService $conceptService;

    public function __construct()
    {
        $this->conceptService = new ConceptService();
    }

    public function index()
    {
        return inertia('Concepts/Index', [
            'concepts' => $this->conceptService->getConcepts(),
        ]);
    }

    public function show(Request $request, Concept $concept)
    {
        $type = $request->get('type', 'incomes');

        return inertia('Concepts/Show', [
            'concept' => $concept,
            'type' => $type,
            'records' => $this->conceptService->getTypeRecords($concept, $type)
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
