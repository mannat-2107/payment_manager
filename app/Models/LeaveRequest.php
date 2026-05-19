<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type',
        'from_date',
        'to_date',
        'days',
        'reason',
        'status',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];

    /* ── Leave-type labels ─────────────────────────────────────── */
    public static array $types = [
        'sick'    => 'Sick Leave',
        'casual'  => 'Casual Leave',
        'annual'  => 'Annual Leave',
    ];

    /* Yearly quota per type */
    public static array $quota = [
        'sick'   => 10,
        'casual' => 12,
        'annual' => 15,
    ];

    /* ── Status badge helper ─────────────────────────────────────── */
    public function statusBadge(): string
    {
        return match ($this->status) {
            'approved' => 'bg-emerald-100 text-emerald-700',
            'rejected' => 'bg-red-100 text-red-700',
            default    => 'bg-amber-100 text-amber-700',
        };
    }

    /* ── Scopes ──────────────────────────────────────────────────── */
    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeApproved($q)  { return $q->where('status', 'approved'); }

    /* ── Relationships ───────────────────────────────────────────── */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
