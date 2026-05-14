<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employees
            </h2>
            <a href="{{ route('employees.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add Employee
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

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Code</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Department</th>
                            <th class="px-6 py-3">Designation</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-mono text-xs">{{ $employee->employee_code }}</td>
                                <td class="px-6 py-4 font-medium">
                                    {{ $employee->user->name }}
                                    <div class="text-xs text-gray-400">{{ $employee->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $employee->department->name }}</td>
                                <td class="px-6 py-4">{{ $employee->designation }}</td>
                                <td class="px-6 py-4">
                                    @if($employee->status === 'active')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Active</span>
                                    @elseif($employee->status === 'inactive')
                                        <span
                                            class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Inactive</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Terminated</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('employees.show', $employee) }}"
                                        class="text-gray-600 hover:underline">View</a>
                                    <a href="{{ route('employees.edit', $employee) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                                        onsubmit="return confirm('Remove this employee?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    No employees found. Add your first employee.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>