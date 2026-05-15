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

        .ani-1 {
            animation: fadeInUp .4s ease both
        }

        .ani-2 {
            animation: fadeInUp .4s .1s ease both
        }

        .ani-3 {
            animation: fadeInUp .4s .2s ease both
        }

        .row-hover {
            transition: background .15s
        }

        .row-hover:hover {
            background: #f8fafc
        }

        .stat-card {
            transition: transform .2s, box-shadow .2s
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08)
        }
    </style>

    <div class="min-h-screen bg-gray-50">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Payroll Records</h2>
                    <p class="text-sm text-gray-400 mt-1">Manage monthly payroll for all employees</p>
                </div>
                <a href="{{ route('payroll.create') }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Generate Payroll
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 ani-1">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-4 gap-5 mb-8">
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total Records</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $records->count() }}</p>
                    <p class="text-xs text-blue-500 mt-1">All payroll entries</p>
                </div>
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total Net</p>
                    <p class="text-3xl font-bold text-green-600">₹{{ number_format($records->sum('net_salary'), 0) }}
                    </p>
                    <p class="text-xs text-green-500 mt-1">Total net salary</p>
                </div>
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Pending</p>
                    <p class="text-3xl font-bold text-yellow-500">{{ $records->where('status', 'pending')->count() }}</p>
                    <p class="text-xs text-yellow-500 mt-1">Awaiting approval</p>
                </div>
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Paid</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $records->where('status', 'paid')->count() }}</p>
                    <p class="text-xs text-blue-500 mt-1">Completed payments</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-3">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">All Payroll Records</h3>
                    <span class="text-sm text-gray-400">{{ $records->count() }} records</span>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employee</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Period</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Gross</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Deductions</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Net Salary</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($records as $record)
                            <tr class="row-hover">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($record->employee->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">
                                                {{ $record->employee->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $record->employee->designation }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ \Carbon\Carbon::create()->month($record->month)->format('F') }}
                                        {{ $record->year }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    ₹{{ number_format($record->gross, 0) }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-red-500">
                                    ₹{{ number_format($record->total_deductions, 0) }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">
                                    ₹{{ number_format($record->net_salary, 0) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($record->status === 'paid')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Paid
                                        </span>
                                    @elseif($record->status === 'approved')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Approved
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('payroll.show', $record) }}"
                                            class="text-xs bg-gray-50 border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition font-medium">
                                            View
                                        </a>
                                        <a href="{{ route('payslip.download', $record) }}"
                                            class="text-xs bg-green-50 border border-green-200 text-green-600 px-3 py-1.5 rounded-lg hover:bg-green-100 transition font-medium">
                                            Payslip
                                        </a>
                                        @if($record->status !== 'paid')
                                            <form method="POST" action="{{ route('payroll.update', $record) }}">
                                                @csrf @method('PUT')
                                                <select name="status" onchange="this.form.submit()"
                                                    class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                    <option value="pending" {{ $record->status == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="approved" {{ $record->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="paid" {{ $record->status == 'paid' ? 'selected' : '' }}>Paid
                                                    </option>
                                                </select>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <p class="text-gray-400 text-sm">No payroll records yet.</p>
                                    <a href="{{ route('payroll.create') }}"
                                        class="text-blue-600 text-sm hover:underline">Generate payroll →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>