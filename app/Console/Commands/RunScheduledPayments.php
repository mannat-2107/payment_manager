<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\PaymentSchedule;
use App\Services\PayrollService;
use Illuminate\Console\Command;

class RunScheduledPayments extends Command
{
    protected $signature   = 'payroll:run-scheduled {--force : Ignore today\'s date check}';
    protected $description = 'Run all active payment schedules whose run_day_of_month matches today';

    public function handle(PayrollService $payrollService): int
    {
        $today     = now()->day;
        $month     = now()->month;
        $year      = now()->year;
        $schedules = PaymentSchedule::where('is_active', true)
                        ->where('run_day_of_month', $today)
                        ->get();

        if ($this->option('force')) {
            $schedules = PaymentSchedule::where('is_active', true)->get();
        }

        if ($schedules->isEmpty()) {
            $this->info("No active schedules configured for day {$today}.");
            return self::SUCCESS;
        }

        $employees = Employee::with('user')->where('status', 'active')->get();

        foreach ($schedules as $schedule) {
            $this->line("▶  Running schedule: <comment>{$schedule->label}</comment>");
            $generated = 0;
            $errors    = 0;

            foreach ($employees as $employee) {
                try {
                    $payrollService->generatePayroll($employee, $month, $year);
                    $generated++;
                } catch (\Exception $e) {
                    $this->warn("  ⚠  {$employee->user->name}: {$e->getMessage()}");
                    $errors++;
                }
            }

            $schedule->update([
                'last_run_at' => now(),
                'next_run_at' => $schedule->computeNextRun(),
            ]);

            $this->info("  ✓  Generated: {$generated} | Errors: {$errors}");
        }

        return self::SUCCESS;
    }
}
