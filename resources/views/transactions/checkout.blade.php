<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12" x-data="{
        cardNumber: '•••• •••• •••• ••••',
        cardName: 'CARDHOLDER NAME',
        cardExpiry: 'MM/YY',
        cardCvv: '•••',
        simulateStatus: 'success',
        failureReason: 'Insufficient funds'
    }">
        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('transactions.index') }}" class="p-2 bg-slate-50 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">PayManager Secure Gateway</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Verify details and authorize transaction</p>
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold rounded-lg font-mono">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        REF: {{ $transaction->transaction_reference }}
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Left Side: Payment Form --}}
                <div class="lg:col-span-7 space-y-8">
                    
                    {{-- Credit Card Visualization --}}
                    <div class="relative w-full max-w-md mx-auto aspect-[1.586/1] bg-gradient-to-tr from-slate-900 via-slate-800 to-teal-900 rounded-2xl p-6 text-white shadow-2xl overflow-hidden border border-white/10">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-teal-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute -left-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl"></div>
                        
                        <div class="flex justify-between items-start mb-8 relative z-10">
                            <div>
                                <p class="text-[10px] uppercase font-mono tracking-widest text-slate-400">Secure Payment Gateway</p>
                                <p class="font-outfit text-lg font-bold text-teal-400 mt-0.5">PayManager</p>
                            </div>
                            <svg class="h-8 w-12 text-slate-300" fill="currentColor" viewBox="0 0 24 24"><path d="M17 12H7v-2h10v2zm0 4H7v-2h10v2zm2-11H5c-1.11 0-1.99.89-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7c0-1.11-.9-2-2-2zm0 14H5V7h14v12z"/></svg>
                        </div>
                        
                        <div class="mb-6 relative z-10">
                            <p class="text-[9px] uppercase font-mono tracking-widest text-slate-400">Card Number</p>
                            <p class="text-xl font-bold font-mono tracking-widest text-white mt-1" x-text="cardNumber || '•••• •••• •••• ••••'"></p>
                        </div>
                        
                        <div class="flex justify-between items-end relative z-10">
                            <div>
                                <p class="text-[8px] uppercase font-mono tracking-widest text-slate-400">Cardholder</p>
                                <p class="text-sm font-bold uppercase font-sans tracking-wide text-white mt-0.5 truncate max-w-[200px]" x-text="cardName || 'CARDHOLDER NAME'"></p>
                            </div>
                            <div class="flex gap-4">
                                <div>
                                    <p class="text-[8px] uppercase font-mono tracking-widest text-slate-400">Expires</p>
                                    <p class="text-xs font-bold font-mono text-white mt-0.5" x-text="cardExpiry || 'MM/YY'"></p>
                                </div>
                                <div>
                                    <p class="text-[8px] uppercase font-mono tracking-widest text-slate-400">CVV</p>
                                    <p class="text-xs font-bold font-mono text-white mt-0.5" x-text="cardCvv || '•••'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Fields --}}
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider font-mono">Authorize Disbursement</h3>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Secure SSL</span>
                        </div>
                        
                        <div class="p-6 md:p-8">
                            <form method="POST" action="{{ route('transactions.process-checkout', $transaction) }}">
                                @csrf
                                
                                <div class="grid grid-cols-2 gap-6 mb-8">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cardholder Name</label>
                                        <input type="text" x-model="cardName" placeholder="John Doe" required
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-semibold bg-slate-50 focus:bg-white transition-colors">
                                    </div>
                                    
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Card Number</label>
                                        <input type="text" x-model="cardNumber" placeholder="4111 2222 3333 4444" required
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-bold font-mono bg-slate-50 focus:bg-white transition-colors">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Expiry Date</label>
                                        <input type="text" x-model="cardExpiry" placeholder="12/28" required
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-bold font-mono bg-slate-50 focus:bg-white transition-colors">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">CVV</label>
                                        <input type="password" x-model="cardCvv" placeholder="123" required max="4"
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-bold font-mono bg-slate-50 focus:bg-white transition-colors">
                                    </div>
                                </div>
                                
                                {{-- Simulator Section --}}
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-8">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="p-1.5 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                        </div>
                                        <h4 class="font-bold text-sm text-slate-800">Gateway Simulator Options</h4>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <label class="flex items-center justify-between p-3.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-emerald-500 transition-colors shadow-sm">
                                            <div class="flex items-center gap-3">
                                                <input type="radio" name="simulate_status" value="success" x-model="simulateStatus" class="text-teal-600 focus:ring-teal-500">
                                                <span class="text-sm font-bold text-slate-700">Simulate Success</span>
                                            </div>
                                            <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                                        </label>
                                        
                                        <label class="flex items-center justify-between p-3.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-rose-500 transition-colors shadow-sm">
                                            <div class="flex items-center gap-3">
                                                <input type="radio" name="simulate_status" value="failed" x-model="simulateStatus" class="text-teal-600 focus:ring-teal-500">
                                                <span class="text-sm font-bold text-slate-700">Simulate Failure</span>
                                            </div>
                                            <span class="w-2.5 h-2.5 bg-rose-500 rounded-full"></span>
                                        </label>
                                    </div>
                                    
                                    <div x-show="simulateStatus === 'failed'" class="slide-in">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Failure Reason</label>
                                        <select name="failure_reason" x-model="failureReason"
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent text-slate-700 font-medium bg-white">
                                            <option value="Insufficient funds">Insufficient funds</option>
                                            <option value="Card expired">Card expired</option>
                                            <option value="Authentication failed (OTP)">Authentication failed (OTP)</option>
                                            <option value="Daily limit exceeded">Daily limit exceeded</option>
                                            <option value="Restricted card status">Restricted card status</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                                    <button type="submit"
                                            class="btn-primary w-full flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30 hover:scale-[1.01] transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        Confirm & Authorize ₹{{ number_format($transaction->amount, 2) }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                {{-- Right Side: Details & Explanation --}}
                <div class="lg:col-span-5 space-y-6">
                    
                    {{-- Beneficiary Details --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mb-4">Beneficiary Details</h4>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-700 text-lg font-bold">
                                {{ strtoupper(substr($transaction->employee->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <h5 class="text-base font-bold text-slate-800">{{ $transaction->employee->user->name ?? 'Unknown' }}</h5>
                                <p class="text-xs text-slate-500 font-medium">{{ $transaction->employee->designation }}</p>
                                <p class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $transaction->employee->employee_code }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-100">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-mono">Bank Name</p>
                                <p class="text-xs font-bold text-slate-700 mt-0.5">{{ $transaction->bank_name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-mono">Account Number</p>
                                <p class="text-xs font-bold text-slate-700 mt-0.5 font-mono">{{ $transaction->account_number ?? '—' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[10px] text-slate-400 uppercase font-mono">IFSC Code</p>
                                <p class="text-xs font-bold text-slate-700 mt-0.5 font-mono">{{ $transaction->ifsc_code ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Linked Payroll Record Explanation --}}
                    @if($transaction->payrollRecord)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm relative overflow-hidden">
                            <div class="absolute -right-12 -top-12 w-28 h-28 bg-emerald-500/5 rounded-full blur-2xl"></div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Linked Payroll Ledger</h4>
                                <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2.5 py-1 rounded-md border border-teal-100">
                                    {{ \Carbon\Carbon::create()->month($transaction->payrollRecord->month)->format('F') }} {{ $transaction->payrollRecord->year }}
                                </span>
                            </div>

                            {{-- Component breakdown --}}
                            <div class="space-y-4">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5 font-mono">Salary Components Breakdown</p>
                                    
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500">Basic Pay</span>
                                            <span class="font-bold text-slate-700 font-mono">₹{{ number_format($transaction->payrollRecord->basic, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500">HRA Allowance</span>
                                            <span class="font-bold text-slate-700 font-mono">₹{{ number_format($transaction->payrollRecord->hra, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500">Other Allowances</span>
                                            <span class="font-bold text-slate-700 font-mono">₹{{ number_format($transaction->payrollRecord->allowances, 2) }}</span>
                                        </div>
                                        @if($transaction->payrollRecord->leave_deduction > 0)
                                            <div class="flex justify-between items-center text-xs text-rose-600 font-medium">
                                                <span>Leave Deductions ({{ $transaction->payrollRecord->leave_days_taken }} days)</span>
                                                <span class="font-bold font-mono">-₹{{ number_format($transaction->payrollRecord->leave_deduction, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="border-t border-slate-200/50 my-1"></div>
                                        <div class="flex justify-between items-center text-xs font-bold text-slate-800">
                                            <span>Gross Earnings</span>
                                            <span class="font-mono">₹{{ number_format($transaction->payrollRecord->gross, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-rose-50/30 border border-rose-100/50 rounded-xl p-4">
                                    <p class="text-xs font-bold text-rose-500 uppercase tracking-wider mb-2.5 font-mono">Deductions Breakdown</p>
                                    
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500">Provident Fund (PF)</span>
                                            <span class="font-bold text-slate-700 font-mono">₹{{ number_format($transaction->payrollRecord->pf, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500">Employee State Insurance (ESI)</span>
                                            <span class="font-bold text-slate-700 font-mono">₹{{ number_format($transaction->payrollRecord->esi, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500">Tax Deducted at Source (TDS)</span>
                                            <span class="font-bold text-slate-700 font-mono">₹{{ number_format($transaction->payrollRecord->tds, 2) }}</span>
                                        </div>
                                        <div class="border-t border-rose-200/30 my-1"></div>
                                        <div class="flex justify-between items-center text-xs font-bold text-rose-600">
                                            <span>Total Deductions</span>
                                            <span class="font-mono">₹{{ number_format($transaction->payrollRecord->total_deductions, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Math formula callout --}}
                                <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-4 text-xs space-y-2">
                                    <p class="font-bold text-indigo-800 flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        How is this Net Salary calculated?
                                    </p>
                                    <p class="text-slate-600 leading-relaxed font-medium">
                                        The disbursement amount represents the employee's net earnings after subtracting all tax and state deductions.
                                    </p>
                                    <div class="font-mono bg-white border border-indigo-100 p-2.5 rounded-lg text-indigo-700 text-[10px] space-y-1">
                                        <div class="flex justify-between font-bold">
                                            <span>Gross Pay:</span>
                                            <span>Basic + HRA + Allowances - Leaves</span>
                                        </div>
                                        <div class="flex justify-between font-bold">
                                            <span>Deductions:</span>
                                            <span>PF + ESI + TDS</span>
                                        </div>
                                        <div class="border-t border-indigo-100 my-1"></div>
                                        <div class="flex justify-between font-extrabold text-teal-600">
                                            <span>Net Salary:</span>
                                            <span>Gross Pay - Deductions</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center bg-teal-50 border border-teal-100 p-4 rounded-xl">
                                    <div>
                                        <p class="text-[10px] text-teal-700 font-bold uppercase tracking-wider font-mono">Disbursement Amount</p>
                                        <p class="text-xs text-slate-500 font-medium mt-0.5">Exactly matches payroll Net Salary</p>
                                    </div>
                                    <p class="text-2xl font-black text-teal-600 font-mono">₹{{ number_format($transaction->payrollRecord->net_salary, 0) }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Generic Explanation when no Payroll record is linked --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mb-4">Transaction Ledger Info</h4>
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-xs text-amber-700 space-y-2">
                                <p class="font-bold flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    Unlinked Ledger Alert
                                </p>
                                <p class="leading-relaxed font-medium">
                                    This disbursement transaction is not linked to any specific monthly payroll record. It represents a manual fund transfer.
                                </p>
                                <p class="leading-relaxed font-medium">
                                    We highly recommend selecting a <strong>Linked Payroll Ledger</strong> during transaction creation if this payment represents monthly compensation, as it automatically updates the employee's payroll status to Paid upon successful checkout.
                                </p>
                            </div>
                        </div>
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
