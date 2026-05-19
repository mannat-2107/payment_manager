<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    protected $fillable = [
        'label',
        'run_day_of_month',
        'is_active',
        'last_run_at',
        'next_run_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
    ];

    /* ── Compute next run from run_day_of_month ─────────────────── */
    public function computeNextRun(): Carbon
    {
        $today = Carbon::today();
        $day   = (int) $this->run_day_of_month;

        // If today's day < configured day, next run is this month
        $candidate = Carbon::today()->startOfMonth()->addDays($day - 1);
        if ($candidate->lte($today)) {
            $candidate->addMonth();
        }
        return $candidate;
    }

    public function isDueToday(): bool
    {
        return (int) now()->day === (int) $this->run_day_of_month;
    }

    /* ── Relationships ─────────────────────────────────────────── */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
