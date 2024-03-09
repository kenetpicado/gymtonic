<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ConceptService;
use App\Services\SummaryService;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    private SummaryService $summaryService;
    private ConceptService $conceptService;

    public function __construct()
    {
        $this->summaryService = new SummaryService();
        $this->conceptService = new ConceptService();
    }

    public function __invoke(Request $request)
    {
        $data = $this->summaryService->getSummaryInformation($request->toArray());

        return inertia('Summary/Index', [
            'concepts' => $this->conceptService->getConceptNames(),
            'incomes' => $data['incomes'],
            'expenditures' => $data['expenditures'],
            'clients' => $data['clients'],
            'plans' => $data['plans'],
        ]);
    }
}
