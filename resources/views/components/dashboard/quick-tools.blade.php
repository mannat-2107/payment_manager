<div class="p-5 h-full flex flex-col">
    <p class="text-[10px] font-bold uppercase tracking-widest mb-4 font-mono-code" style="color:var(--sys-text-3)">Quick Tools</p>
    <div class="grid grid-cols-2 gap-2 flex-1">

        <a href="{{ route('transactions.create') }}" class="quick-btn group flex flex-col items-center justify-center rounded-xl p-3 text-center border">
            <div class="w-9 h-9 rounded-full flex items-center justify-center mb-2 transition-all duration-300 group-hover:scale-110" style="background:rgba(13,148,136,0.12);">
                <svg class="w-4 h-4" style="color:var(--sys-primary)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <p class="text-[11px] font-bold" style="color:var(--sys-text-2)">New Transfer</p>
        </a>

        <a href="{{ route('employees.create') }}" class="quick-btn group flex flex-col items-center justify-center rounded-xl p-3 text-center border">
            <div class="w-9 h-9 rounded-full flex items-center justify-center mb-2 transition-all duration-300 group-hover:scale-110" style="background:rgba(99,102,241,0.12);">
                <svg class="w-4 h-4" style="color:var(--sys-accent)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <p class="text-[11px] font-bold" style="color:var(--sys-text-2)">Add Staff</p>
        </a>

        <a href="{{ route('payroll.create') }}" class="quick-btn group flex flex-col items-center justify-center rounded-xl p-3 text-center border">
            <div class="w-9 h-9 rounded-full flex items-center justify-center mb-2 transition-all duration-300 group-hover:scale-110" style="background:rgba(245,158,11,0.12);">
                <svg class="w-4 h-4" style="color:var(--sys-warn)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-[11px] font-bold" style="color:var(--sys-text-2)">Batch Payroll</p>
        </a>

        <a href="{{ route('salary-structures.create') }}" class="quick-btn group flex flex-col items-center justify-center rounded-xl p-3 text-center border">
            <div class="w-9 h-9 rounded-full flex items-center justify-center mb-2 transition-all duration-300 group-hover:scale-110" style="background:rgba(225,29,72,0.1);">
                <svg class="w-4 h-4" style="color:var(--sys-danger)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-[11px] font-bold" style="color:var(--sys-text-2)">Adjust Salary</p>
        </a>

    </div>
</div>
