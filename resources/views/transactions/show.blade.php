<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.ani-1{animation:fadeInUp .4s ease both}
.ani-2{animation:fadeInUp .4s .1s ease both}
.ani-3{animation:fadeInUp .4s .2s ease both}
</style>

<div class="min-h-screen bg-gray-50">

    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <a href="{{ route('transactions.index') }}"
               class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Transaction Details</h2>
                <p class="text-sm text-gray-400 font-mono mt-0.5">{{ $transaction->transaction_reference }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-3 gap-6">

            {{-- Left Column --}}
            <div class="col-span-2 flex flex-col gap-6">

                {{-- Status Card --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg font-bold">
                                {{ strtoupper(substr($transaction->employee->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $transaction->employee->user->name }}</h3>
                                <p class="text-sm text-gray-400">{{ $transaction->employee->designation }}</p>
                                <p class="text-xs font-mono text-gray-400">{{ $transaction->employee->employee_code }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-gray-800">₹{{ number_format($transaction->amount, 0) }}</p>
                            @if($transaction->status === 'success')
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-3 py-1.5 rounded-full font-medium mt-2">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Success
                                </span>
                            @elseif($transaction->status === 'processing')
                                <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-3 py-1.5 rounded-full font-medium mt-2">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>Processing
                                </span>
                            @elseif($transaction->status === 'initiated')
                                <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-full font-medium mt-2">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Initiated
                                </span>
                            @elseif($transaction->status === 'failed')
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs px-3 py-1.5 rounded-full font-medium mt-2">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Failed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-medium mt-2">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Reversed
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Transaction Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-2">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4">Transaction Information</h4>
                    <div class="grid grid-cols-2 gap-y-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">Reference</p>
                            <p class="text-sm font-mono font-medium text-gray-800">{{ $transaction->transaction_reference }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">Payment Method</p>
                            <p class="text-sm font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">Initiated On</p>
                            <p class="text-sm font-medium text-gray-800">{{ $transaction->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">Paid On</p>
                            <p class="text-sm font-medium text-gray-800">{{ $transaction->paid_at ? $transaction->paid_at->format('d M Y, h:i A') : '—' }}</p>
                        </div>
                        @if($transaction->remarks)
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 uppercase mb-1">Remarks</p>
                            <p class="text-sm text-gray-600">{{ $transaction->remarks }}</p>
                        </div>
                        @endif
                        @if($transaction->failure_reason)
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 uppercase mb-1">Failure Reason</p>
                            <p class="text-sm text-red-500">{{ $transaction->failure_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Bank Details --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-3">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4">Bank Details</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">Bank Name</p>
                            <p class="text-sm font-medium text-gray-800">{{ $transaction->bank_name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">Account Number</p>
                            <p class="text-sm font-medium text-gray-800 font-mono">{{ $transaction->account_number ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase mb-1">IFSC Code</p>
                            <p class="text-sm font-medium text-gray-800 font-mono">{{ $transaction->ifsc_code ?? '—' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column --}}
            <div class="flex flex-col gap-6">

                {{-- Update Status --}}
                @if($transaction->status !== 'success')
                <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-1">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4">Update Status</h4>
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                        @csrf @method('PUT')
                        <select name="status"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                            <option value="initiated"  {{ $transaction->status == 'initiated'  ? 'selected' : '' }}>Initiated</option>
                            <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="success"    {{ $transaction->status == 'success'    ? 'selected' : '' }}>Success</option>
                            <option value="failed"     {{ $transaction->status == 'failed'     ? 'selected' : '' }}>Failed</option>
                            <option value="reversed"   {{ $transaction->status == 'reversed'   ? 'selected' : '' }}>Reversed</option>
                        </select>
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                            Update Status
                        </button>
                    </form>
                </div>
                @endif

                {{-- Retry --}}
                @if($transaction->status === 'failed')
                <div class="bg-orange-50 border border-orange-100 rounded-2xl p-6 ani-2">
                    <h4 class="text-sm font-semibold text-orange-700 mb-2">Payment Failed</h4>
                    <p class="text-xs text-orange-500 mb-4">This transaction failed. You can retry it to create a new transaction with the same details.</p>
                    <form method="POST" action="{{ route('transactions.retry', $transaction) }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-orange-500 text-white py-3 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                            Retry Transaction
                        </button>
                    </form>
                </div>
                @endif

                {{-- Payroll Record --}}
                @if($transaction->payrollRecord)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-3">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4">Linked Payroll</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Month</span>
                            <span class="font-medium text-gray-800">
                                {{ DateTime::createFromFormat('!m', $transaction->payrollRecord->month)->format('F') }}
                                {{ $transaction->payrollRecord->year }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Net Salary</span>
                            <span class="font-medium text-green-600">₹{{ number_format($transaction->payrollRecord->net_salary, 0) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Status</span>
                            <span class="font-medium text-gray-800 capitalize">{{ $transaction->payrollRecord->status }}</span>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
</x-app-layout>