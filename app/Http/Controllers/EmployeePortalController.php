<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\SalaryStructure;


class EmployeePortalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)
            ->with(['department', 'salaryStructures'])
            ->first();

        if (!$employee) {
            return redirect()->route('profile.show')
                ->with('error', 'No employee profile found for your account. Please contact HR.');
        }

        $payrolls = PayrollRecord::where('employee_id', $employee->id)
            ->latest()
            ->get();

        $transactions = PaymentTransaction::where('employee_id', $employee->id)
            ->latest()
            ->get();

        $totalEarned = $transactions->where('status', 'success')->sum('amount');

        return view('portal.index', compact(
            'employee',
            'payrolls',
            'transactions',
            'totalEarned'
        ));
    }
}