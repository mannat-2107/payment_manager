<?php

namespace App\Http\Controllers;

use App\Models\PayrollRecord;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipController extends Controller
{
    public function download(PayrollRecord $payroll)
    {
        $payroll->load('employee.user', 'employee.department');

        $pdf = Pdf::loadView('payslip.template', compact('payroll'));

        return $pdf->download('payslip-' . $payroll->employee->employee_code . '-' . $payroll->month . '-' . $payroll->year . '.pdf');
    }

    public function preview(PayrollRecord $payroll)
    {
        $payroll->load('employee.user', 'employee.department');

        $pdf = Pdf::loadView('payslip.template', compact('payroll'));

        return $pdf->stream('payslip.pdf');
    }
}