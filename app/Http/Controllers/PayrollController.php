<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index()
    {
        $records = PayrollRecord::with('employee.user')->latest()->get();
        return view('payroll.index', compact('records'));
    }

    public function create()
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        $months = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        $years = range(date('Y') - 1, date('Y') + 1);
        return view('payroll.create', compact('employees', 'months', 'years'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month'       => 'required|integer|between:1,12',
            'year'        => 'required|integer',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        try {
            $this->payrollService->generatePayroll(
                $employee,
                $request->month,
                $request->year
            );

            return redirect()->route('payroll.index')
                             ->with('success', 'Payroll generated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(PayrollRecord $payroll)
    {
        $payroll->load('employee.user');
        return view('payroll.show', compact('payroll'));
    }

    public function update(Request $request, PayrollRecord $payroll)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,paid',
        ]);

        $payroll->update(['status' => $request->status]);

        return redirect()->route('payroll.index')
                         ->with('success', 'Payroll status updated.');
    }

    public function destroy(PayrollRecord $payroll)
    {
        $payroll->delete();
        return redirect()->route('payroll.index')
                         ->with('success', 'Payroll record deleted.');
    }
}