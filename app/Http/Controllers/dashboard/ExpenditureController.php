<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        return inertia('Expenditures/Index', [
            'expenditures' => Expenditure::all()
        ]);
    }
}
