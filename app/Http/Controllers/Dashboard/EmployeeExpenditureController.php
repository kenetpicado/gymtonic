<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeExpenditureController extends Controller
{
    public function index(Employee $employee)
    {
        return inertia('Employees/Expenditures/Index', [
            'employee' => $employee,
            'payments' => $employee->payments()->paginate(10),
        ]);
    }
}
