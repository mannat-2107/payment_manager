<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .ani-1 {
            animation: fadeInUp .4s ease both
        }

        .ani-2 {
            animation: fadeInUp .4s .1s ease both
        }

        .ani-3 {
            animation: fadeInUp .4s .2s ease both
        }

        .row-hover {
            transition: background .15s
        }

        .row-hover:hover {
            background: #f8fafc
        }

        .stat-card {
            transition: transform .2s, box-shadow .2s
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08)
        }
    </style>

    <div class="min-h-screen bg-gray-50">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Employees</h2>
                    <p class="text-sm text-gray-400 mt-1">Manage your workforce</p>
                </div>
                <a href="{{ route('employees.create') }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Employee
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 ani-1">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-4 gap-5 mb-8">
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Total</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $employees->count() }}</p>
                    <p class="text-xs text-blue-500 mt-1">All employees</p>
                </div>
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Active</p>
                    <p class="text-3xl font-bold text-green-600">{{ $employees->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-green-500 mt-1">Currently working</p>
                </div>
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Inactive</p>
                    <p class="text-3xl font-bold text-yellow-500">{{ $employees->where('status', 'inactive')->count() }}
                    </p>
                    <p class="text-xs text-yellow-500 mt-1">On leave</p>
                </div>
                <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-2">Departments</p>
                    <p class="text-3xl font-bold text-purple-600">
                        {{ $employees->pluck('department_id')->unique()->count() }}</p>
                    <p class="text-xs text-purple-500 mt-1">Active departments</p>
                </div>
            </div>

            {{-- Search --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-6 ani-2">
                <form method="GET" action="{{ route('employees.index') }}" class="flex gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, email or employee code..."
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="department"
                        class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Departments</option>
                        @foreach(\App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status"
                        class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated
                        </option>
                    </select>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                        Search
                    </button>
                    <a href="{{ route('employees.index') }}"
                        class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-3">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Employee List</h3>
                    <span class="text-sm text-gray-400">{{ $employees->count() }} employees</span>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employee</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Department</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Designation</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Joined</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Bank</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($employees as $employee)
                            <tr class="row-hover">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                                            style="background: {{ ['#EFF6FF', '#F0FDF4', '#FEF3C7', '#FDF2F8', '#F5F3FF'][crc32($employee->user->name) % 5] }};
                                                color: {{ ['#1D4ED8', '#15803D', '#B45309', '#9D174D', '#6D28D9'][crc32($employee->user->name) % 5] }}">
                                            {{ strtoupper(substr($employee->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $employee->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $employee->user->email }}</p>
                                            <p class="text-xs font-mono text-gray-400">{{ $employee->employee_code }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                        {{ $employee->department->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $employee->designation }}</td>
                                <td class="px-6 py-4 text-sm text-gray-400">
                                    {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-600 font-medium">{{ $employee->bank_name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $employee->ifsc_code ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($employee->status === 'active')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Active
                                        </span>
                                    @elseif($employee->status === 'inactive')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>Inactive
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Terminated
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('employees.show', $employee) }}"
                                            class="text-xs bg-gray-50 border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition font-medium">
                                            View
                                        </a>
                                        <a href="{{ route('employees.edit', $employee) }}"
                                            class="text-xs bg-blue-50 border border-blue-200 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition font-medium">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                                            onsubmit="return confirm('Remove this employee?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="text-xs bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium">No employees found</p>
                                        <a href="{{ route('employees.create') }}"
                                            class="text-blue-600 text-sm hover:underline">Add your first employee →</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>