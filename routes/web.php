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
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalaryRevisionController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\PaymentScheduleController;

// Home page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Smart redirect after login — routes users based on their role
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->get('/home', function () {
    $user = auth()->user();
    if ($user->hasRole(['super-admin', 'hr-manager', 'accountant'])) {
        return redirect('/dashboard');
    } elseif ($user->hasRole('employee')) {
        return redirect('/my-portal');
    }
    
    auth()->logout();
    return redirect('/login')->withErrors(['email' => 'Your account lacks permissions. Please contact an administrator.']);
})->name('redirect.home');


// =============================================================================
// ADMIN ROUTES
// Only super-admin, hr-manager, accountant can access these
// An employee hitting any of these URLs gets a 403 automatically
// =============================================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'role:super-admin|hr-manager|accountant',
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('departments', DepartmentController::class);

    Route::resource('employees', EmployeeController::class);

    Route::resource('salary-structures', SalaryStructureController::class);

    Route::resource('payroll', PayrollController::class);
    Route::post('payroll/generate', [PayrollController::class, 'generate'])
        ->name('payroll.generate');
    Route::post('payroll/{payroll}/pay', [PayrollController::class, 'pay'])
        ->name('payroll.pay');

    Route::get('payslip/{payroll}/download', [PayslipController::class, 'download'])
        ->name('payslip.download');
    Route::get('payslip/{payroll}/preview', [PayslipController::class, 'preview'])
        ->name('payslip.preview');

    Route::post('transactions/bulk-pay', [PaymentTransactionController::class, 'bulkPay'])
        ->name('transactions.bulk-pay');
    Route::get('transactions/{transaction}/checkout', [PaymentTransactionController::class, 'checkout'])
        ->name('transactions.checkout');
    Route::post('transactions/{transaction}/process-checkout', [PaymentTransactionController::class, 'processCheckout'])
        ->name('transactions.process-checkout');
    Route::resource('transactions', PaymentTransactionController::class);
    Route::post('transactions/{transaction}/retry', [PaymentTransactionController::class, 'retry'])
        ->name('transactions.retry');
    Route::get('transactions/{transaction}/receipt', [PaymentTransactionController::class, 'receipt'])
        ->name('transactions.receipt');

    Route::get('reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // Leave Management (admin side)
    Route::get('leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('leave/{leave}', [LeaveController::class, 'show'])->name('leave.show');
    Route::post('leave/{leave}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('leave/{leave}/reject', [LeaveController::class, 'reject'])->name('leave.reject');

    // Salary Revision History
    Route::get('salary-revisions', [SalaryRevisionController::class, 'index'])->name('salary-revisions.index');
    Route::get('salary-revisions/{employee}', [SalaryRevisionController::class, 'show'])->name('salary-revisions.show');

    // Employee Documents
    Route::get('employees/{employee}/documents', [EmployeeDocumentController::class, 'index'])->name('employee-documents.index');
    Route::post('employees/{employee}/documents', [EmployeeDocumentController::class, 'store'])->name('employee-documents.store');
    Route::get('employee-documents/{document}/download', [EmployeeDocumentController::class, 'download'])->name('employee-documents.download');
    Route::delete('employee-documents/{document}', [EmployeeDocumentController::class, 'destroy'])->name('employee-documents.destroy');

    // Payment Schedules
    Route::get('payment-schedules', [PaymentScheduleController::class, 'index'])->name('payment-schedules.index');
    Route::post('payment-schedules', [PaymentScheduleController::class, 'store'])->name('payment-schedules.store');
    Route::put('payment-schedules/{paymentSchedule}', [PaymentScheduleController::class, 'update'])->name('payment-schedules.update');
    Route::delete('payment-schedules/{paymentSchedule}', [PaymentScheduleController::class, 'destroy'])->name('payment-schedules.destroy');
    Route::post('payment-schedules/{paymentSchedule}/run-now', [PaymentScheduleController::class, 'runNow'])->name('payment-schedules.run-now');
});


// =============================================================================
// EMPLOYEE ROUTES
// Only users with the 'employee' role can access these
// An admin hitting /my-portal gets a 403 automatically
// =============================================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'role:employee',
])->group(function () {

    Route::get('my-portal', [EmployeePortalController::class, 'index'])
        ->name('portal.index');

    Route::get('my-payslip/{payroll}/download', [PayslipController::class, 'downloadOwn'])
        ->name('payslip.download.own');

    Route::get('my-transactions/{transaction}/receipt', [PaymentTransactionController::class, 'receiptOwn'])
        ->name('transactions.receipt.own');

    // Leave (employee side)
    Route::get('my-leaves', [LeaveController::class, 'myLeaves'])->name('leave.my-leaves');
    Route::get('apply-leave', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('apply-leave', [LeaveController::class, 'store'])->name('leave.store');

    // Document download (employee own)
    Route::get('my-documents/{document}/download', [EmployeeDocumentController::class, 'download'])->name('employee-documents.download.own');
});