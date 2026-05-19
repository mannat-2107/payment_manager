<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">
        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-4xl mx-auto flex items-center gap-4">
                <a href="{{ route('transactions.index') }}" class="p-2 bg-slate-50 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">New Transaction</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Initiate a secure payment disbursement</p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 slide-in">
            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl mb-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-1.5 bg-rose-100 rounded-lg">
                            <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="font-bold text-sm">Please correct the following errors:</p>
                    </div>
                    <ul class="list-disc pl-12 text-sm font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            {{-- Employee --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Beneficiary Employee <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <select name="employee_id" required class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-700 font-medium bg-slate-50 hover:bg-white transition-colors cursor-pointer appearance-none">
                                        <option value="" disabled {{ old('employee_id') ? '' : 'selected' }}>Select Beneficiary</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                                {{ $emp->user->name }} — {{ $emp->employee_code }} ({{ $emp->designation }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Payroll Record --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Linked Payroll Ledger <span class="text-slate-400 font-normal lowercase tracking-normal">(optional)</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <select name="payroll_record_id" class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-700 font-medium bg-slate-50 hover:bg-white transition-colors cursor-pointer appearance-none">
                                        <option value="">No linked ledger</option>
                                        @foreach($payrollRecords as $record)
                                            <option value="{{ $record->id }}" {{ old('payroll_record_id') == $record->id ? 'selected' : '' }}>
                                                {{ $record->employee?->user?->name ?? 'Unknown' }} —
                                                {{ DateTime::createFromFormat('!m', $record->month)->format('M') }} {{ $record->year }} —
                                                ₹{{ number_format($record->net_salary, 0) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Disbursement Amount <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold">₹</span>
                                    </div>
                                    <input type="number" name="amount" value="{{ old('amount') }}" required min="1" step="0.01"
                                        placeholder="0.00"
                                        class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-bold font-mono bg-slate-50 focus:bg-white transition-colors placeholder-slate-300">
                                </div>
                            </div>

                            {{-- Method --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Payment Channel <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <select name="payment_method" required class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-700 font-medium bg-slate-50 hover:bg-white transition-colors cursor-pointer appearance-none">
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Wire Transfer</option>
                                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Physical Cheque</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash Disbursement</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Remarks --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Transaction Notes</label>
                                <textarea name="remarks" rows="3"
                                    placeholder="Add any internal processing notes or context here..."
                                    class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-700 font-medium bg-slate-50 focus:bg-white transition-colors resize-none">{{ old('remarks') }}</textarea>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 mb-8 flex items-start gap-4">
                            <div class="p-2 bg-indigo-100 rounded-lg flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-indigo-800">Secure Initiation Process</p>
                                <p class="text-sm font-medium text-indigo-600 mt-1">This will generate a unique `TRx ID` and set the initial status to <span class="bg-indigo-100 px-1.5 py-0.5 rounded text-indigo-700 font-bold text-xs uppercase tracking-wider">Initiated</span>. You must manually advance the status in the ledger after banking confirmation.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                            <button type="submit"
                                    class="btn-primary flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Execute Transaction
                            </button>
                            <a href="{{ route('transactions.index') }}"
                               class="px-8 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>