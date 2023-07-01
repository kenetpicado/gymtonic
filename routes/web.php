<?php

use App\Http\Controllers\Dashboard\ConceptController;
use App\Http\Controllers\Dashboard\ConceptExpenditureController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\CustomerWeightController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\ExpenditureController;
use App\Http\Controllers\Dashboard\ExtendPlanController;
use App\Http\Controllers\Dashboard\IncomeController;
use App\Http\Controllers\Dashboard\IncomeHistoryController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\ServiceController;
use Illuminate\Foundation\Application;
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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('', DashboardController::class)->name('index');

        Route::resource('customers', CustomerController::class)->except(['show', 'destroy']);

        Route::resource('customers.weights', CustomerWeightController::class)->except(['show', 'create']);

        Route::get('customers/{customer}/history', IncomeHistoryController::class)->name('customers.history');

        Route::resource('services', ServiceController::class)->only(['index', 'store', 'update']);

        Route::resource('plans', PlanController::class);

        Route::put('plans-extend', ExtendPlanController::class)->name('plans.extend');

        Route::resource('employees', EmployeeController::class);

        Route::resource('incomes', IncomeController::class);

        Route::resource('expenditures', ExpenditureController::class);

        Route::resource('concepts', ConceptController::class);

        Route::resource('concepts.expenditures', ConceptExpenditureController::class)->only(['index']);
    });
