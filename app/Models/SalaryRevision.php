<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryRevision extends Model
{
    protected $fillable = [
        'employee_id',
        'salary_structure_id',
        'old_basic',
        'new_basic',
        'old_hra',
        'new_hra',
        'old_allowances',
        'new_allowances',
        'old_net',
        'new_net',
        'effective_from',
        'reason',
        'revised_by',
    ];

    protected $casts = [
        'effective_from' => 'date',
    ];

    /* ── Relationships ─────────────────────────────────────────── */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function revisor()
    {
        return $this->belongsTo(User::class, 'revised_by');
    }

    /* ── Helper: net increment ─────────────────────────────────── */
    public function netIncrement(): float
    {
        return $this->new_net - $this->old_net;
    }

    public function incrementPercent(): float
    {
        if ($this->old_net == 0) return 0;
        return round((($this->new_net - $this->old_net) / $this->old_net) * 100, 2);
    }
}
