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
                        {{ strtoupper(substr($employee->user?->name ?? 'Unknown', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ $employee->user?->name ?? 'Unknown' }}</h3>
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

                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="{{ route('employees.edit', $employee) }}"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                        ✏️ Edit Employee
                    </a>
                    <a href="{{ route('employee-documents.index', $employee) }}"
                        class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-700 text-sm font-medium">
                        📂 Documents
                    </a>
                    <a href="{{ route('salary-revisions.show', $employee) }}"
                        class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 text-sm font-medium">
                        📈 Salary History
                    </a>
                    <a href="{{ route('leave.index') }}?employee={{ $employee->id }}"
                        class="bg-amber-500 text-white px-5 py-2 rounded-lg hover:bg-amber-600 text-sm font-medium">
                        🌴 Leave Requests
                    </a>
                    <a href="{{ route('employees.index') }}"
                        class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-200 text-sm font-medium">
                        ← Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>