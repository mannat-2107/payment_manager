<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Salary Structures
            </h2>
            <a href="{{ route('salary-structures.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add Salary Structure
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
                            <th class="px-6 py-3">Employee</th>
                            <th class="px-6 py-3">Basic</th>
                            <th class="px-6 py-3">HRA</th>
                            <th class="px-6 py-3">Allowances</th>
                            <th class="px-6 py-3">Gross</th>
                            <th class="px-6 py-3">PF %</th>
                            <th class="px-6 py-3">ESI %</th>
                            <th class="px-6 py-3">TDS</th>
                            <th class="px-6 py-3">Net</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($salaries as $salary)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">
                                    {{ $salary->employee->user->name }}
                                </td>
                                <td class="px-6 py-4">₹{{ number_format($salary->basic, 2) }}</td>
                                <td class="px-6 py-4">₹{{ number_format($salary->hra, 2) }}</td>
                                <td class="px-6 py-4">₹{{ number_format($salary->allowances, 2) }}</td>
                                <td class="px-6 py-4 font-medium">₹{{ number_format($salary->calculateGross(), 2) }}</td>
                                <td class="px-6 py-4">{{ $salary->pf_percentage }}%</td>
                                <td class="px-6 py-4">{{ $salary->esi_percentage }}%</td>
                                <td class="px-6 py-4">₹{{ number_format($salary->tds, 2) }}</td>
                                <td class="px-6 py-4 font-medium text-green-600">
                                    ₹{{ number_format($salary->calculateNet(), 2) }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('salary-structures.edit', $salary) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('salary-structures.destroy', $salary) }}"
                                        onsubmit="return confirm('Delete this salary structure?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-gray-400">
                                    No salary structures found. Add one first.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>