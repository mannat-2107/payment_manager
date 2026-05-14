<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.ani-1{animation:fadeInUp .4s ease both}
.ani-2{animation:fadeInUp .4s .1s ease both}
</style>

<div class="min-h-screen bg-gray-50">

    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
        <div class="max-w-3xl mx-auto flex items-center gap-4">
            <a href="{{ route('transactions.index') }}"
               class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">New Transaction</h2>
                <p class="text-sm text-gray-400 mt-0.5">Initiate a new payment transaction</p>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 ani-1">
            @foreach($errors->all() as $error)
                <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 p-8 ani-1">
            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf

                {{-- Employee --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Employee</label>
                    <select name="employee_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->user->name }} — {{ $emp->employee_code }} ({{ $emp->designation }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payroll Record --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Linked Payroll Record
                        <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <select name="payroll_record_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">No payroll record</option>
                        @foreach($payrollRecords as $record)
                            <option value="{{ $record->id }}">
                                {{ $record->employee->user->name }} —
                                {{ DateTime::createFromFormat('!m', $record->month)->format('F') }}
                                {{ $record->year }} — ₹{{ number_format($record->net_salary, 0) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Amount and Method --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Amount (₹)</label>
                        <input type="number" name="amount" value="{{ old('amount') }}"
                               placeholder="Enter amount"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               step="0.01" min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Method</label>
                        <select name="payment_method"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cheque"        {{ old('payment_method') == 'cheque'        ? 'selected' : '' }}>Cheque</option>
                            <option value="cash"          {{ old('payment_method') == 'cash'          ? 'selected' : '' }}>Cash</option>
                        </select>
                    </div>
                </div>

                {{-- Remarks --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                    <textarea name="remarks" rows="3"
                              placeholder="Optional notes about this transaction..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('remarks') }}</textarea>
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-700">Transaction will be initiated</p>
                            <p class="text-xs text-blue-500 mt-0.5">A unique reference number will be auto-generated. You can update the status after initiation.</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-8 py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                        Initiate Transaction
                    </button>
                    <a href="{{ route('transactions.index') }}"
                       class="bg-gray-100 text-gray-600 px-8 py-3 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>