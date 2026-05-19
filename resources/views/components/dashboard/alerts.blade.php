@props(['pendingPayrolls' => 0, 'totalPending' => 0])

<div class="flex flex-col gap-3 mb-6">
    {{-- Alert: Pending Payrolls --}}
    @if($pendingPayrolls > 0)
    <div x-data="{ showAlert: true }" x-show="showAlert" 
         class="slide-in bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl p-4 flex items-center justify-between text-white shadow-lg shadow-amber-500/20">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="font-bold text-sm">Action Required: Pending Payrolls</p>
                <p class="text-xs text-amber-50 opacity-90">You have {{ $pendingPayrolls }} payroll processes awaiting your approval or generation.</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('payroll.index') }}" class="text-xs font-bold bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg transition-colors">Review</a>
            <button @click="showAlert = false" class="p-1 hover:bg-white/20 rounded-lg transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Alert: Pending Transactions --}}
    @if($totalPending > 0)
    <div x-data="{ showAlert: true }" x-show="showAlert" 
         class="slide-in bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-4 flex items-center justify-between text-white shadow-lg shadow-blue-500/20" style="animation-delay: 0.1s;">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="font-bold text-sm">Processing Transactions</p>
                <p class="text-xs text-blue-50 opacity-90">There are {{ $totalPending }} payment transfers currently processing through the gateway.</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('transactions.index') }}" class="text-xs font-bold bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg transition-colors">View Ledger</a>
            <button @click="showAlert = false" class="p-1 hover:bg-white/20 rounded-lg transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Alert: System Healthy / Due Dates --}}
    @if($pendingPayrolls == 0 && $totalPending == 0)
    <div x-data="{ showAlert: true }" x-show="showAlert" 
         class="slide-in bg-gradient-to-r from-teal-500 to-emerald-600 rounded-xl p-4 flex items-center justify-between text-white shadow-lg shadow-teal-500/20">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="font-bold text-sm">System Healthy</p>
                <p class="text-xs text-teal-50 opacity-90">All processes are up to date. Next standard payroll generation is due on <span class="font-bold">{{ now()->endOfMonth()->format('d M, Y') }}</span>.</p>
            </div>
        </div>
        <button @click="showAlert = false" class="p-1 hover:bg-white/20 rounded-lg transition-colors focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif
</div>
