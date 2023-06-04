<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class IncomeHistoryController extends Controller
{
    public function __invoke(Customer $customer)
    {
        return inertia('Customers/History', [
            'customer' => $customer->load('incomes'),
        ]);
    }
}
