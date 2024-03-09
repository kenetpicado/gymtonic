<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        return inertia('Employees/Index', [
            'employees' => Employee::orderBy('name')->get(['id', 'name', 'phone', 'schedule']),
        ]);
    }

    public function show(Employee $employee)
    {
        return inertia('Employees/Show', [
            'employee' => $employee,
            'payments' => $employee->payments()->paginate(),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated());

        return back();
    }

    public function update(EmployeeRequest $request, $employee)
    {
        Employee::where('id', $employee)->update($request->validated());

        return back();
    }
}
