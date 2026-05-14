<x-app-layout>

    <div class="min-h-screen bg-gray-50">

        {{-- Page Header --}}
        <div class="bg-white border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-5">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Payment Platform</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ now()->format('l, d F Y') }} &mdash; Welcome, {{ auth()->user()->name }}
                    </p>
                </div>
                <a href="{{ route('payroll.create') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    + Generate Payroll
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-4 gap-5 mb-8">

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-3">Total Employees</p>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalEmployees }}</p>
                    <p class="text-xs text-green-500 mt-2 font-medium">Active workforce</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-3">Monthly Payroll</p>
                    <p class="text-4xl font-bold text-purple-600">₹{{ number_format($monthlyPayroll, 0) }}</p>
                    <p class="text-xs text-green-500 mt-2 font-medium">Current month total</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-3">Pending Approvals</p>
                    <p class="text-4xl font-bold text-yellow-500">{{ $pendingPayrolls }}</p>
                    <p class="text-xs text-red-400 mt-2 font-medium">Needs attention</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-3">Paid This Month</p>
                    <p class="text-4xl font-bold text-green-600">{{ $paidThisMonth }}</p>
                    <p class="text-xs text-gray-400 mt-2 font-medium">of {{ $totalEmployees }} employees</p>
                </div>

            </div>

            {{-- MIDDLE ROW --}}
            <div class="grid grid-cols-3 gap-6 mb-6">

                {{-- EMPLOYEE TABLE --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-base font-semibold text-gray-800">Recent Employees</h3>
                        <a href="{{ route('employees.index') }}"
                            class="text-xs text-blue-600 hover:underline font-medium">View all →</a>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-medium text-gray-400 uppercase pb-3">Employee</th>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase pb-3">Department</th>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase pb-3">Role</th>
                                <th class="text-left text-xs font-medium text-gray-400 uppercase pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEmployees as $emp)
                                <tr class="border-b border-gray-50 hover:bg-gray-50">
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-semibold flex-shrink-0">
                                                {{ strtoupper(substr($emp->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">{{ $emp->user->name }}</p>
                                                <p class="text-xs text-gray-400 font-mono">{{ $emp->employee_code }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-sm text-gray-500">{{ $emp->department->name }}</td>
                                    <td class="py-3 text-sm text-gray-500">{{ $emp->designation }}</td>
                                    <td class="py-3">
                                        @if($emp->status === 'active')
                                            <span
                                                class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">Active</span>
                                        @elseif($emp->status === 'inactive')
                                            <span
                                                class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">Inactive</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-medium">Terminated</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400 text-sm">
                                        No employees yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- RIGHT SIDEBAR --}}
                <div class="flex flex-col gap-5">

                    {{-- QUICK ACTIONS --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-base font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('employees.create') }}"
                                class="flex flex-col items-center justify-center bg-blue-50 border border-blue-100 rounded-xl p-4 hover:bg-blue-100 transition text-center">
                                <span class="text-2xl mb-2">👤</span>
                                <p class="text-xs font-semibold text-blue-700">Add Employee</p>
                            </a>
                            <a href="{{ route('payroll.create') }}"
                                class="flex flex-col items-center justify-center bg-purple-50 border border-purple-100 rounded-xl p-4 hover:bg-purple-100 transition text-center">
                                <span class="text-2xl mb-2">💰</span>
                                <p class="text-xs font-semibold text-purple-700">Run Payroll</p>
                            </a>
                            <a href="{{ route('salary-structures.create') }}"
                                class="flex flex-col items-center justify-center bg-green-50 border border-green-100 rounded-xl p-4 hover:bg-green-100 transition text-center">
                                <span class="text-2xl mb-2">📊</span>
                                <p class="text-xs font-semibold text-green-700">Set Salary</p>
                            </a>
                            <a href="{{ route('departments.create') }}"
                                class="flex flex-col items-center justify-center bg-orange-50 border border-orange-100 rounded-xl p-4 hover:bg-orange-100 transition text-center">
                                <span class="text-2xl mb-2">🏢</span>
                                <p class="text-xs font-semibold text-orange-700">Add Dept</p>
                            </a>
                        </div>
                    </div>

                    {{-- DEPARTMENT OVERVIEW --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-base font-semibold text-gray-800 mb-4">Departments</h3>
                        @forelse($departments as $dept)
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm text-gray-600 font-medium">{{ $dept->name }}</span>
                                    <span class="text-xs text-gray-400 font-semibold">{{ $dept->employees_count }}
                                        staff</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full"
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

            {{-- BOTTOM ROW --}}
            <div class="grid grid-cols-2 gap-6">

                {{-- RECENT PAYROLL --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-base font-semibold text-gray-800">Recent Payroll</h3>
                        <a href="{{ route('payroll.index') }}"
                            class="text-xs text-blue-600 hover:underline font-medium">View all →</a>
                    </div>
                    @forelse($recentPayrolls as $record)
                        <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $record->employee->user->name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ DateTime::createFromFormat('!m', $record->month)->format('F') }}
                                    {{ $record->year }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">₹{{ number_format($record->net_salary, 0) }}</p>
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
                        <p class="text-sm text-gray-400 text-center py-6">No payroll records yet.</p>
                    @endforelse
                </div>

                {{-- DEDUCTION SUMMARY --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-5">Deduction Summary</h3>

                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <p class="text-sm text-gray-600">Provident Fund (PF)</p>
                        <p class="text-sm font-bold text-red-500">₹{{ number_format($totalPF, 0) }}</p>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <p class="text-sm text-gray-600">ESI</p>
                        <p class="text-sm font-bold text-red-500">₹{{ number_format($totalESI, 0) }}</p>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <p class="text-sm text-gray-600">TDS</p>
                        <p class="text-sm font-bold text-red-500">₹{{ number_format($totalTDS, 0) }}</p>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <p class="text-sm text-gray-600">Total Gross Paid</p>
                        <p class="text-sm font-bold text-blue-600">₹{{ number_format($totalGross, 0) }}</p>
                    </div>
                    <div class="flex justify-between items-center py-4 bg-green-50 rounded-xl px-4 mt-3">
                        <p class="text-sm font-bold text-gray-800">Total Net Paid</p>
                        <p class="text-xl font-bold text-green-600">₹{{ number_format($totalNet, 0) }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>