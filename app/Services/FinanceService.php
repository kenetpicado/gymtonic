<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Customer;
use App\Models\Expenditure;
use App\Models\Income;

class FinanceService
{
    public function getFinanceInformation(array $request)
    {
        if ($request['type'] == 'incomes') {
            $model = new Income();
            $morph = "incomeable";
        } else {
            $model = new Expenditure();
            $morph = "expenditureable";
        }

        $queryBase = $model->query()
            ->when(isset($request['search']), fn($q) => $q->search($request['search']))
            ->when(isset($request['from']), fn ($query) => $query->whereDate('created_at', '>=', $request['from']))
            ->when(isset($request['to']), fn ($query) => $query->whereDate('created_at', '<=', $request['to']));

        $finances = (clone $queryBase)->latest('id')->with("{$morph}:id,name")->paginate();

        $total = (clone $queryBase)->selectRaw('sum(value * quantity) as amount')->value('amount') ?? 0;

        $plans_total = (clone $queryBase)->where("{$morph}_type", Customer::class)->count();

        $concepts = (clone $queryBase)->where("{$morph}_type", Concept::class)
            ->selectRaw("count(*) as total, {$morph}_id, MAX({$morph}_type) as {$morph}_type")
            ->groupBy("{$morph}_id")
            ->with("{$morph}:id,name")
            ->get();

        return [
            'type' => $request['type'],
            'total' => $total,
            'plans' => $plans_total,
            'concepts' => $concepts ?? [],
            'data' => $finances,
        ];
    }
}
