<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return inertia('Incomes/Index', [
            'incomes' => Income::orderBy('id','desc')->paginate(20)
        ]);
    }
}
