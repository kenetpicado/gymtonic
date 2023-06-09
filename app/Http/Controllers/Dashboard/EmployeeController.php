<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return inertia('Employees/Index', [
            'employees' => Employee::all(['id', 'name', 'phone', 'schedule']),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect()->route('dashboard.employees.index');
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect()->route('dashboard.employees.index');
    }
}
