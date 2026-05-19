<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'description' => 'nullable|string',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        // Prevent deletion if employees are still assigned
        if ($department->employees()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department — ' . $department->employees()->count() . ' employees are still assigned.');
        }

        try {
            $department->delete();
            return redirect()->route('departments.index')
                ->with('success', 'Department deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete this department. It has dependent records.');
        }
    }
}