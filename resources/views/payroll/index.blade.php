<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">

        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Payroll Operations</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Generate, review, and process employee compensation</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('payroll.create') }}"
                        class="btn-primary flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Generate Payroll
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 slide-in shadow-sm">
                    <div class="p-1.5 bg-emerald-100 rounded-lg">
                        <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-1 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Total Records</p>
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $records->count() }}</p>
                    <p class="text-xs text-blue-600 mt-2 font-semibold relative z-10">All historical entries</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-2 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Net Disbursed</p>
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 transform transition-transform group-hover:scale-110">
                            <span class="font-bold text-lg">₹</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">₹{{ number_format($records->sum('net_salary'), 0) }}</p>
                    <p class="text-xs text-emerald-600 mt-2 font-semibold relative z-10">Total salary output</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-3 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Pending Auth</p>
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $records->where('status', 'pending')->count() }}</p>
                    <p class="text-xs text-amber-500 mt-2 font-semibold relative z-10">Awaiting processing</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-4 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Cleared</p>
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $records->where('status', 'paid')->count() }}</p>
                    <p class="text-xs text-indigo-500 mt-2 font-semibold relative z-10">Successfully paid out</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden ani-3 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-base font-bold text-slate-800 font-outfit">Payroll Ledger</h3>
                    <span class="text-xs font-bold text-teal-600 bg-teal-50 border border-teal-100 px-3 py-1 rounded-full">{{ $records->count() }} Entries</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white">
                            <tr>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Employee</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Billing Period</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Gross</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Deductions</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Net Salary</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Status</th>
                                <th class="text-right text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $record)
                                <tr class="row-hover">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            @php
                                                $empName = $record->employee?->user?->name ?? 'Unknown';
                                                $empColors = ['#f0fdfa','#eff6ff','#fef3c7','#fdf2f8','#f5f3ff'];
                                                $empTextColors = ['#0f766e','#1d4ed8','#b45309','#9d174d','#6d28d9'];
                                                $colorIdx = abs(crc32($empName)) % 5;
                                            @endphp
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 shadow-sm border border-slate-200"
                                                style="background: {{ $empColors[$colorIdx] }}; color: {{ $empTextColors[$colorIdx] }}">
                                                {{ strtoupper(substr($empName, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">{{ $empName }}</p>
                                                <p class="text-xs text-slate-500">{{ $record->employee?->designation ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ \Carbon\Carbon::create()->month($record->month)->format('M') }} {{ $record->year }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-slate-700 font-mono tracking-wide">₹{{ number_format($record->gross, 0) }}</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-rose-500 font-mono tracking-wide">-₹{{ number_format($record->total_deductions, 0) }}</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-base font-bold text-emerald-600 font-mono tracking-wide bg-emerald-50 px-2 py-1 rounded border border-emerald-100 inline-block">₹{{ number_format($record->net_salary, 0) }}</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($record->status === 'paid')
                                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                Paid
                                            </span>
                                        @elseif($record->status === 'approved')
                                            <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-600 border border-indigo-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                                Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($record->status !== 'paid')
                                                <form method="POST" action="{{ route('payroll.update', $record) }}" class="inline-block mr-2">
                                                    @csrf @method('PUT')
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="text-[11px] font-bold border border-slate-200 rounded-lg px-2 py-1.5 bg-slate-50 text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 cursor-pointer shadow-sm">
                                                        <option value="pending" {{ $record->status == 'pending' ? 'selected' : '' }}>Set Pending</option>
                                                        <option value="approved" {{ $record->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                                        <option value="paid" {{ $record->status == 'paid' ? 'selected' : '' }}>Mark Paid</option>
                                                    </select>
                                                </form>
                                            @endif
                                            <a href="{{ route('payroll.show', $record) }}" class="p-2 bg-slate-50 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="View Breakdown">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="{{ route('payslip.download', $record) }}" class="p-2 bg-teal-50 border border-teal-200 text-teal-600 rounded-lg hover:bg-teal-100 hover:text-teal-700 transition-colors" title="Download Payslip">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-inner">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-slate-800 font-bold text-lg font-outfit mb-1">No Payroll Records</p>
                                                <p class="text-slate-500 text-sm">You haven't generated any payrolls yet.</p>
                                            </div>
                                            <a href="{{ route('payroll.create') }}" class="mt-2 text-teal-600 font-bold text-sm hover:text-teal-700 hover:underline flex items-center gap-1">
                                                Generate First Payroll <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>