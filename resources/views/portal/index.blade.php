<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
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

    {{-- Profile Header --}}
    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($employee->user?->name ?? 'Unknown', 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $employee->user?->name ?? 'Unknown' }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        {{ $employee->designation }} &bull; {{ $employee->department->name }} &bull;
                        <span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded">{{ $employee->employee_code }}</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Joined {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                    </p>
                </div>
                <div class="ml-auto">
                    @if($employee->status === 'active')
                        <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-sm px-4 py-2 rounded-full font-medium">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>Active Employee
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 text-sm px-4 py-2 rounded-full font-medium">
                            {{ ucfirst($employee->status) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mb-8">
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total Earned</p>
                <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalEarned, 0) }}</p>
                <p class="text-xs text-green-500 mt-1">All successful payments</p>
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

        {{-- Leave Quick Actions --}}
        @php
            $leaveEmployee = $employee;
            $pendingLeaves  = \App\Models\LeaveRequest::where('employee_id', $leaveEmployee->id)->where('status','pending')->count();
            $approvedLeaves = \App\Models\LeaveRequest::where('employee_id', $leaveEmployee->id)->where('status','approved')->whereYear('from_date', now()->year)->sum('days');
        @endphp
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="{{ route('leave.my-leaves') }}"
                class="flex items-center gap-3 bg-white border border-gray-100 rounded-2xl px-5 py-4 stat-card hover:border-teal-300 transition-colors group">
                <div class="text-2xl">🌴</div>
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Leave Balance</p>
                    <p class="font-bold text-gray-800">View My Leaves
                        @if($pendingLeaves > 0)
                        <span class="ml-1 text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">{{ $pendingLeaves }} pending</span>
                        @endif
                    </p>
                </div>
            </a>
            <a href="{{ route('leave.create') }}"
                class="flex items-center gap-3 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl px-5 py-4 stat-card transition-colors">
                <div class="text-2xl">✍️</div>
                <div>
                    <p class="text-xs text-teal-200 font-medium uppercase tracking-wide">New Request</p>
                    <p class="font-bold">Apply for Leave</p>
                </div>
            </a>
            @if($approvedLeaves > 0)
            <div class="flex items-center gap-3 bg-white border border-gray-100 rounded-2xl px-5 py-4">
                <div class="text-2xl">📊</div>
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">This Year</p>
                    <p class="font-bold text-gray-800">{{ $approvedLeaves }} days taken</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Profile and Salary Row --}}
        <div class="grid grid-cols-2 gap-6 mb-6">

            {{-- Profile Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-2">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </h3>
                <div class="space-y-1">
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Email</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Phone</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->phone ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Department</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->department->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Designation</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->designation }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Bank Name</span>
                        <span class="text-sm font-medium text-gray-800">{{ $employee->bank_name ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Account Number</span>
                        <span class="text-sm font-mono text-gray-800">{{ $employee->account_number ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-sm text-gray-400">IFSC Code</span>
                        <span class="text-sm font-mono text-gray-800">{{ $employee->ifsc_code ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Salary Structure --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    My Salary Structure
                </h3>
                @if($employee->salaryStructures->count() > 0)
                @php $salary = $employee->salaryStructures->last(); @endphp
                <div class="space-y-1">
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Basic Salary</span>
                        <span class="text-sm font-medium text-gray-800">₹{{ number_format($salary->basic, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">HRA</span>
                        <span class="text-sm font-medium text-gray-800">₹{{ number_format($salary->hra, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Allowances</span>
                        <span class="text-sm font-medium text-gray-800">₹{{ number_format($salary->allowances, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">Gross Salary</span>
                        <span class="text-sm font-semibold text-gray-800">₹{{ number_format($salary->calculateGross(), 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">PF ({{ $salary->pf_percentage }}%)</span>
                        <span class="text-sm font-medium text-red-500">- ₹{{ number_format(($salary->basic * $salary->pf_percentage) / 100, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-400">ESI ({{ $salary->esi_percentage }}%)</span>
                        <span class="text-sm font-medium text-red-500">- ₹{{ number_format(($salary->calculateGross() * $salary->esi_percentage) / 100, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 mt-2 bg-green-50 rounded-xl px-4">
                        <span class="text-sm font-bold text-gray-800">Net Salary</span>
                        <span class="text-xl font-bold text-green-600">₹{{ number_format($salary->calculateNet(), 0) }}</span>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">No salary structure assigned yet.</p>
                    <p class="text-xs text-gray-300 mt-1">Contact your HR department.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Payroll History --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6 ani-3">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">My Payroll History</h3>
                <span class="text-xs text-gray-400">{{ $payrolls->count() }} records</span>
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
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Paid
                                </span>
                            @elseif($payroll->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Approved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('payslip.download.own', $payroll) }}"
                               class="inline-flex items-center gap-1.5 text-xs bg-blue-50 border border-blue-200 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
                            No payroll records yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Transaction History --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-4">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">My Payment History</h3>
                <span class="text-xs text-gray-400">{{ $transactions->count() }} transactions</span>
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
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">
                            ₹{{ number_format($txn->amount, 0) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 capitalize">
                            {{ str_replace('_', ' ', $txn->payment_method) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $txn->created_at->format('d M Y') }}
                        </td>
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
                            @elseif($txn->status === 'failed')
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Failed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Reversed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('transactions.receipt.own', $txn) }}"
                               class="inline-flex items-center gap-1.5 text-xs bg-purple-50 border border-purple-200 text-purple-600 px-3 py-1.5 rounded-lg hover:bg-purple-100 transition font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Receipt
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
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