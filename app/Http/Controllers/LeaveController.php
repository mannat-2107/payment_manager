<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /* ── Admin: all requests ──────────────────────────────────── */
    public function index(Request $request)
    {
        $query = LeaveRequest::with('employee.user')
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type) {
            $query->where('leave_type', $request->type);
        }

        $leaves  = $query->paginate(20);
        $pending = LeaveRequest::pending()->count();

        return view('leave.index', compact('leaves', 'pending'));
    }

    /* ── Employee: apply ──────────────────────────────────────── */
    public function create()
    {
        return view('leave.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:sick,casual,annual',
            'from_date'  => 'required|date|after_or_equal:today',
            'to_date'    => 'required|date|after_or_equal:from_date',
            'reason'     => 'required|string|max:1000',
        ]);

        $employee = Auth::user()->employee;
        if (!$employee) {
            return back()->with('error', 'Employee profile not found.');
        }

        $from = \Carbon\Carbon::parse($request->from_date);
        $to   = \Carbon\Carbon::parse($request->to_date);
        $days = $from->diffInWeekdays($to) + 1; // inclusive, weekdays only

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type'  => $request->leave_type,
            'from_date'   => $request->from_date,
            'to_date'     => $request->to_date,
            'days'        => max(1, $days),
            'reason'      => $request->reason,
            'status'      => 'pending',
        ]);

        return redirect()->route('portal.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    /* ── Admin/Employee: detail ───────────────────────────────── */
    public function show(LeaveRequest $leave)
    {
        $leave->load('employee.user', 'approver');
        return view('leave.show', compact('leave'));
    }

    /* ── Admin: approve ───────────────────────────────────────── */
    public function approve(LeaveRequest $leave)
    {
        abort_if($leave->status !== 'pending', 422, 'Already actioned.');

        $leave->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', "Leave approved for {$leave->employee->user->name}.");
    }

    /* ── Admin: reject ────────────────────────────────────────── */
    public function reject(Request $request, LeaveRequest $leave)
    {
        abort_if($leave->status !== 'pending', 422, 'Already actioned.');

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $leave->update([
            'status'           => 'rejected',
            'approved_by'      => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Leave rejected.');
    }

    /* ── Employee portal: my leaves ───────────────────────────── */
    public function myLeaves()
    {
        $employee = Auth::user()->employee;
        if (!$employee) abort(404);

        $leaves = LeaveRequest::where('employee_id', $employee->id)
            ->latest()
            ->paginate(15);

        // Approved days per type this year
        $usedDays = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->whereYear('from_date', now()->year)
            ->selectRaw('leave_type, SUM(days) as total')
            ->groupBy('leave_type')
            ->pluck('total', 'leave_type');

        return view('leave.my-leaves', compact('leaves', 'usedDays'));
    }
}
