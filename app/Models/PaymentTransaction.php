<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'employee_id',
        'payroll_record_id',
        'transaction_reference',
        'amount',
        'payment_method',
        'status',
        'bank_name',
        'account_number',
        'ifsc_code',
        'remarks',
        'failure_reason',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollRecord()
    {
        return $this->belongsTo(PayrollRecord::class);
    }

    public function getStatusColorClass()
    {
        return match($this->status) {
            'success'    => 'bg-green-100 text-green-700',
            'processing' => 'bg-yellow-100 text-yellow-700',
            'initiated'  => 'bg-blue-100 text-blue-700',
            'failed'     => 'bg-red-100 text-red-700',
            'reversed'   => 'bg-gray-100 text-gray-700',
            default      => 'bg-gray-100 text-gray-700',
        };
    }
}