<?php

namespace App\Observers;

use App\Models\Income;
use App\Models\Plan;

class PlanObserver
{
    public function created(Plan $plan)
    {
        Income::create([
            'value' => $plan->price,
            'discount' => $plan->discount,
            'concept' => 'Pago de plan',
            'description' => $plan->service()->value('name') . ', ' . $plan->period . ' dia(s)',
            'incomeable_id' => $plan->customer_id,
            'incomeable_type' => 'App\Models\Customer',
        ]);
    }
}
