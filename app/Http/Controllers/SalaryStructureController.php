<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;

class SalaryStructureController extends Controller
{
    public function index()
    {
        $salaries = SalaryStructure::with('employee.user')->get();
        return view('salary.index', compact('salaries'));
    }

    public function create()
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('salary.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'basic'          => 'required|numeric|min:0',
            'hra'            => 'required|numeric|min:0',
            'allowances'     => 'required|numeric|min:0',
            'pf_percentage'  => 'required|numeric|min:0|max:100',
            'esi_percentage' => 'required|numeric|min:0|max:100',
            'tds'            => 'required|numeric|min:0',
            'effective_from' => 'required|date',
        ]);

        SalaryStructure::create($request->all());

        return redirect()->route('salary-structures.index')
                         ->with('success', 'Salary structure saved successfully.');
    }

    public function edit(SalaryStructure $salaryStructure)
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('salary.edit', compact('salaryStructure', 'employees'));
    }

    public function update(Request $request, SalaryStructure $salaryStructure)
    {
        $request->validate([
            'basic'           => 'required|numeric|min:0',
            'hra'             => 'required|numeric|min:0',
            'allowances'      => 'required|numeric|min:0',
            'pf_percentage'   => 'required|numeric|min:0|max:100',
            'esi_percentage'  => 'required|numeric|min:0|max:100',
            'tds'             => 'required|numeric|min:0',
            'effective_from'  => 'required|date',
            'revision_reason' => 'nullable|string|max:255',
        ]);

        // The SalaryStructureObserver automatically creates a SalaryRevision
        // entry if basic/hra/allowances changed, picking up revision_reason from request().
        $salaryStructure->update($request->except('revision_reason'));

        return redirect()->route('salary-structures.index')
                         ->with('success', 'Salary structure updated successfully.');
    }

    public function destroy(SalaryStructure $salaryStructure)
    {
        $salaryStructure->delete();
        return redirect()->route('salary-structures.index')
                         ->with('success', 'Salary structure deleted.');
    }
}