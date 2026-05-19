<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRecord;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipController extends Controller
{
    // Used by ADMIN — no ownership check needed
    public function download(PayrollRecord $payroll)
    {
        $payroll->load('employee.user', 'employee.department');

        $pdf = Pdf::loadView('payslip.template', compact('payroll'));

        return $pdf->download(
            'payslip-' . $payroll->employee->employee_code .
            '-' . $payroll->month . '-' . $payroll->year . '.pdf'
        );
    }

    // Used by ADMIN — preview in browser
    public function preview(PayrollRecord $payroll)
    {
        $payroll->load('employee.user', 'employee.department');

        $pdf = Pdf::loadView('payslip.template', compact('payroll'));

        return $pdf->stream('payslip.pdf');
    }

    // Used by EMPLOYEE — checks the payroll belongs to them
    public function downloadOwn(PayrollRecord $payroll)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        // If this payroll doesn't belong to the logged-in employee, block it
        abort_if($payroll->employee_id !== $employee->id, 403, 'This payslip does not belong to you.');

        $payroll->load('employee.user', 'employee.department');

        $pdf = Pdf::loadView('payslip.template', compact('payroll'));

        return $pdf->download(
            'payslip-' . $payroll->employee->employee_code .
            '-' . $payroll->month . '-' . $payroll->year . '.pdf'
        );
    }
}