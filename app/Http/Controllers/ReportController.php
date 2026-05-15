<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $month = request('month', now()->month);
        $year  = request('year',  now()->year);

        $payrollRecords = PayrollRecord::with('employee.user', 'employee.department')
                                        ->where('month', $month)
                                        ->where('year',  $year)
                                        ->get();

        $transactions = PaymentTransaction::with('employee.user')
                                           ->whereMonth('created_at', $month)
                                           ->whereYear('created_at',  $year)
                                           ->get();

        $totalGross      = $payrollRecords->sum('gross');
        $totalDeductions = $payrollRecords->sum('total_deductions');
        $totalNet        = $payrollRecords->sum('net_salary');
        $totalPaid       = $transactions->where('status', 'success')->sum('amount');
        $totalFailed     = $transactions->where('status', 'failed')->count();
        $totalPending    = $transactions->whereIn('status', ['initiated', 'processing'])->count();

        $deptSummary = $payrollRecords->groupBy('employee.department.name')
                                       ->map(function($records) {
                                           return [
                                               'count'  => $records->count(),
                                               'gross'  => $records->sum('gross'),
                                               'net'    => $records->sum('net_salary'),
                                           ];
                                       });

        $months = [
            1=>'January', 2=>'February', 3=>'March',
            4=>'April',   5=>'May',      6=>'June',
            7=>'July',    8=>'August',   9=>'September',
            10=>'October',11=>'November',12=>'December'
        ];

        $years = range(date('Y') - 1, date('Y'));

        return view('reports.index', compact(
            'payrollRecords',
            'transactions',
            'totalGross',
            'totalDeductions',
            'totalNet',
            'totalPaid',
            'totalFailed',
            'totalPending',
            'deptSummary',
            'months',
            'years',
            'month',
            'year'
        ));
    }
}