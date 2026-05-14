<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payroll Records
            </h2>
            <a href="{{ route('payroll.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Generate Payroll
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Employee</th>
                            <th class="px-6 py-3">Month/Year</th>
                            <th class="px-6 py-3">Gross</th>
                            <th class="px-6 py-3">Deductions</th>
                            <th class="px-6 py-3">Net Salary</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($records as $record)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">
                                    {{ $record->employee->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ DateTime::createFromFormat('!m', $record->month)->format('F') }}
                                    {{ $record->year }}
                                </td>
                                <td class="px-6 py-4">₹{{ number_format($record->gross, 2) }}</td>
                                <td class="px-6 py-4 text-red-600">₹{{ number_format($record->total_deductions, 2) }}</td>
                                <td class="px-6 py-4 font-medium text-green-600">
                                    ₹{{ number_format($record->net_salary, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($record->status === 'paid')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Paid</span>
                                    @elseif($record->status === 'approved')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Approved</span>
                                    @else
                                        <span
                                            class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('payroll.show', $record) }}"
                                        class="text-gray-600 hover:underline">View</a>
                                    <a href="{{ route('payslip.download', $record) }}"
                                        class="text-green-600 hover:underline">Download</a>
                                    <form method="POST" action="{{ route('payroll.update', $record) }}">
                                        @csrf @method('PUT')
                                        <select name="status" onchange="this.form.submit()"
                                            class="text-xs border rounded px-2 py-1">
                                            <option value="pending" {{ $record->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="approved" {{ $record->status == 'approved' ? 'selected' : '' }}>
                                                Approved</option>
                                            <option value="paid" {{ $record->status == 'paid' ? 'selected' : '' }}>Paid
                                            </option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                    No payroll records found. Generate payroll first.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>