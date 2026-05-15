<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    protected $fillable = [
        'employee_id',
        'basic',
        'hra',
        'allowances',
        'pf_percentage',
        'esi_percentage',
        'tds',
        'effective_from',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculateGross()
    {
        return $this->basic + $this->hra + $this->allowances;
    }

    public function calculateDeductions()
    {
        $pf = ($this->basic * $this->pf_percentage) / 100;
        $esi = ($this->calculateGross() * $this->esi_percentage) / 100;
        return $pf + $esi + $this->tds;
    }

    public function calculateNet()
    {
        return $this->calculateGross() - $this->calculateDeductions();
    }
    public function salaryStructures()
    {
        return $this->hasMany(SalaryStructure::class);
    }
}