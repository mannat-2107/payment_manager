<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Salary Structure
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('salary-structures.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                        <select name="employee_id" class="w-full border rounded px-3 py-2">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->user->name }} ({{ $emp->employee_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="text-lg font-medium text-gray-800 mb-4 mt-6">Earnings</h3>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Basic Salary</label>
                            <input type="number" name="basic" value="{{ old('basic', 0) }}"
                                class="w-full border rounded px-3 py-2" step="0.01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">HRA</label>
                            <input type="number" name="hra" value="{{ old('hra', 0) }}"
                                class="w-full border rounded px-3 py-2" step="0.01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Allowances</label>
                            <input type="number" name="allowances" value="{{ old('allowances', 0) }}"
                                class="w-full border rounded px-3 py-2" step="0.01">
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-800 mb-4 mt-6">Deductions</h3>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PF %</label>
                            <input type="number" name="pf_percentage" value="{{ old('pf_percentage', 12) }}"
                                class="w-full border rounded px-3 py-2" step="0.01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ESI %</label>
                            <input type="number" name="esi_percentage" value="{{ old('esi_percentage', 1.75) }}"
                                class="w-full border rounded px-3 py-2" step="0.01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">TDS Amount</label>
                            <input type="number" name="tds" value="{{ old('tds', 0) }}"
                                class="w-full border rounded px-3 py-2" step="0.01">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Effective From</label>
                        <input type="date" name="effective_from" value="{{ old('effective_from') }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save Salary Structure
                        </button>
                        <a href="{{ route('salary-structures.index') }}"
                            class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>