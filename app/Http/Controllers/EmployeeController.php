<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'department']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('employee_code', 'like', '%' . $request->search . '%');
        }

        if ($request->department) {
            $query->where('department_id', $request->department);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $employees = $query->get();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'date_of_joining' => 'required|date',
            'phone' => 'nullable|string|max:15',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole('employee');

        $code = 'EMP' . str_pad(Employee::count() + 1, 4, '0', STR_PAD_LEFT);

        Employee::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'employee_code' => $code,
            'designation' => $request->designation,
            'phone' => $request->phone,
            'date_of_joining' => $request->date_of_joining,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee added successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'department']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,inactive,terminated',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
            ->with('success', 'Employee removed successfully.');
    }
}