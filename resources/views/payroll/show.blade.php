<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payroll Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-bold">
                        {{ strtoupper(substr($payroll->employee->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ $payroll->employee->user->name }}</h3>
                        <p class="text-gray-500">{{ $payroll->employee->designation }}</p>
                        <p class="text-sm text-gray-400">
                            {{ DateTime::createFromFormat('!m', $payroll->month)->format('F') }}
                            {{ $payroll->year }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-700 mb-3">Earnings</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Basic</span>
                                <span>₹{{ number_format($payroll->basic, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">HRA</span>
                                <span>₹{{ number_format($payroll->hra, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Allowances</span>
                                <span>₹{{ number_format($payroll->allowances, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-medium border-t pt-2">
                                <span>Gross</span>
                                <span>₹{{ number_format($payroll->gross, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-700 mb-3">Deductions</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">PF</span>
                                <span class="text-red-600">₹{{ number_format($payroll->pf, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">ESI</span>
                                <span class="text-red-600">₹{{ number_format($payroll->esi, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">TDS</span>
                                <span class="text-red-600">₹{{ number_format($payroll->tds, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-medium border-t pt-2">
                                <span>Total Deductions</span>
                                <span class="text-red-600">₹{{ number_format($payroll->total_deductions, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 flex justify-between items-center mb-6">
                    <span class="text-lg font-semibold text-gray-700">Net Salary</span>
                    <span class="text-2xl font-bold text-green-600">₹{{ number_format($payroll->net_salary, 2) }}</span>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('payroll.index') }}"
                       class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">
                        Back to Payroll
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>