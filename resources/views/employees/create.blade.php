<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">
        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-5xl mx-auto flex items-center gap-4">
                <a href="{{ route('employees.index') }}" class="p-2 bg-slate-50 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Onboard Employee</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Create a new employee profile and system account</p>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 slide-in">
            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl mb-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-1.5 bg-rose-100 rounded-lg">
                            <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="font-bold text-sm">Please correct the following errors:</p>
                    </div>
                    <ul class="list-disc pl-12 text-sm font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('employees.store') }}" class="space-y-6">
                @csrf

                {{-- Personal Info Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Personal Identity</h3>
                    </div>
                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Full Legal Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Work Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Primary Phone <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Date of Joining <span class="text-rose-500">*</span></label>
                            <input type="date" name="date_of_joining" value="{{ old('date_of_joining') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors cursor-pointer">
                        </div>
                    </div>
                </div>

                {{-- Job Info Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Employment Details</h3>
                    </div>
                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Department <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="department_id" required class="w-full pl-4 pr-10 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 hover:bg-white transition-colors cursor-pointer appearance-none">
                                    <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>Assign to department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Designation / Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="designation" value="{{ old('designation') }}" required
                                   placeholder="e.g. Senior Software Engineer"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors">
                        </div>
                    </div>
                </div>

                {{-- Bank Details Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Banking & Payroll</h3>
                    </div>
                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bank Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Account Number <span class="text-rose-500">*</span></label>
                            <input type="text" name="account_number" value="{{ old('account_number') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors font-mono tracking-wider">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">IFSC / Routing Code <span class="text-rose-500">*</span></label>
                            <input type="text" name="ifsc_code" value="{{ old('ifsc_code') }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors font-mono uppercase tracking-wider">
                        </div>
                    </div>
                </div>

                {{-- Info Box & Actions --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-amber-100 rounded-lg flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-amber-900">Account Generation Note</p>
                                <p class="text-sm font-medium text-amber-700 mt-1">Saving this profile will automatically generate a system User account with default credentials.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <a href="{{ route('employees.index') }}"
                               class="w-full md:w-auto text-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="w-full md:w-auto btn-primary flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Save & Onboard
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>