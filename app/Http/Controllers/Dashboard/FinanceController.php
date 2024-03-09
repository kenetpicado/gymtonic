<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Services\FinanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    private FinanceService $financeService;

    public function __construct()
    {
        $this->financeService = new FinanceService();
    }

    public function index(Request $request)
    {
        if (!$request->get('type')) {
            return redirect()->route('dashboard.finances.index', [
                'type' => 'incomes',
                'from' => Carbon::today()->format('Y-m-d'),
                'to' => Carbon::today()->format('Y-m-d'),
            ]);
        }

        $data = $this->financeService->getFinanceInformation($request->toArray());

        return inertia('Finances/Index', [
            'type' => $data['type'],
            'total' => $data['total'],
            'plans' => $data['plans'],
            'concepts' => $data['concepts'],
            'data' => $data['data'],
        ]);
    }

    public function create($type)
    {
        if ($type == 'incomes') {
            $concepts = Concept::where('has_income', true)->get(['id', 'name']);
        } else {
            $concepts = Concept::where('has_expenditure', true)->get(['id', 'name']);
        }

        return inertia('Finances/Create', [
            'type' => $type,
            'concepts' => $concepts,
        ]);
    }
}
