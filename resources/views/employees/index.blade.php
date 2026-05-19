<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">

        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Workforce Directory</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Manage your employees, roles, and statuses</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('employees.create') }}"
                        class="btn-primary flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Employee
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 slide-in shadow-sm">
                    <div class="p-1.5 bg-emerald-100 rounded-lg">
                        <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-1 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Total Staff</p>
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $employees->count() }}</p>
                    <p class="text-xs text-blue-600 mt-2 font-semibold relative z-10">All registered employees</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-2 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-teal-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Active</p>
                        <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $employees->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-teal-600 mt-2 font-semibold relative z-10">Currently deployed</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-3 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Inactive</p>
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $employees->where('status', 'inactive')->count() }}</p>
                    <p class="text-xs text-amber-500 mt-2 font-semibold relative z-10">On leave or suspended</p>
                </div>

                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-4 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Departments</p>
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 transform transition-transform group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-800 font-outfit tracking-tight relative z-10">{{ $employees->pluck('department_id')->unique()->count() }}</p>
                    <p class="text-xs text-indigo-500 mt-2 font-semibold relative z-10">Active business units</p>
                </div>
            </div>

            {{-- Filter & Search --}}
            <div class="glass-card rounded-2xl p-6 mb-8 ani-2">
                <form method="GET" action="{{ route('employees.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, email or code..."
                            class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all shadow-sm">
                    </div>
                    <div class="relative min-w-[200px]">
                        <select name="department" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 appearance-none focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all shadow-sm">
                            <option value="">All Departments</option>
                            @foreach(\App\Models\Department::all() as $dept)
                                <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    <div class="relative min-w-[180px]">
                        <select name="status" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 appearance-none focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-slate-800 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-slate-900 transition-all shadow-sm flex items-center justify-center gap-2">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'department', 'status']))
                        <a href="{{ route('employees.index') }}" class="bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-xl text-sm font-bold hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden ani-3 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-base font-bold text-slate-800 font-outfit">Employee Roster</h3>
                    <span class="text-xs font-bold text-teal-600 bg-teal-50 border border-teal-100 px-3 py-1 rounded-full">{{ $employees->count() }} Records</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white">
                            <tr>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Profile</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Department / Role</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Joined Date</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Banking Info</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Status</th>
                                <th class="text-right text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($employees as $employee)
                                <tr class="row-hover">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 shadow-sm border border-slate-200"
                                                style="background: {{ ['#f0fdfa', '#eff6ff', '#fef3c7', '#fdf2f8', '#f5f3ff'][crc32($employee->user?->name ?? 'Unknown') % 5] }};
                                                    color: {{ ['#0f766e', '#1d4ed8', '#b45309', '#9d174d', '#6d28d9'][crc32($employee->user?->name ?? 'Unknown') % 5] }}">
                                                {{ strtoupper(substr($employee->user?->name ?? 'Unknown', 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">{{ $employee->user?->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-slate-500 mb-0.5">{{ $employee->user->email }}</p>
                                                <p class="text-[11px] font-mono font-semibold text-slate-400 tracking-wide">{{ $employee->employee_code }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 mb-1.5">
                                            {{ $employee->department->name }}
                                        </span>
                                        <p class="text-sm font-medium text-slate-600">{{ $employee->designation }}</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-medium text-slate-700">
                                            {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                                        </p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            {{ \Carbon\Carbon::parse($employee->date_of_joining)->diffForHumans() }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($employee->bank_name)
                                            <p class="text-sm font-medium text-slate-700">{{ $employee->bank_name }}</p>
                                            <p class="text-[11px] text-slate-400 font-mono tracking-wide mt-0.5">{{ $employee->ifsc_code }}</p>
                                        @else
                                            <p class="text-sm text-slate-400 italic">Pending Setup</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($employee->status === 'active')
                                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                                Active
                                            </span>
                                        @elseif($employee->status === 'inactive')
                                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                                Inactive
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 border border-rose-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                                Terminated
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('employees.show', $employee) }}" class="p-2 bg-slate-50 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="{{ route('employees.edit', $employee) }}" class="p-2 bg-teal-50 border border-teal-200 text-teal-600 rounded-lg hover:bg-teal-100 hover:text-teal-700 transition-colors" title="Edit Staff">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('Remove this employee? This action cannot be undone.')">
                                                @csrf @method('DELETE')
                                                <button class="p-2 bg-rose-50 border border-rose-200 text-rose-600 rounded-lg hover:bg-rose-100 hover:text-rose-700 transition-colors" title="Remove Staff">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-inner">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-slate-800 font-bold text-lg font-outfit mb-1">No Employees Found</p>
                                                <p class="text-slate-500 text-sm">Your workforce directory is currently empty or matches no filters.</p>
                                            </div>
                                            <a href="{{ route('employees.create') }}" class="mt-2 text-teal-600 font-bold text-sm hover:text-teal-700 hover:underline flex items-center gap-1">
                                                Add your first employee <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>