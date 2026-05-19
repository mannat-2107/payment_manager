<?php

namespace App\Observers;

use App\Models\SalaryRevision;
use App\Models\SalaryStructure;
use Illuminate\Support\Facades\Auth;

class SalaryStructureObserver
{
    public function updating(SalaryStructure $structure): void
    {
        // Capture the old state before the update is committed
        $old = SalaryStructure::find($structure->id);
        if (! $old) return;

        // Only log a revision when earnings components actually change
        $earningsChanged = (
            $old->basic      != $structure->basic      ||
            $old->hra        != $structure->hra        ||
            $old->allowances != $structure->allowances
        );

        if (! $earningsChanged) return;

        $oldNet = $old->calculateNet();
        $newNet = $structure->calculateNet();

        SalaryRevision::create([
            'employee_id'         => $structure->employee_id,
            'salary_structure_id' => $structure->id,
            'old_basic'           => $old->basic,
            'new_basic'           => $structure->basic,
            'old_hra'             => $old->hra,
            'new_hra'             => $structure->hra,
            'old_allowances'      => $old->allowances,
            'new_allowances'      => $structure->allowances,
            'old_net'             => $oldNet,
            'new_net'             => $newNet,
            'effective_from'      => $structure->effective_from ?? now(),
            'reason'              => request()->input('revision_reason', 'Salary updated'),
            'revised_by'          => Auth::id(),
        ]);
    }
}
