<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\SalaryStructure;

class PayrollService
{
    public function generatePayroll(Employee $employee, int $month, int $year): PayrollRecord
    {
        $salary = SalaryStructure::where('employee_id', $employee->id)
                                 ->latest()
                                 ->first();

        if (!$salary) {
            throw new \Exception("No salary structure found for employee {$employee->id}");
        }

        $gross           = $salary->basic + $salary->hra + $salary->allowances;
        $pf              = ($salary->basic * $salary->pf_percentage) / 100;
        $esi             = ($gross * $salary->esi_percentage) / 100;
        $tds             = $salary->tds;
        $totalDeductions = $pf + $esi + $tds;
        $netSalary       = $gross - $totalDeductions;

        return PayrollRecord::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'month'       => $month,
                'year'        => $year,
            ],
            [
                'basic'            => $salary->basic,
                'hra'              => $salary->hra,
                'allowances'       => $salary->allowances,
                'gross'            => $gross,
                'pf'               => $pf,
                'esi'              => $esi,
                'tds'              => $tds,
                'total_deductions' => $totalDeductions,
                'net_salary'       => $netSalary,
                'status'           => 'pending',
            ]
        );
    }
}