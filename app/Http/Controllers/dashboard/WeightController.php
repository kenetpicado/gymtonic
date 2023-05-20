<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeightRequest;
use App\Models\Weight;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    public function store(WeightRequest $request)
    {
        Weight::create($request->validated());

        return redirect()->back();
    }
}
