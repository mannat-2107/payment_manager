<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">

        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Organization Departments</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Manage company structure and departmental units</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('departments.create') }}"
                        class="btn-primary flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Department
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

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 slide-in shadow-sm">
                    <div class="p-1.5 bg-rose-100 rounded-lg">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    </div>
                    <p class="font-bold text-sm">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Department Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @php
                $colors = [
                    ['bg'=>'#f0fdfa','icon'=>'#0f766e','border'=>'#ccfbf1','glow'=>'#14b8a6'],
                    ['bg'=>'#eff6ff','icon'=>'#1d4ed8','border'=>'#dbeafe','glow'=>'#3b82f6'],
                    ['bg'=>'#fff7ed','icon'=>'#c2410c','border'=>'#ffedd5','glow'=>'#f97316'],
                    ['bg'=>'#fdf2f8','icon'=>'#be185d','border'=>'#fce7f3','glow'=>'#ec4899'],
                ];
                @endphp
                @foreach($departments as $index => $dept)
                @php $color = $colors[$index % 4]; @endphp
                <div class="stat-card group bg-white rounded-2xl border border-slate-200 p-6 ani-{{ ($index % 4) + 1 }} relative overflow-hidden flex flex-col h-full">
                    <div class="absolute -right-6 -top-6 w-32 h-32 rounded-full blur-3xl opacity-20 transition-opacity group-hover:opacity-40" style="background-color: {{ $color['glow'] }}"></div>
                    
                    <div class="flex items-start justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transform transition-transform group-hover:scale-110 shadow-sm"
                             style="background: {{ $color['bg'] }}; border: 1px solid {{ $color['border'] }}">
                            <svg class="w-6 h-6" fill="none" stroke="{{ $color['icon'] }}" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 text-[10px] px-2 py-1 rounded-md font-bold uppercase tracking-wider border border-slate-200">
                            Active
                        </span>
                    </div>
                    
                    <div class="flex-grow relative z-10">
                        <h3 class="text-lg font-bold text-slate-800 font-outfit mb-2">{{ $dept->name }}</h3>
                        <p class="text-sm text-slate-500 mb-4 line-clamp-2 leading-relaxed">{{ $dept->description ?? 'No specific description provided for this department.' }}</p>
                    </div>

                    <div class="mt-auto relative z-10">
                        <div class="flex items-end gap-2 mb-5 pb-5 border-b border-slate-100">
                            <span class="text-3xl font-bold text-slate-800 font-outfit leading-none">{{ $dept->employees_count }}</span>
                            <span class="text-xs font-semibold text-slate-500 mb-1">Assigned Staff</span>
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="{{ route('departments.edit', $dept) }}"
                               class="flex-1 flex items-center justify-center gap-1.5 text-xs bg-slate-50 border border-slate-200 text-slate-700 px-3 py-2 rounded-lg hover:bg-slate-100 transition-colors font-bold shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('departments.destroy', $dept) }}"
                                  onsubmit="return confirm('Delete this department? This will affect {{ $dept->employees_count }} employees.')" class="flex-1">
                                @csrf @method('DELETE')
                                <button class="w-full flex items-center justify-center gap-1.5 text-xs bg-rose-50 border border-rose-200 text-rose-600 px-3 py-2 rounded-lg hover:bg-rose-100 hover:text-rose-700 transition-colors font-bold shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                
                @if($departments->count() === 0)
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 flex flex-col items-center justify-center text-center shadow-sm ani-1">
                    <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-inner mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 font-outfit mb-2">No Departments Yet</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Get started by creating your first company department to organize your workforce efficiently.</p>
                    <a href="{{ route('departments.create') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Create Department
                    </a>
                </div>
                @endif
            </div>

            @if($departments->count() > 0)
            {{-- Summary Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden ani-3 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-base font-bold text-slate-800 font-outfit">Department Ledger</h3>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $departments->count() }} Units</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white">
                            <tr>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Department Name</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Description</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Total Employees</th>
                                <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider px-6 py-4 border-b border-slate-100">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($departments as $dept)
                            <tr class="row-hover">
                                <td class="px-6 py-5">
                                    <span class="text-sm font-bold text-slate-800">{{ $dept->name }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm font-medium text-slate-500 line-clamp-1">{{ $dept->description ?? 'No description provided' }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600 font-bold text-sm border border-teal-100">
                                            {{ $dept->employees_count }}
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">Active Staff</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs px-2.5 py-1 rounded-md font-bold tracking-wide">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                        Active
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>