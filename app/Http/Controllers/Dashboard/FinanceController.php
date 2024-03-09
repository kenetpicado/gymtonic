<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Services\FinanceService;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    private FinanceService $financeService;

    public function __construct()
    {
        $this->financeService = new FinanceService();
    }

    public function index(Request $request)
    {
        $data = $this->financeService->getFinanceInformation($request->toArray());

        return inertia('Finances/Index', [
            'type' => $data['type'],
            'total' => $data['total'],
            'plans' => $data['plans'],
            'concepts' => $data['concepts'],
            'data' => $data['data'],
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Finances/Create', [
            'type' => $request->get('type'),
            'concepts' =>Concept::query()
                ->when($request->get('type') == 'incomes',
                    fn($query) => $query->where('has_income', true),
                    fn($query) => $query->where('has_expenditure', true),
                )
                ->get(['id', 'name']),
        ]);
    }
}
