<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .4
            }
        }

        .ani-1 {
            animation: fadeInUp .4s ease both
        }

        .ani-2 {
            animation: fadeInUp .4s .1s ease both
        }

        .ani-3 {
            animation: fadeInUp .4s .2s ease both
        }

        .ani-4 {
            animation: fadeInUp .4s .3s ease both
        }

        .ani-5 {
            animation: fadeInUp .4s .4s ease both
        }

        .ani-6 {
            animation: fadeInUp .4s .5s ease both
        }

        .pulse {
            animation: pulse 2s infinite
        }

        .stat-card {
            transition: transform .2s, box-shadow .2s
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08)
        }

        .row-hover {
            transition: background .15s
        }

        .row-hover:hover {
            background: #f8fafc
        }

        .quick-btn {
            transition: transform .15s, box-shadow .15s
        }

        .quick-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08)
        }
    </style>

    <div class="min-h-screen bg-gray-50">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Payment Platform</h2>
                    <p class="text-sm text-gray-400 mt-1">
                        {{ now()->format('l, d F Y') }} &mdash; Welcome back, {{ auth()->user()->name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('transactions.create') }}"
                        class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Transaction
                    </a>
                    <a href="{{ route('payroll.create') }}"
                        class="bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-900 transition">
                        + Generate Payroll
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Top Stats --}}
            <div class="grid grid-cols-4 gap-5 mb-8">

                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Total Paid</p>
                        <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">₹{{ number_format($totalPaid, 0) }}</p>
                    <p class="text-xs text-green-500 mt-1 font-medium">Successful transactions</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Employees</p>
                        <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalEmployees }}</p>
                    <p class="text-xs text-purple-500 mt-1 font-medium">Active workforce</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Pending</p>
                        <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-500 pulse" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-yellow-500">{{ $totalPending }}</p>
                    <p class="text-xs text-yellow-500 mt-1 font-medium pulse">Needs attention</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Failed</p>
                        <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-red-500">{{ $totalFailed }}</p>
                    <p class="text-xs text-red-400 mt-1 font-medium">Retry needed</p>
                </div>

            </div>

            {{-- Middle Row --}}
            <div class="grid grid-cols-3 gap-6 mb-6">

                {{-- Recent Transactions --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden ani-2">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-800">Recent Transactions</h3>
                        <a href="{{ route('transactions.index') }}"
                            class="text-xs text-blue-600 hover:underline font-medium">View all →</a>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employee
                                </th>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Amount</th>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Method</th>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentTransactions as $txn)
                                <tr class="row-hover">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                                {{ strtoupper(substr($txn->employee->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $txn->employee->user->name }}</p>
                                                <p class="text-xs text-gray-400 font-mono">{{ $txn->transaction_reference }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="text-sm font-bold text-gray-800">₹{{ number_format($txn->amount, 0) }}</span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-500 capitalize">
                                        {{ str_replace('_', ' ', $txn->payment_method) }}
                                    </td>
                                    <td class="px-6 py-3">
                                        @if($txn->status === 'success')
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Success
                                            </span>
                                        @elseif($txn->status === 'processing')
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full pulse"></span>Processing
                                            </span>
                                        @elseif($txn->status === 'initiated')
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Initiated
                                            </span>
                                        @elseif($txn->status === 'failed')
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Failed
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Reversed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                                        No transactions yet.
                                        <a href="{{ route('transactions.create') }}"
                                            class="text-blue-600 hover:underline ml-1">Create one →</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Right Sidebar --}}
                <div class="flex flex-col gap-5">

                    {{-- Quick Actions --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('transactions.create') }}"
                                class="quick-btn flex flex-col items-center justify-center bg-blue-50 border border-blue-100 rounded-xl p-4 text-center">
                                <span class="text-2xl mb-2">💸</span>
                                <p class="text-xs font-semibold text-blue-700">New Payment</p>
                            </a>
                            <a href="{{ route('employees.create') }}"
                                class="quick-btn flex flex-col items-center justify-center bg-purple-50 border border-purple-100 rounded-xl p-4 text-center">
                                <span class="text-2xl mb-2">👤</span>
                                <p class="text-xs font-semibold text-purple-700">Add Employee</p>
                            </a>
                            <a href="{{ route('payroll.create') }}"
                                class="quick-btn flex flex-col items-center justify-center bg-green-50 border border-green-100 rounded-xl p-4 text-center">
                                <span class="text-2xl mb-2">📊</span>
                                <p class="text-xs font-semibold text-green-700">Run Payroll</p>
                            </a>
                            <a href="{{ route('salary-structures.create') }}"
                                class="quick-btn flex flex-col items-center justify-center bg-orange-50 border border-orange-100 rounded-xl p-4 text-center">
                                <span class="text-2xl mb-2">💰</span>
                                <p class="text-xs font-semibold text-orange-700">Set Salary</p>
                            </a>
                        </div>
                    </div>

                    {{-- Department Overview --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 ani-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4">Departments</h3>
                        @forelse($departments as $dept)
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-sm text-gray-600 font-medium">{{ $dept->name }}</span>
                                    <span class="text-xs text-gray-400 font-semibold">{{ $dept->employees_count }}
                                        staff</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full transition-all duration-700"
                                        style="width: {{ $totalEmployees > 0 ? ($dept->employees_count / $totalEmployees) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No departments yet.</p>
                        @endforelse
                    </div>

                </div>
            </div>

            {{-- Bottom Row --}}
            <div class="grid grid-cols-3 gap-6">

                {{-- Recent Employees --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-3">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-800">Recent Employees</h3>
                        <a href="{{ route('employees.index') }}"
                            class="text-xs text-blue-600 hover:underline font-medium">View all →</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentEmployees as $emp)
                            <div class="flex items-center justify-between px-6 py-3 row-hover">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($emp->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $emp->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $emp->department->name }}</p>
                                    </div>
                                </div>
                                @if($emp->status === 'active')
                                    <span
                                        class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Active</span>
                                @else
                                    <span
                                        class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full font-medium">{{ ucfirst($emp->status) }}</span>
                                @endif
                            </div>
                        @empty
                            <p class="px-6 py-6 text-sm text-gray-400 text-center">No employees yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Payroll --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-4">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-800">Recent Payroll</h3>
                        <a href="{{ route('payroll.index') }}"
                            class="text-xs text-blue-600 hover:underline font-medium">View all →</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentPayrolls as $record)
                            <div class="flex items-center justify-between px-6 py-3 row-hover">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $record->employee->user->name }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ DateTime::createFromFormat('!m', $record->month)->format('F') }}
                                        {{ $record->year }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-green-600">₹{{ number_format($record->net_salary, 0) }}
                                    </p>
                                    @if($record->status === 'paid')
                                        <span
                                            class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium">Paid</span>
                                    @elseif($record->status === 'approved')
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">Approved</span>
                                    @else
                                        <span
                                            class="bg-yellow-100 text-yellow-700 text-xs px-2 py-0.5 rounded-full font-medium">Pending</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="px-6 py-6 text-sm text-gray-400 text-center">No payroll records yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Deduction Summary --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 ani-5">
                    <h3 class="text-sm font-semibold text-gray-800 mb-5">Deduction Summary</h3>
                    <div class="space-y-1">
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <p class="text-sm text-gray-500">Provident Fund</p>
                            <p class="text-sm font-bold text-red-500">₹{{ number_format($totalPF, 0) }}</p>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <p class="text-sm text-gray-500">ESI</p>
                            <p class="text-sm font-bold text-red-500">₹{{ number_format($totalESI, 0) }}</p>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <p class="text-sm text-gray-500">TDS</p>
                            <p class="text-sm font-bold text-red-500">₹{{ number_format($totalTDS, 0) }}</p>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <p class="text-sm text-gray-500">Total Gross</p>
                            <p class="text-sm font-bold text-blue-600">₹{{ number_format($totalGross, 0) }}</p>
                        </div>
                        <div class="flex justify-between items-center py-4 bg-green-50 rounded-xl px-4 mt-2">
                            <p class="text-sm font-bold text-gray-800">Net Paid</p>
                            <p class="text-lg font-bold text-green-600">₹{{ number_format($totalNet, 0) }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>