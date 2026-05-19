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
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Payment Reports</h2>
                <p class="text-sm text-gray-400 mt-1">Monthly payment and payroll summary</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Filter --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-8 ani-1">
            <form method="GET" action="{{ route('reports.index') }}" class="flex gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 uppercase">Month</label>
                    <select name="month" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 uppercase">Year</label>
                    <select name="year" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                    Generate Report
                </button>
            </form>
        </div>

        {{-- Report Title --}}
        <div class="mb-6 ani-1">
            <h3 class="text-lg font-semibold text-gray-800">
                Report for {{ $months[$month] }} {{ $year }}
            </h3>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-5 mb-8">

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Total Gross</p>
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">₹{{ number_format($totalGross, 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total gross salary</p>
            </div>

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Total Deductions</p>
                    <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-red-500">₹{{ number_format($totalDeductions, 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">PF + ESI + TDS</p>
            </div>

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Net Payable</p>
                    <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalNet, 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total net salary</p>
            </div>

        </div>

        {{-- Transaction Stats --}}
        <div class="grid grid-cols-3 gap-5 mb-8">
            <div class="bg-green-50 border border-green-100 rounded-2xl p-5 ani-2">
                <p class="text-xs font-medium text-green-600 uppercase tracking-widest mb-2">Amount Paid</p>
                <p class="text-2xl font-bold text-green-700">₹{{ number_format($totalPaid, 0) }}</p>
                <p class="text-xs text-green-500 mt-1">Successful transactions</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5 ani-3">
                <p class="text-xs font-medium text-yellow-600 uppercase tracking-widest mb-2">Pending</p>
                <p class="text-2xl font-bold text-yellow-700">{{ $totalPending }}</p>
                <p class="text-xs text-yellow-500 mt-1">Awaiting processing</p>
            </div>
            <div class="bg-red-50 border border-red-100 rounded-2xl p-5 ani-4">
                <p class="text-xs font-medium text-red-600 uppercase tracking-widest mb-2">Failed</p>
                <p class="text-2xl font-bold text-red-700">{{ $totalFailed }}</p>
                <p class="text-xs text-red-500 mt-1">Need retry</p>
            </div>
        </div>

        {{-- Department Summary --}}
        @if($deptSummary->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6 ani-3">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Department-wise Summary</h3>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Department</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employees</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Total Gross</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Total Net</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($deptSummary as $dept => $data)
                    <tr class="row-hover">
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">{{ $dept }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                {{ $data['count'] }} employees
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            ₹{{ number_format($data['gross'], 0) }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">
                            ₹{{ number_format($data['net'], 0) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Employee Payroll Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-4">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-800">Employee Payroll Details</h3>
                <span class="text-xs text-gray-400">{{ $payrollRecords->count() }} records</span>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employee</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Department</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Gross</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Deductions</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Net Salary</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Payslip</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payrollRecords as $record)
                    <tr class="row-hover">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($record->employee?->user?->name ?? 'Unknown', 0, 2)) }}
                                </div>
                                <p class="text-sm font-semibold text-gray-800">{{ $record->employee?->user?->name ?? 'Unknown' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $record->employee->department->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">₹{{ number_format($record->gross, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-red-500 font-medium">₹{{ number_format($record->total_deductions, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-green-600 font-bold">₹{{ number_format($record->net_salary, 0) }}</td>
                        <td class="px-6 py-4">
                            @if($record->status === 'paid')
                                <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Paid</span>
                            @elseif($record->status === 'approved')
                                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">Approved</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('payslip.download', $record) }}"
                               class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-700 font-medium hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <p class="text-gray-400 text-sm">No payroll records for {{ $months[$month] }} {{ $year }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
</x-app-layout>