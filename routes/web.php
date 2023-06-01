<?php

use App\Http\Controllers\dashboard\CustomerController;
use App\Http\Controllers\dashboard\EmployeeController;
use App\Http\Controllers\dashboard\ExtendPlanController;
use App\Http\Controllers\dashboard\IncomeController;
use App\Http\Controllers\dashboard\PlanController;
use App\Http\Controllers\dashboard\ServiceController;
use App\Http\Controllers\dashboard\WeightController;
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

Route::redirect('/', '/dashboard/customers');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('services', ServiceController::class)->only(['index', 'store', 'update']);
        Route::resource('plans', PlanController::class);
        Route::resource('weights', WeightController::class)->only(['store', 'update', 'destroy']);
        Route::put('extend-plan', ExtendPlanController::class)->name('extend-plan');
        Route::resource('employees', EmployeeController::class);
        Route::resource('incomes', IncomeController::class);
    });
