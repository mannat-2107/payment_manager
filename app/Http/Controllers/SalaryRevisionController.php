<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryRevision;
use Illuminate\Http\Request;

class SalaryRevisionController extends Controller
{
    /* ── Admin: list all employees with revision counts ──────── */
    public function index()
    {
        $employees = Employee::with(['user', 'department'])
            ->withCount('salaryRevisions')
            ->where('status', 'active')
            ->get();

        return view('salary-revisions.index', compact('employees'));
    }

    /* ── Admin: full timeline for one employee ───────────────── */
    public function show(Employee $employee)
    {
        $employee->load(['user', 'department']);

        $revisions = SalaryRevision::where('employee_id', $employee->id)
            ->with('revisor')
            ->latest()
            ->get();

        return view('salary-revisions.show', compact('employee', 'revisions'));
    }
}
