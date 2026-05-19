<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">Leave Management</h1>
            <p class="text-sm text-slate-500 mt-0.5">Review and action employee leave requests</p>
        </div>
        @if($pending > 0)
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 text-amber-700 text-sm font-semibold rounded-xl">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            {{ $pending }} Pending
        </span>
        @endif
    </div>
</x-slot>

<div class="py-8 px-4 max-w-7xl mx-auto space-y-6 ani-1">

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Filters --}}
    <div class="glass-card rounded-2xl p-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Status</label>
                <select name="status" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">All Statuses</option>
                    <option value="pending"  {{ request('status')=='pending'  ? 'selected':'' }}>Pending</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected':'' }}>Approved</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected':'' }}>Rejected</option>
                </select>
            </div>
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Leave Type</label>
                <select name="type" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="sick"   {{ request('type')=='sick'   ? 'selected':'' }}>Sick Leave</option>
                    <option value="casual" {{ request('type')=='casual' ? 'selected':'' }}>Casual Leave</option>
                    <option value="annual" {{ request('type')=='annual' ? 'selected':'' }}>Annual Leave</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg transition-all">Filter</button>
            <a href="{{ route('leave.index') }}" class="px-4 py-2 text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">Clear</a>
        </form>
    </div>

    {{-- Table --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Employee</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Type</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Dates</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Days</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-right px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($leaves as $leave)
                <tr class="row-hover">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $leave->employee?->user?->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-slate-400">{{ $leave->employee->employee_code }}</div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium capitalize">
                            {{ \App\Models\LeaveRequest::$types[$leave->leave_type] ?? $leave->leave_type }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-slate-600">
                        {{ $leave->from_date->format('d M Y') }}
                        @if(!$leave->from_date->isSameDay($leave->to_date))
                            → {{ $leave->to_date->format('d M Y') }}
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="font-bold text-slate-800">{{ $leave->days }}</span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $leave->statusBadge() }} capitalize">
                            {{ $leave->status }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('leave.show', $leave) }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-teal-700 border border-slate-200 hover:border-teal-300 rounded-lg transition-all">View</a>
                            @if($leave->status === 'pending')
                            <form method="POST" action="{{ route('leave.approve', $leave) }}" onsubmit="return confirm('Approve this leave?')">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg transition-all">Approve</button>
                            </form>
                            <button onclick="openRejectModal({{ $leave->id }})" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-all">Reject</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                        <div class="text-4xl mb-3">🌴</div>
                        <p class="font-medium">No leave requests found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $leaves->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold outfit text-slate-800 mb-4">Reject Leave Request</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="rejection_reason" rows="3" required
                    class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none"
                    placeholder="Explain why this leave is being rejected..."></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 border border-slate-200 rounded-xl">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-all">Reject Leave</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id) {
    document.getElementById('rejectForm').action = '/leave/' + id + '/reject';
    document.getElementById('rejectModal').classList.remove('hidden');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
</x-app-layout>
