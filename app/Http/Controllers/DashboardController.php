<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $pendingPayrolls = PayrollRecord::where('status', 'pending')->count();
        $paidThisMonth = PayrollRecord::where('status', 'paid')
            ->whereMonth('created_at', now()->month)->count();
        $monthlyPayroll = PayrollRecord::whereMonth('created_at', now()->month)
            ->sum('net_salary');
        $recentEmployees = Employee::with(['user', 'department'])
            ->latest()->take(5)->get();
        $recentPayrolls = PayrollRecord::with('employee.user')
            ->latest()->take(5)->get();
        
        $departments = Department::withCount('employees')
            ->get()
            ->groupBy('name')
            ->map(function ($group) {
                $item = $group->first();
                $item->employees_count = $group->sum('employees_count');
                return $item;
            })->values();

        $totalPF = PayrollRecord::sum('pf');
        $totalESI = PayrollRecord::sum('esi');
        $totalTDS = PayrollRecord::sum('tds');
        $totalGross = PayrollRecord::sum('gross');
        $totalNet = PayrollRecord::sum('net_salary');

        $totalPaid = PaymentTransaction::where('status', 'success')->sum('amount');
        $totalPending = PaymentTransaction::whereIn('status', ['initiated', 'processing'])->count();
        $totalFailed = PaymentTransaction::where('status', 'failed')->count();
        $recentTransactions = PaymentTransaction::with('employee.user')
            ->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'pendingPayrolls',
            'paidThisMonth',
            'monthlyPayroll',
            'recentEmployees',
            'recentPayrolls',
            'departments',
            'totalPF',
            'totalESI',
            'totalTDS',
            'totalGross',
            'totalNet',
            'totalPaid',
            'totalPending',
            'totalFailed',
            'recentTransactions'
        ));
    }
}