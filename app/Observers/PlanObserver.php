<?php

namespace App\Observers;

use App\Models\Plan;
use Carbon\Carbon;

class PlanObserver
{
    public function created(Plan $plan)
    {
        $plan->customer->incomes()->create([
            'value' => $plan->price,
            'discount' => $plan->discount,
            'concept' => "Pago de plan: " . $plan->service()->value('name') . ', ' . $plan->period . ' dia(s)',
            'description' => "Periodo: " . Carbon::parse($plan->start_date)->format('d/m/Y') . ' al ' . Carbon::parse($plan->end_date)->format('d/m/Y'),
        ]);
    }
}
