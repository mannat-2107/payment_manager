<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.ani-1{animation:fadeInUp .4s ease both}
.ani-2{animation:fadeInUp .4s .1s ease both}
.ani-3{animation:fadeInUp .4s .2s ease both}
.ani-4{animation:fadeInUp .4s .3s ease both}
.stat-card{transition:transform .2s,box-shadow .2s}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.08)}
.row-hover{transition:background .15s}
.row-hover:hover{background:#f8fafc}
</style>

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
        <div class="max-w-7xl mx-auto flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl font-bold">
                {{ strtoupper(substr($employee->user->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $employee->user->name }}</h2>
                <p class="text-sm text-gray-400">{{ $employee->designation }} · {{ $employee->department->name }} · {{ $employee->employee_code }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Stats --}}
        <div class="grid grid-cols-4 gap-5 mb-8">
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total Earned</p>
                <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalEarned, 0) }}</p>
                <p class="text-xs text-green-500 mt-1">All time payments</p>
            </div>
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Payroll Records</p>
                <p class="text-3xl font-bold text-blue-600">{{ $payrolls->count() }}</p>
                <p class="text-xs text-blue-500 mt-1">Monthly records</p>
            </div>
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Transactions</p>
                <p class="text-3xl font-bold text-purple-600">{{ $transactions->count() }}</p>
                <p class="text-xs text-purple-500 mt-1">Payment history</p>
            </div>
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Latest Salary</p>
                <p class="text-3xl font-bold text-gray-800">
                    ₹{{ $payrolls->first() ? number_format($payrolls->first()->net_salary, 0) : '0' }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Most recent month</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">

            {{-- Profile Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-2">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">My Profile</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Email</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Phone</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->phone ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Date of Joining</span>
                        <span class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Bank Name</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->bank_name ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Account Number</span>
                        <span class="text-sm font-mono text-gray-800">{{ $employee->account_number ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-400">IFSC Code</span>
                        <span class="text-sm font-mono text-gray-800">{{ $employee->ifsc_code ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Salary Structure --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">My Salary Structure</h3>
                @if($employee->salaryStructures->count() > 0)
                @php $salary = $employee->salaryStructures->last(); @endphp
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Basic Salary</span>
                        <span class="text-sm font-medium text-gray-800">₹{{ number_format($salary->basic, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">HRA</span>
                        <span class="text-sm font-medium text-gray-800">₹{{ number_format($salary->hra, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Allowances</span>
                        <span class="text-sm font-medium text-gray-800">₹{{ number_format($salary->allowances, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">PF Deduction</span>
                        <span class="text-sm font-medium text-red-500">{{ $salary->pf_percentage }}%</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-400">ESI Deduction</span>
                        <span class="text-sm font-medium text-red-500">{{ $salary->esi_percentage }}%</span>
                    </div>
                    <div class="flex justify-between items-center py-3 bg-green-50 rounded-xl px-3">
                        <span class="text-sm font-bold text-gray-800">Net Salary</span>
                        <span class="text-lg font-bold text-green-600">₹{{ number_format($salary->calculateNet(), 0) }}</span>
                    </div>
                </div>
                @else
                <p class="text-sm text-gray-400">No salary structure assigned yet.</p>
                @endif
            </div>
        </div>

        {{-- Payroll History --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6 ani-3">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">My Payroll History</h3>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Month</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Gross</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Deductions</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Net Salary</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Payslip</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payrolls as $payroll)
                    <tr class="row-hover">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            {{ \Carbon\Carbon::create()->month($payroll->month)->format('F') }}
                            {{ $payroll->year }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">₹{{ number_format($payroll->gross, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-red-500">₹{{ number_format($payroll->total_deductions, 0) }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">₹{{ number_format($payroll->net_salary, 0) }}</td>
                        <td class="px-6 py-4">
                            @if($payroll->status === 'paid')
                                <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Paid</span>
                            @elseif($payroll->status === 'approved')
                                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">Approved</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('payslip.download', $payroll) }}"
                               class="text-xs bg-blue-50 border border-blue-200 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition font-medium">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">
                            No payroll records yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Transaction History --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-4">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">My Payment History</h3>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Reference</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Amount</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Method</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Date</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Receipt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $txn)
                    <tr class="row-hover">
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">
                                {{ $txn->transaction_reference }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">₹{{ number_format($txn->amount, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $txn->payment_method) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $txn->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($txn->status === 'success')
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Success
                                </span>
                            @elseif($txn->status === 'processing')
                                <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>Processing
                                </span>
                            @elseif($txn->status === 'initiated')
                                <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Initiated
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('transactions.receipt', $txn) }}"
                               class="text-xs bg-purple-50 border border-purple-200 text-purple-600 px-3 py-1.5 rounded-lg hover:bg-purple-100 transition font-medium">
                                Receipt
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">
                            No payment transactions yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
</x-app-layout>