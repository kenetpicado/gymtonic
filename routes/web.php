<?php

use App\Http\Controllers\Dashboard\ConceptController;
use App\Http\Controllers\Dashboard\ConceptExpenditureController;
use App\Http\Controllers\Dashboard\ConceptIncomeController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\CustomerWeightController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\ExpenditureController;
use App\Http\Controllers\Dashboard\ExtendPlanController;
use App\Http\Controllers\Dashboard\FinanceController;
use App\Http\Controllers\Dashboard\IncomeController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('', DashboardController::class)
            ->name('index');

        Route::resource('customers', CustomerController::class)
            ->except(['destroy']);

        Route::resource('customers.weights', CustomerWeightController::class)
            ->except(['show', 'create', 'edit']);

        Route::resource('services', ServiceController::class)
            ->only(['index', 'store', 'update']);

        Route::resource('plans', PlanController::class)
            ->only(['index', 'edit', 'update']);

        Route::put('plans-extend', ExtendPlanController::class)
            ->name('plans.extend');

        Route::resource('employees', EmployeeController::class)
            ->except(['destroy', 'create', 'edit']);

        Route::get('finances/{type}', [FinanceController::class, 'index'])
            ->name('finances.index');

        Route::get('finances/{type}/create', [FinanceController::class, 'create'])
            ->name('finances.create');

        Route::resource('incomes', IncomeController::class)
            ->only(['store', 'update']);

        Route::resource('expenditures', ExpenditureController::class)
            ->only(['store', 'update', 'destroy']);

        Route::resource('concepts', ConceptController::class)
            ->only(['index', 'store', 'udpate']);

        Route::get('concepts/{concept}/expenditures', ConceptExpenditureController::class)
            ->name('concepts.expenditures.index');

        Route::resource('concepts.incomes', ConceptIncomeController::class)
            ->only(['index']);

        Route::resource('users', UserController::class)
            ->only(['index', 'store', 'update']);
    });
