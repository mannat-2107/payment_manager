<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">

        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('payroll.index') }}" class="p-2 bg-slate-50 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Payroll Record</h2>
                        <p class="text-sm text-slate-500 mt-0.5 font-medium">
                            {{ $payroll->employee?->user?->name ?? 'Unknown' }} &mdash;
                            {{ DateTime::createFromFormat('!m', $payroll->month)->format('F') }} {{ $payroll->year }}
                        </p>
                    </div>
                </div>

                {{-- Status Badge + Gateway CTA --}}
                <div class="flex items-center gap-3">
                    @if($payroll->status === 'paid')
                        <span class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-3 py-2 rounded-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Fully Paid
                        </span>
                    @elseif($payroll->status === 'approved')
                        <form method="POST" action="{{ route('payroll.pay', $payroll) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/25 transition-all hover:scale-[1.02]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                💳 Pay via Gateway
                            </button>
                        </form>
                    @else
                        <span class="inline-flex items-center gap-2 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold px-3 py-2 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Pending Approval
                        </span>
                        <form method="POST" action="{{ route('payroll.update', $payroll) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-colors">
                                ✓ Approve Now
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('payslip.download', $payroll) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition-colors border border-slate-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Payslip
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Salary Breakdown --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Employee Card --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-teal-500/20">
                                {{ strtoupper(substr($payroll->employee?->user?->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-800">{{ $payroll->employee?->user?->name ?? 'Unknown' }}</h3>
                                <p class="text-sm text-slate-500 font-medium">{{ $payroll->employee->designation }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs font-mono bg-slate-100 px-2 py-0.5 rounded text-slate-600">{{ $payroll->employee->employee_code }}</span>
                                    <span class="text-xs font-medium text-slate-500">{{ $payroll->employee->department?->name ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 font-mono uppercase tracking-wider">Billing Period</p>
                                <p class="text-lg font-bold text-slate-800 mt-1">{{ DateTime::createFromFormat('!m', $payroll->month)->format('F') }} {{ $payroll->year }}</p>
                                @php
                                    $statusConfig = match($payroll->status) {
                                        'paid'     => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'Paid'],
                                        'approved' => ['bg-indigo-50 text-indigo-700 border-indigo-200', 'Approved'],
                                        default    => ['bg-amber-50 text-amber-700 border-amber-200', 'Pending'],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 {{ $statusConfig[0] }} border text-xs font-bold px-2.5 py-1 rounded-lg mt-2">
                                    {{ $statusConfig[1] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Salary Breakdown --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Earnings Card --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Earnings</h4>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">Basic Pay</span>
                                    <span class="text-sm font-bold text-slate-700 font-mono">₹{{ number_format($payroll->basic, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">HRA</span>
                                    <span class="text-sm font-bold text-slate-700 font-mono">₹{{ number_format($payroll->hra, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">Allowances</span>
                                    <span class="text-sm font-bold text-slate-700 font-mono">₹{{ number_format($payroll->allowances, 2) }}</span>
                                </div>
                                @if($payroll->leave_deduction > 0)
                                <div class="flex justify-between items-center text-rose-600">
                                    <span class="text-sm">Leave ({{ $payroll->leave_days_taken }} days)</span>
                                    <span class="text-sm font-bold font-mono">-₹{{ number_format($payroll->leave_deduction, 2) }}</span>
                                </div>
                                @endif
                                <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-700">Gross Earnings</span>
                                    <span class="text-base font-black text-slate-800 font-mono">₹{{ number_format($payroll->gross, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Deductions Card --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </div>
                                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Deductions</h4>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">Provident Fund (PF)</span>
                                    <span class="text-sm font-bold text-rose-500 font-mono">₹{{ number_format($payroll->pf, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">ESI</span>
                                    <span class="text-sm font-bold text-rose-500 font-mono">₹{{ number_format($payroll->esi, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">TDS</span>
                                    <span class="text-sm font-bold text-rose-500 font-mono">₹{{ number_format($payroll->tds, 2) }}</span>
                                </div>
                                <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-700">Total Deductions</span>
                                    <span class="text-base font-black text-rose-500 font-mono">₹{{ number_format($payroll->total_deductions, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Net Salary Banner --}}
                    <div class="bg-gradient-to-r from-teal-500 to-emerald-600 rounded-2xl p-6 shadow-lg shadow-teal-500/20 text-white flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-teal-100 uppercase tracking-widest font-mono">Net Salary Disbursement</p>
                            <p class="text-xs text-teal-200 mt-1">Gross ₹{{ number_format($payroll->gross, 0) }} − Deductions ₹{{ number_format($payroll->total_deductions, 0) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black font-mono tracking-tight">₹{{ number_format($payroll->net_salary, 2) }}</p>
                        </div>
                    </div>

                    {{-- Linked Transaction History --}}
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <h4 class="font-bold text-slate-800 font-outfit">Payment Transaction History</h4>
                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full border border-slate-200">
                                {{ $payroll->transactions->count() }} {{ Str::plural('transaction', $payroll->transactions->count()) }}
                            </span>
                        </div>

                        @if($payroll->transactions->isEmpty())
                            <div class="px-6 py-12 text-center">
                                <div class="w-16 h-16 mx-auto bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <p class="text-slate-600 font-bold text-sm">No Transactions Yet</p>
                                <p class="text-slate-400 text-xs mt-1">
                                    @if($payroll->status === 'approved')
                                        Use the <strong>💳 Pay via Gateway</strong> button above to initiate payment.
                                    @else
                                        Approve this payroll record first to enable gateway payment.
                                    @endif
                                </p>
                            </div>
                        @else
                            <div class="divide-y divide-slate-100">
                                @foreach($payroll->transactions as $txn)
                                    <div class="px-6 py-4 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            {{-- Status icon --}}
                                            @if($txn->status === 'success')
                                                <div class="w-9 h-9 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                            @elseif($txn->status === 'failed')
                                                <div class="w-9 h-9 rounded-full bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-500 flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </div>
                                            @elseif($txn->status === 'initiated' || $txn->status === 'processing')
                                                <div class="w-9 h-9 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-500 flex-shrink-0">
                                                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                </div>
                                            @else
                                                <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01"/></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 font-mono">{{ $txn->transaction_reference }}</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $txn->created_at->format('d M Y, H:i') }}
                                                    @if($txn->failure_reason)
                                                        &mdash; <span class="text-rose-400">{{ $txn->failure_reason }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm font-black text-slate-800 font-mono">₹{{ number_format($txn->amount, 0) }}</span>
                                            @if($txn->status === 'initiated' || $txn->status === 'processing')
                                                <a href="{{ route('transactions.checkout', $txn) }}"
                                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white text-xs font-bold rounded-lg hover:scale-[1.02] transition-all">
                                                    💳 Resume
                                                </a>
                                            @else
                                                <a href="{{ route('transactions.show', $txn) }}"
                                                   class="p-1.5 bg-slate-50 border border-slate-200 text-slate-500 rounded-lg hover:bg-slate-100 transition-colors" title="View Transaction">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Column: Info Panel --}}
                <div class="space-y-6">

                    {{-- Quick Stats --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Quick Summary</h4>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Gross Salary</span>
                            <span class="font-bold text-slate-700 font-mono text-sm">₹{{ number_format($payroll->gross, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Total Deductions</span>
                            <span class="font-bold text-rose-500 font-mono text-sm">-₹{{ number_format($payroll->total_deductions, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm font-bold text-slate-700">Net Salary</span>
                            <span class="font-black text-emerald-600 font-mono text-lg">₹{{ number_format($payroll->net_salary, 0) }}</span>
                        </div>
                    </div>

                    {{-- Payroll Status Stepper --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mb-5">Payroll Lifecycle</h4>
                        @php
                            $steps = [
                                ['label' => 'Generated', 'done' => true, 'icon' => '📋'],
                                ['label' => 'Approved', 'done' => in_array($payroll->status, ['approved', 'paid']), 'icon' => '✅'],
                                ['label' => 'Payment Initiated', 'done' => $payroll->transactions->isNotEmpty(), 'icon' => '💳'],
                                ['label' => 'Paid', 'done' => $payroll->status === 'paid', 'icon' => '🏦'],
                            ];
                        @endphp
                        <div class="space-y-3">
                            @foreach($steps as $step)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm flex-shrink-0 {{ $step['done'] ? 'bg-teal-50 border-2 border-teal-500' : 'bg-slate-100 border-2 border-slate-200' }}">
                                        {{ $step['icon'] }}
                                    </div>
                                    <span class="text-sm font-{{ $step['done'] ? 'bold text-slate-800' : 'medium text-slate-400' }}">{{ $step['label'] }}</span>
                                    @if($step['done'])
                                        <svg class="w-4 h-4 text-teal-500 ml-auto flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bank Details --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mb-4">Bank Details</h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">Bank Name</p>
                                <p class="text-sm font-bold text-slate-700 mt-0.5">{{ $payroll->employee->bank_name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">Account Number</p>
                                <p class="text-sm font-bold text-slate-700 mt-0.5 font-mono">{{ $payroll->employee->account_number ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">IFSC Code</p>
                                <p class="text-sm font-bold text-slate-700 mt-0.5 font-mono">{{ $payroll->employee->ifsc_code ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Status Changer (non-paid) --}}
                    @if($payroll->status !== 'paid')
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mb-4">Change Status</h4>
                            <form method="POST" action="{{ route('payroll.update', $payroll) }}">
                                @csrf @method('PUT')
                                <div class="flex gap-3">
                                    <select name="status" class="flex-1 border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 cursor-pointer">
                                        <option value="pending" {{ $payroll->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $payroll->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="paid" {{ $payroll->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                    <button type="submit" class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition-colors">Save</button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>