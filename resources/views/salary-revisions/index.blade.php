<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">Salary Revision History</h1>
            <p class="text-sm text-slate-500 mt-0.5">Track all salary increments across employees</p>
        </div>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-7xl mx-auto ani-1">
    <div class="glass-card rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Employee</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Department</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Revisions</th>
                    <th class="text-right px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($employees as $employee)
                <tr class="row-hover">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $employee->user?->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-slate-400">{{ $employee->employee_code }}</div>
                    </td>
                    <td class="px-5 py-4 text-slate-600">{{ $employee->department->name ?? '—' }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold
                            {{ $employee->salary_revisions_count > 0 ? 'bg-teal-100 text-teal-700' : 'bg-slate-100 text-slate-400' }}">
                            {{ $employee->salary_revisions_count }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <a href="{{ route('salary-revisions.show', $employee) }}"
                            class="px-4 py-1.5 text-xs font-semibold text-teal-700 border border-teal-200 hover:bg-teal-50 rounded-lg transition-all">
                            View History
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <p class="text-3xl mb-2">📊</p>
                        <p class="font-medium">No active employees found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
