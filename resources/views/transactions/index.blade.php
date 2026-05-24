<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">

        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Payment Transactions</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Track, manage, and execute all employee disbursements</p>
                </div>
                <div class="flex items-center gap-3">
                    @php
                        $approvedCount = \App\Models\PayrollRecord::where('status', 'approved')->count();
                    @endphp
                    @if($approvedCount > 0)
                        <form method="POST" action="{{ route('transactions.bulk-pay') }}"
                            onsubmit="return confirm('Process bulk payment for {{ $approvedCount }} approved payrolls?')">
                            @csrf
                            <button type="submit"
                                class="btn-primary flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/30">
                                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Execute Bulk Pay ({{ $approvedCount }})
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('transactions.create') }}"
                        class="btn-primary flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        New Transaction
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 slide-in shadow-sm">
                    <div class="p-1.5 bg-emerald-100 rounded-lg">
                        <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 slide-in shadow-sm">
                    <div class="p-1.5 bg-rose-100 rounded-lg">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="font-bold text-sm">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-1 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Total Capital Paid</p>
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">₹{{ number_format($totalPaid, 0) }}</p>
                    <p class="text-xs text-blue-600 mt-2 font-semibold relative z-10">Cleared via gateways</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-2 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Successful Txns</p>
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $totalSuccess }}</p>
                    <p class="text-xs text-emerald-600 mt-2 font-semibold relative z-10">Completed dispatches</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-3 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Pending Clearance</p>
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $totalPending }}</p>
                    <p class="text-xs text-amber-500 mt-2 font-semibold relative z-10">Requires sync</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-4 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Failed Txns</p>
                        <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-rose-500 font-outfit tracking-tight relative z-10">{{ $totalFailed }}</p>
                    <p class="text-xs text-rose-500 mt-2 font-semibold relative z-10">Needs immediate retry</p>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 ani-3 shadow-sm">
                <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col lg:flex-row gap-5 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-[11px] font-bold text-slate-400 mb-2 uppercase tracking-wider font-mono">Search Ledger</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Emp name or TRx ID..."
                                class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-slate-50 transition-colors font-medium text-slate-700 placeholder-slate-400">
                        </div>
                    </div>
                    <div class="w-full lg:w-48">
                        <label class="block text-[11px] font-bold text-slate-400 mb-2 uppercase tracking-wider font-mono">Status Filter</label>
                        <select name="status" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-slate-50 font-medium text-slate-700 cursor-pointer transition-colors">
                            <option value="">All Statuses</option>
                            <option value="initiated" {{ request('status') == 'initiated' ? 'selected' : '' }}>Initiated</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="reversed" {{ request('status') == 'reversed' ? 'selected' : '' }}>Reversed</option>
                        </select>
                    </div>
                    <div class="w-full lg:w-48">
                        <label class="block text-[11px] font-bold text-slate-400 mb-2 uppercase tracking-wider font-mono">Channel</label>
                        <select name="method" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-slate-50 font-medium text-slate-700 cursor-pointer transition-colors">
                            <option value="">All Channels</option>
                            <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Wire</option>
                            <option value="cheque" {{ request('method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Physical Cash</option>
                        </select>
                    </div>
                    <div class="flex gap-3 w-full lg:w-auto">
                        <button type="submit" class="flex-1 lg:flex-none bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-900 transition-colors shadow-sm">
                            Apply
                        </button>
                        <a href="{{ route('transactions.index') }}" class="flex-1 lg:flex-none text-center bg-white border border-slate-200 text-slate-600 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- Transactions Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden ani-4 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-base font-bold text-slate-800 font-outfit">Transaction Ledger</h3>
                    <span class="text-xs font-bold text-teal-600 bg-teal-50 border border-teal-100 px-3 py-1 rounded-full">{{ $transactions->total() }} Records found</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white">
                            <tr>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Beneficiary</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">TRx ID</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Amount</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Channel</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Status</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Timestamp</th>
                                <th class="text-right text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $txn)
                                <tr class="row-hover">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            @php
                                                $txnName = $txn->employee?->user?->name ?? 'Unknown';
                                                $txnColors = ['#f0fdfa','#eff6ff','#fef3c7','#fdf2f8','#f5f3ff'];
                                                $txnTextColors = ['#0f766e','#1d4ed8','#b45309','#9d174d','#6d28d9'];
                                                $txnColorIdx = abs(crc32($txnName)) % 5;
                                            @endphp
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 shadow-sm border border-slate-200"
                                                style="background: {{ $txnColors[$txnColorIdx] }}; color: {{ $txnTextColors[$txnColorIdx] }}">
                                                {{ strtoupper(substr($txnName, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">{{ $txnName }}</p>
                                                <p class="text-xs text-slate-500 font-mono tracking-wider">{{ $txn->employee?->employee_code ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-xs font-bold text-slate-500 bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-md font-mono tracking-wider">{{ $txn->transaction_reference }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-base font-bold text-slate-800 font-mono tracking-wide">₹{{ number_format($txn->amount, 0) }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-100 border border-slate-200 px-2 py-1 rounded-md capitalize">
                                            @if($txn->payment_method === 'bank_transfer')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                                Bank Wire
                                            @elseif($txn->payment_method === 'cheque')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Cheque
                                            @else
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Cash
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($txn->status === 'success')
                                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Success
                                            </span>
                                        @elseif($txn->status === 'processing')
                                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>Processing
                                            </span>
                                        @elseif($txn->status === 'initiated')
                                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 border border-blue-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Initiated
                                            </span>
                                        @elseif($txn->status === 'failed')
                                            <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 border border-rose-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Failed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 border border-slate-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Reversed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-500">
                                        {{ $txn->created_at->format('M d, Y') }} <span class="text-[10px] text-slate-400 font-normal ml-1">{{ $txn->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($txn->status !== 'success')
                                                <form method="POST" action="{{ route('transactions.update', $txn) }}" class="inline-block mr-1">
                                                    @csrf @method('PUT')
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="text-[10px] font-bold border border-slate-200 rounded-lg px-2 py-1.5 bg-slate-50 text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 cursor-pointer shadow-sm uppercase tracking-wide">
                                                        <option value="initiated" {{ $txn->status == 'initiated' ? 'selected' : '' }}>Initiated</option>
                                                        <option value="processing" {{ $txn->status == 'processing' ? 'selected' : '' }}>Proc.</option>
                                                        <option value="success" {{ $txn->status == 'success' ? 'selected' : '' }}>Success</option>
                                                        <option value="failed" {{ $txn->status == 'failed' ? 'selected' : '' }}>Fail</option>
                                                        <option value="reversed" {{ $txn->status == 'reversed' ? 'selected' : '' }}>Rev.</option>
                                                    </select>
                                                </form>
                                            @endif
                                            @if($txn->status === 'initiated' || $txn->status === 'processing')
                                                <a href="{{ route('transactions.checkout', $txn) }}"
                                                   class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all hover:scale-[1.02]" title="Open Payment Gateway">
                                                    💳 Checkout
                                                </a>
                                            @endif
                                            @if($txn->status === 'failed')
                                                <form method="POST" action="{{ route('transactions.retry', $txn) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-lg hover:bg-orange-100 transition-colors" title="Retry Transaction">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('transactions.show', $txn) }}" class="p-1.5 bg-slate-50 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="{{ route('transactions.receipt', $txn) }}" class="p-1.5 bg-purple-50 border border-purple-200 text-purple-600 rounded-lg hover:bg-purple-100 hover:text-purple-700 transition-colors" title="Download Receipt">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-inner">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-slate-800 font-bold text-lg font-outfit mb-1">No Transactions Found</p>
                                                <p class="text-slate-500 text-sm">Clear your filters or initiate a new transaction.</p>
                                            </div>
                                            <a href="{{ route('transactions.create') }}" class="mt-2 text-teal-600 font-bold text-sm hover:text-teal-700 hover:underline flex items-center gap-1">
                                                Create Transaction <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>