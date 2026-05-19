<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\PayrollRecord;
use App\Models\SalaryStructure;
use Carbon\Carbon;

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

        // ── Leave Deduction ──────────────────────────────────────────────
        // Count approved leave days that fall within the payroll month/year
        $periodStart = Carbon::create($year, $month, 1)->startOfMonth();
        $periodEnd   = $periodStart->copy()->endOfMonth();

        $approvedLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->where(function ($q) use ($periodStart, $periodEnd) {
                $q->whereBetween('from_date', [$periodStart, $periodEnd])
                  ->orWhereBetween('to_date',   [$periodStart, $periodEnd])
                  ->orWhere(function ($q2) use ($periodStart, $periodEnd) {
                      $q2->where('from_date', '<', $periodStart)
                         ->where('to_date', '>', $periodEnd);
                  });
            })
            ->get();

        $leaveDays = 0;
        foreach ($approvedLeaves as $leave) {
            $start = max($leave->from_date, $periodStart);
            $end = min($leave->to_date, $periodEnd);
            if ($start <= $end) {
                $leaveDays += $start->diffInWeekdays($end) + 1; // inclusive
            }
        }

        // Working days assumption: 26 per month
        $workingDays    = 26;
        $perDaySalary   = $salary->basic / $workingDays;
        $leaveDeduction = round($perDaySalary * max(0, $leaveDays), 2);

        // ── Standard Calculations ────────────────────────────────────────
        $gross           = $salary->basic + $salary->hra + $salary->allowances - $leaveDeduction;
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
                'leave_deduction'  => $leaveDeduction,
                'leave_days_taken' => $leaveDays,
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