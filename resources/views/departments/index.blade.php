<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.ani-1{animation:fadeInUp .4s ease both}
.ani-2{animation:fadeInUp .4s .1s ease both}
.ani-3{animation:fadeInUp .4s .2s ease both}
.dept-card{transition:transform .2s,box-shadow .2s}
.dept-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,0.08)}
</style>

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Departments</h2>
                <p class="text-sm text-gray-400 mt-1">Manage company departments</p>
            </div>
            <a href="{{ route('departments.create') }}"
               class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Department
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

        {{-- Department Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            @php
            $colors = [
                ['bg'=>'#EFF6FF','icon'=>'#1D4ED8','border'=>'#BFDBFE'],
                ['bg'=>'#F0FDF4','icon'=>'#15803D','border'=>'#BBF7D0'],
                ['bg'=>'#FEF3C7','icon'=>'#B45309','border'=>'#FDE68A'],
                ['bg'=>'#FDF4FF','icon'=>'#7E22CE','border'=>'#E9D5FF'],
            ];
            @endphp
            @foreach($departments as $index => $dept)
            @php $color = $colors[$index % 4]; @endphp
            <div class="dept-card bg-white rounded-2xl border border-gray-100 p-6 ani-{{ $index + 1 }}">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4"
                     style="background: {{ $color['bg'] }}; border: 1px solid {{ $color['border'] }}">
                    <svg class="w-6 h-6" fill="none" stroke="{{ $color['icon'] }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-1">{{ $dept->name }}</h3>
                <p class="text-xs text-gray-400 mb-3">{{ $dept->description ?? 'No description' }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-gray-800">{{ $dept->employees_count }}</span>
                    <span class="text-xs text-gray-400">employees</span>
                </div>
                <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('departments.edit', $dept) }}"
                       class="flex-1 text-center text-xs bg-blue-50 border border-blue-200 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition font-medium">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('departments.destroy', $dept) }}"
                          onsubmit="return confirm('Delete this department?')" class="flex-1">
                        @csrf @method('DELETE')
                        <button class="w-full text-xs bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Summary Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-3">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Department Summary</h3>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Department</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Description</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employees</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($departments as $dept)
                    <tr>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $dept->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $dept->description ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                {{ $dept->employees_count }} staff
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Active
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>