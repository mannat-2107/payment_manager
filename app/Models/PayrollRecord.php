<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollRecord extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic',
        'hra',
        'allowances',
        'leave_deduction',
        'leave_days_taken',
        'gross',
        'pf',
        'esi',
        'tds',
        'total_deductions',
        'net_salary',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'payroll_record_id')->latest();
    }

    public function latestTransaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'payroll_record_id')->latest();
    }
}