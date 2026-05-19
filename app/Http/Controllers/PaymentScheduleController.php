<?php

namespace App\Http\Controllers;

use App\Models\PaymentSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class PaymentScheduleController extends Controller
{
    public function index()
    {
        $schedules = PaymentSchedule::with('creator')->latest()->get();
        return view('payment-schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'             => 'required|string|max:100',
            'run_day_of_month'  => 'required|integer|between:1,28',
            'notes'             => 'nullable|string|max:500',
        ]);

        $schedule = PaymentSchedule::create([
            'label'            => $request->label,
            'run_day_of_month' => $request->run_day_of_month,
            'notes'            => $request->notes,
            'is_active'        => true,
            'created_by'       => Auth::id(),
        ]);

        $schedule->update(['next_run_at' => $schedule->computeNextRun()]);

        return back()->with('success', 'Payment schedule created.');
    }

    public function update(Request $request, PaymentSchedule $paymentSchedule)
    {
        $request->validate([
            'label'            => 'required|string|max:100',
            'run_day_of_month' => 'required|integer|between:1,28',
            'is_active'        => 'boolean',
            'notes'            => 'nullable|string|max:500',
        ]);

        $paymentSchedule->update([
            'label'            => $request->label,
            'run_day_of_month' => $request->run_day_of_month,
            'is_active'        => $request->boolean('is_active'),
            'notes'            => $request->notes,
        ]);

        $paymentSchedule->update(['next_run_at' => $paymentSchedule->computeNextRun()]);

        return back()->with('success', 'Schedule updated.');
    }

    public function destroy(PaymentSchedule $paymentSchedule)
    {
        $paymentSchedule->delete();
        return back()->with('success', 'Schedule deleted.');
    }

    /* ── Manual trigger ─────────────────────────────────────── */
    public function runNow(PaymentSchedule $paymentSchedule)
    {
        Artisan::call('payroll:run-scheduled', ['--force' => true]);
        $output = Artisan::output();

        $paymentSchedule->update([
            'last_run_at' => now(),
            'next_run_at' => $paymentSchedule->computeNextRun(),
        ]);

        return back()->with('success', 'Schedule executed manually. ' . trim($output));
    }
}
