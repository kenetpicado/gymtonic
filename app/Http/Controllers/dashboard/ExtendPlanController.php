<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExtendPlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class ExtendPlanController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        // Extrae los IDs de los registros para utilizarlos en la cláusula WHERE
        $ids = array_column($data, 'id');

        // Actualiza los registros en una sola consulta
        Plan::whereIn('id', $ids)->update($data, ['id', 'end_date']);

        // $plans = Plan::whereIn('id', $request->get('plan_ids'))->get();

        // foreach ($plans as $plan) {
        //     $plan->update([
        //         'end_date' => $plan->end_date->addDays($request->get('days')),
        //     ]);
        // }

        return back();
    }
}
