<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.ani-1{animation:fadeInUp .4s ease both}
.ani-2{animation:fadeInUp .4s .1s ease both}
.ani-3{animation:fadeInUp .4s .2s ease both}
.row-hover{transition:background .15s}
.row-hover:hover{background:#f8fafc}
.stat-card{transition:transform .2s,box-shadow .2s}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.08)}
</style>

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Salary Structures</h2>
                <p class="text-sm text-gray-400 mt-1">Define and manage employee salary components</p>
            </div>
            <a href="{{ route('salary-structures.create') }}"
               class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Salary Structure
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 ani-1">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-5 mb-8">
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total Structures</p>
                <p class="text-3xl font-bold text-gray-800">{{ $salaries->count() }}</p>
                <p class="text-xs text-blue-500 mt-1">Configured employees</p>
            </div>
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Avg Basic Salary</p>
                <p class="text-3xl font-bold text-purple-600">
                    ₹{{ $salaries->count() > 0 ? number_format($salaries->avg('basic'), 0) : 0 }}
                </p>
                <p class="text-xs text-purple-500 mt-1">Average across all</p>
            </div>
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total Monthly</p>
                <p class="text-3xl font-bold text-green-600">
                    ₹{{ number_format($salaries->sum(fn($s) => $s->basic + $s->hra + $s->allowances), 0) }}
                </p>
                <p class="text-xs text-green-500 mt-1">Total gross payable</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-3">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">All Salary Structures</h3>
                <span class="text-sm text-gray-400">{{ $salaries->count() }} records</span>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employee</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Basic</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">HRA</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Allowances</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Gross</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Deductions</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Net</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($salaries as $salary)
                    <tr class="row-hover">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($salary->employee->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $salary->employee->user->name }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $salary->employee->employee_code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">₹{{ number_format($salary->basic, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">₹{{ number_format($salary->hra, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">₹{{ number_format($salary->allowances, 0) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">₹{{ number_format($salary->calculateGross(), 0) }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-red-500">
                            ₹{{ number_format($salary->calculateDeductions(), 0) }}
                            <div class="text-xs text-gray-400 mt-0.5">PF {{ $salary->pf_percentage }}% · ESI {{ $salary->esi_percentage }}%</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">₹{{ number_format($salary->calculateNet(), 0) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('salary-structures.edit', $salary) }}"
                                   class="text-xs bg-blue-50 border border-blue-200 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('salary-structures.destroy', $salary) }}"
                                      onsubmit="return confirm('Delete this salary structure?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <p class="text-gray-400 text-sm">No salary structures yet.</p>
                            <a href="{{ route('salary-structures.create') }}"
                               class="text-blue-600 text-sm hover:underline">Add first salary structure →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>