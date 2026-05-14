<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employee Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-bold">
                        {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ $employee->user->name }}</h3>
                        <p class="text-gray-500">{{ $employee->designation }}</p>
                        <span
                            class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">{{ $employee->employee_code }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Email</p>
                        <p class="font-medium">{{ $employee->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Phone</p>
                        <p class="font-medium">{{ $employee->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Department</p>
                        <p class="font-medium">{{ $employee->department->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Date of Joining</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Bank Name</p>
                        <p class="font-medium">{{ $employee->bank_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Account Number</p>
                        <p class="font-medium">{{ $employee->account_number ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">IFSC Code</p>
                        <p class="font-medium">{{ $employee->ifsc_code ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Status</p>
                        <p class="font-medium capitalize">{{ $employee->status }}</p>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('employees.edit', $employee) }}"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Edit Employee
                    </a>
                    <a href="{{ route('employees.index') }}"
                        class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>