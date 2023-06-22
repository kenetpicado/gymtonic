<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeightRequest;
use App\Models\Customer;
use App\Models\Weight;
use Illuminate\Http\Request;

class CustomerWeightController extends Controller
{
    public function index(Customer $customer)
    {
        return inertia('Customers/Weights/Index', [
            'customer' => $customer->load('weights')
        ]);
    }

    public function store(WeightRequest $request, $customer)
    {
        Weight::create($request->validated() + ['customer_id' => $customer]);

        return back();
    }

    public function update(WeightRequest $request, $customer, Weight $weight)
    {
        $weight->update($request->validated());

        return back();
    }

    public function destroy($customer, Weight $weight)
    {
        $weight->delete();

        return back();
    }
}
