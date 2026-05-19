@props(['totalPaid', 'totalEmployees', 'totalPending', 'totalFailed'])

<div class="grid grid-cols-2 lg:grid-cols-4 gap-0 divide-x divide-y lg:divide-y-0 bento-card border rounded-2xl overflow-hidden mb-0">

    {{-- Total Disbursed --}}
    <div class="stat-card p-5 group relative overflow-hidden">
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background:linear-gradient(135deg, rgba(13,148,136,0.04), transparent)"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-widest font-mono-code" style="color:var(--sys-text-3)">Disbursed</p>
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(13,148,136,0.12);">
                <svg class="w-3.5 h-3.5" style="color:var(--sys-primary)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold font-outfit tracking-tight relative z-10" style="color:var(--sys-text)">₹{{ number_format($totalPaid, 0) }}</p>
        <p class="text-[10px] font-semibold mt-1 flex items-center gap-1 relative z-10" style="color:var(--sys-primary)">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            Successful
        </p>
    </div>

    {{-- Active Workforce --}}
    <div class="stat-card p-5 group relative overflow-hidden">
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background:linear-gradient(135deg, rgba(99,102,241,0.04), transparent)"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-widest font-mono-code" style="color:var(--sys-text-3)">Workforce</p>
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(99,102,241,0.12);">
                <svg class="w-3.5 h-3.5" style="color:var(--sys-accent)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold font-outfit tracking-tight relative z-10" style="color:var(--sys-text)">{{ $totalEmployees }}</p>
        <p class="text-[10px] font-semibold mt-1 relative z-10" style="color:var(--sys-accent)">Active employees</p>
    </div>

    {{-- In Progress --}}
    <div class="stat-card p-5 group relative overflow-hidden">
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background:linear-gradient(135deg, rgba(245,158,11,0.04), transparent)"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-widest font-mono-code" style="color:var(--sys-text-3)">Processing</p>
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(245,158,11,0.12);">
                <svg class="w-3.5 h-3.5 pulse-soft" style="color:var(--sys-warn)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold font-outfit tracking-tight relative z-10" style="color:var(--sys-warn)">{{ $totalPending }}</p>
        <p class="text-[10px] font-semibold mt-1 flex items-center gap-1 relative z-10" style="color:var(--sys-warn)">
            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:var(--sys-warn);display:inline-block;"></span>
            In transit
        </p>
    </div>

    {{-- Failed --}}
    <div class="stat-card p-5 group relative overflow-hidden">
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background:linear-gradient(135deg, rgba(225,29,72,0.04), transparent)"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-widest font-mono-code" style="color:var(--sys-text-3)">Failed</p>
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(225,29,72,0.12);">
                <svg class="w-3.5 h-3.5" style="color:var(--sys-danger)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold font-outfit tracking-tight relative z-10" style="color:var(--sys-danger)">{{ $totalFailed }}</p>
        <p class="text-[10px] font-semibold mt-1 relative z-10" style="color:var(--sys-danger)">Needs attention</p>
    </div>

</div>
