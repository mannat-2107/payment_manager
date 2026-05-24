<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-slate-900 border-b border-white/10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ auth()->user()->hasRole('employee') ? route('portal.index') : route('dashboard') }}"
                   class="flex items-center gap-3 mr-6 no-underline group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-teal-500/30 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                            <path d="M18 12h.01" />
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <p class="font-outfit text-base font-bold text-white tracking-tight leading-tight">PayManager</p>
                        <p class="font-mono text-[10px] text-teal-400 font-medium leading-tight tracking-wider uppercase">Payroll Engine</p>
                    </div>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden sm:flex items-center gap-1.5">

                    @if(Auth::user()->hasAnyRole(['super-admin','hr-manager','accountant']))

                        {{-- ADMIN LINKS --}}
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('employees.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('employees.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Employees
                        </a>

                        <a href="{{ route('departments.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('departments.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Departments
                        </a>

                        <a href="{{ route('salary-structures.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('salary-structures.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Salary
                        </a>

                        <a href="{{ route('payroll.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('payroll.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Payroll
                        </a>

                        <a href="{{ route('transactions.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Transactions
                        </a>

                        <a href="{{ route('reports.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Reports
                        </a>

                        <a href="{{ route('leave.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('leave.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            Leave
                            @php $pl = \App\Models\LeaveRequest::where('status','pending')->count(); @endphp
                            @if($pl > 0)<span class="ml-1 text-[10px] font-bold bg-amber-500 text-white px-1.5 py-0.5 rounded-full">{{ $pl }}</span>@endif
                        </a>




                    @else

                        {{-- EMPLOYEE LINKS --}}
                        <a href="{{ route('portal.index') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('portal.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            My Dashboard
                        </a>

                        <a href="{{ route('profile.show') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 text-slate-400 hover:text-slate-200 hover:bg-white/5">
                            My Profile
                        </a>

                        <a href="{{ route('leave.my-leaves') }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('leave.*') ? 'bg-teal-500/15 text-teal-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                            My Leaves
                        </a>

                    @endif
                </div>
            </div>

            {{-- Right Side --}}
            <div class="hidden sm:flex items-center gap-3">

                @if(Auth::user()->hasAnyRole(['super-admin','hr-manager','accountant']))
                {{-- Pending Alert --}}
                @php
                    $pendingCount = \App\Models\PaymentTransaction::whereIn('status', ['initiated','processing'])->count();
                @endphp
                @if($pendingCount > 0)
                <a href="{{ route('transactions.index') }}?status=initiated"
                   class="flex items-center gap-2 px-3 py-1.5 bg-orange-500/10 border border-orange-500/20 rounded-lg text-xs font-semibold text-orange-400 hover:bg-orange-500/20 transition-colors">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                    {{ $pendingCount }} Pending
                </a>
                @endif

                {{-- New Transaction Button --}}
                <a href="{{ route('transactions.create') }}"
                   class="btn-primary flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-600 rounded-lg text-sm font-bold text-white shadow-lg shadow-teal-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Payment
                </a>
                @endif

                {{-- User Dropdown --}}
                <div class="relative ml-2" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen"
                            class="flex items-center gap-2.5 px-2.5 py-1.5 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="text-left hidden lg:block">
                            <p class="text-sm font-semibold text-slate-200 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-teal-400 font-mono leading-tight tracking-wide">
                                {{ Auth::user()->getRoleNames()->first() ?? 'user' }}
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="userOpen"
                         @click.away="userOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-64 bg-slate-800 border border-slate-700 rounded-2xl p-2 z-50 shadow-2xl"
                         x-cloak>

                        {{-- User Info --}}
                        <div class="p-3 mb-2 border-b border-slate-700/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-sm font-bold text-white shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-200">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="inline-flex items-center gap-1.5 bg-teal-500/10 border border-teal-500/20 text-teal-400 text-xs font-semibold px-2.5 py-0.5 rounded-full font-mono">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                                    {{ ucfirst(str_replace('-', ' ', Auth::user()->getRoleNames()->first() ?? 'user')) }}
                                </span>
                            </div>
                        </div>

                        {{-- Menu Items --}}
                        @if(Auth::user()->hasRole('employee'))
                            <a href="{{ route('portal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                My Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Admin Dashboard
                            </a>
                        @endif

                        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Settings
                        </a>

                        @if(Auth::user()->hasAnyRole(['super-admin','hr-manager','accountant']))
                        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Reports
                        </a>
                        @endif

                        <div class="mt-2 pt-2 border-t border-slate-700/50">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button @click.prevent="$root.submit()"
                                        class="flex items-center gap-3 w-full px-3 py-2 rounded-xl text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors font-sans text-left">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hamburger Mobile --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-slate-800 border-t border-slate-700/50">
        <div class="px-2 pt-2 pb-3 space-y-1">

            @if(Auth::user()->hasAnyRole(['super-admin','hr-manager','accountant']))

                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Dashboard</a>
                <a href="{{ route('employees.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('employees.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Employees</a>
                <a href="{{ route('departments.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('departments.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Departments</a>
                <a href="{{ route('salary-structures.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('salary-structures.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Salary</a>
                <a href="{{ route('payroll.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('payroll.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Payroll</a>
                <a href="{{ route('transactions.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('transactions.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Transactions</a>
                <a href="{{ route('reports.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('reports.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Reports</a>
                <a href="{{ route('leave.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('leave.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">Leave</a>


            @else

                <a href="{{ route('portal.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('portal.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">My Dashboard</a>
                <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-700">My Profile</a>
                <a href="{{ route('leave.my-leaves') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('leave.*') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">My Leaves</a>

            @endif
        </div>

        {{-- Mobile User Section --}}
        <div class="pt-4 pb-1 border-t border-slate-700">
            <div class="flex items-center px-4 mb-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-sm font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-slate-400 font-mono">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-700">Settings</a>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button @click.prevent="$root.submit()" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>