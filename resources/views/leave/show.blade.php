<x-app-layout>
<x-slot name="header">
    <div class="flex items-center gap-3">
        <a href="{{ route('leave.index') }}" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">Leave Request Detail</h1>
            <p class="text-sm text-slate-500 mt-0.5">{{ $leave->employee?->user?->name ?? 'Unknown' }} — {{ $leave->from_date->format('d M Y') }}</p>
        </div>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-3xl mx-auto space-y-5 ani-1">

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Status Banner --}}
    <div class="glass-card rounded-2xl p-5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center text-2xl">🌴</div>
            <div>
                <p class="font-bold text-slate-800 text-lg">{{ \App\Models\LeaveRequest::$types[$leave->leave_type] }}</p>
                <p class="text-sm text-slate-500">Applied {{ $leave->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $leave->statusBadge() }} capitalize">
            {{ $leave->status }}
        </span>
    </div>

    {{-- Details Grid --}}
    <div class="glass-card rounded-2xl p-6 grid grid-cols-2 gap-6">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Employee</p>
            <p class="font-semibold text-slate-800">{{ $leave->employee?->user?->name ?? 'Unknown' }}</p>
            <p class="text-sm text-slate-400">{{ $leave->employee->employee_code }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Department</p>
            <p class="font-semibold text-slate-800">{{ $leave->employee->department->name ?? '—' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">From Date</p>
            <p class="font-semibold text-slate-800">{{ $leave->from_date->format('d M Y') }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">To Date</p>
            <p class="font-semibold text-slate-800">{{ $leave->to_date->format('d M Y') }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Total Days</p>
            <p class="text-2xl font-black text-teal-700">{{ $leave->days }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Actioned By</p>
            <p class="font-semibold text-slate-800">{{ $leave->approver?->name ?? '—' }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Reason</p>
            <p class="text-slate-700 leading-relaxed">{{ $leave->reason }}</p>
        </div>
        @if($leave->rejection_reason)
        <div class="col-span-2 p-3 bg-red-50 border border-red-200 rounded-xl">
            <p class="text-xs font-semibold text-red-400 uppercase tracking-wide mb-1">Rejection Reason</p>
            <p class="text-red-700 text-sm">{{ $leave->rejection_reason }}</p>
        </div>
        @endif
    </div>

    {{-- Actions --}}
    @if($leave->status === 'pending')
    <div class="glass-card rounded-2xl p-5 flex gap-3">
        <form method="POST" action="{{ route('leave.approve', $leave) }}" class="flex-1" onsubmit="return confirm('Approve this leave?')">
            @csrf
            <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition-all">
                ✓ Approve Leave
            </button>
        </form>
        <button onclick="document.getElementById('rejectSection').classList.toggle('hidden')" class="flex-1 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-semibold text-sm rounded-xl border border-red-200 transition-all">
            ✕ Reject Leave
        </button>
    </div>

    <div id="rejectSection" class="hidden glass-card rounded-2xl p-5">
        <form method="POST" action="{{ route('leave.reject', $leave) }}">
            @csrf
            <label class="block text-sm font-semibold text-slate-700 mb-2">Rejection Reason <span class="text-red-500">*</span></label>
            <textarea name="rejection_reason" rows="3" required
                class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none mb-3"
                placeholder="Provide a reason..."></textarea>
            <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-xl transition-all">
                Confirm Rejection
            </button>
        </form>
    </div>
    @endif

</div>
</x-app-layout>
