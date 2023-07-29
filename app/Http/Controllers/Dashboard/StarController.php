<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Star;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function __invoke(Request $request, $customer)
    {
        $starts = Star::firstOrNew([
            'customer_id' => $customer,
        ]);

        $starts->value = $starts->value + $request->value;
        $starts->save();

        return back();
    }
}
