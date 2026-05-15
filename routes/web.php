<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryStructureController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeePortalController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('salary-structures', SalaryStructureController::class);

    Route::resource('payroll', PayrollController::class);
    Route::post('payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');

    Route::get('payslip/{payroll}/download', [PayslipController::class, 'download'])->name('payslip.download');
    Route::get('payslip/{payroll}/preview', [PayslipController::class, 'preview'])->name('payslip.preview');

    Route::post('transactions/bulk-pay', [PaymentTransactionController::class, 'bulkPay'])->name('transactions.bulk-pay');
    Route::resource('transactions', PaymentTransactionController::class);
    Route::post('transactions/{transaction}/retry', [PaymentTransactionController::class, 'retry'])->name('transactions.retry');
    Route::get('transactions/{transaction}/receipt', [PaymentTransactionController::class, 'receipt'])->name('transactions.receipt');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('my-portal', [EmployeePortalController::class, 'index'])->name('portal.index');

});