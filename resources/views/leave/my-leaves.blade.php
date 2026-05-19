<x-app-layout>
<x-slot name="header">
    <div class="flex items-center gap-3">
        <a href="{{ route('portal.index') }}" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">My Leave Requests</h1>
            <p class="text-sm text-slate-500 mt-0.5">Track your leave applications and balances</p>
        </div>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-5xl mx-auto space-y-6 ani-1">

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Balance Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach(\App\Models\LeaveRequest::$types as $key => $label)
        @php $quota = \App\Models\LeaveRequest::$quota[$key]; $used = $usedDays[$key] ?? 0; $remaining = max(0, $quota - $used); @endphp
        <div class="glass-card rounded-2xl p-5 stat-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold text-slate-600">{{ $label }}</p>
                <span class="text-xs px-2 py-0.5 bg-teal-100 text-teal-700 rounded-full font-semibold">{{ $quota }} days</span>
            </div>
            <div class="flex items-end gap-2 mb-3">
                <span class="text-3xl font-black text-slate-800">{{ $remaining }}</span>
                <span class="text-slate-400 text-sm pb-1">remaining</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="h-2 rounded-full bg-teal-500 transition-all duration-700"
                    style="width: {{ $quota > 0 ? min(100, ($used/$quota)*100) : 0 }}%"></div>
            </div>
            <p class="text-xs text-slate-400 mt-1.5">{{ $used }} used this year</p>
        </div>
        @endforeach
    </div>

    {{-- Apply Button --}}
    <div class="flex justify-end">
        <a href="{{ route('leave.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-xl transition-all btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Apply for Leave
        </a>
    </div>

    {{-- Leave History --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800 outfit">Leave History</h2>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/70">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Type</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Dates</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Days</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Applied</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($leaves as $leave)
                <tr class="row-hover">
                    <td class="px-5 py-4">
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium">
                            {{ \App\Models\LeaveRequest::$types[$leave->leave_type] ?? $leave->leave_type }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-slate-600">
                        {{ $leave->from_date->format('d M') }} → {{ $leave->to_date->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4 text-center font-bold text-slate-800">{{ $leave->days }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $leave->statusBadge() }} capitalize">
                            {{ $leave->status }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-slate-400 text-xs">{{ $leave->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-slate-400">
                        <p class="text-2xl mb-2">🌴</p>
                        <p class="font-medium">No leave requests yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100">{{ $leaves->links() }}</div>
    </div>
</div>
</x-app-layout>
