@props(['totalGross', 'totalPF', 'totalTDS', 'totalESI', 'totalNet'])

<div class="p-5 h-full flex flex-col" style="background:var(--sys-surface-2)">
    <p class="text-[10px] font-bold uppercase tracking-widest mb-4 font-mono-code" style="color:var(--sys-text-3)">Financials</p>

    <div class="space-y-0 flex-1">

        <div class="flex justify-between items-center py-2.5 border-b" style="border-color:var(--sys-border)">
            <p class="text-xs" style="color:var(--sys-text-2)">Gross</p>
            <p class="text-xs font-bold font-mono-code" style="color:var(--sys-text)">₹{{ number_format($totalGross, 0) }}</p>
        </div>

        <div class="flex justify-between items-center py-2.5 border-b" style="border-color:var(--sys-border)">
            <p class="text-xs" style="color:var(--sys-text-2)">PF</p>
            <p class="text-xs font-bold font-mono-code" style="color:var(--sys-danger)">-₹{{ number_format($totalPF, 0) }}</p>
        </div>

        <div class="flex justify-between items-center py-2.5 border-b" style="border-color:var(--sys-border)">
            <p class="text-xs" style="color:var(--sys-text-2)">TDS</p>
            <p class="text-xs font-bold font-mono-code" style="color:var(--sys-danger)">-₹{{ number_format($totalTDS, 0) }}</p>
        </div>

        <div class="flex justify-between items-center py-2.5 border-b" style="border-color:var(--sys-border)">
            <p class="text-xs" style="color:var(--sys-text-2)">ESI</p>
            <p class="text-xs font-bold font-mono-code" style="color:var(--sys-danger)">-₹{{ number_format($totalESI, 0) }}</p>
        </div>

        <div class="flex justify-between items-center py-3 px-3 mt-3 rounded-xl" style="background:rgba(13,148,136,0.12); border:1px solid var(--sys-primary);">
            <p class="text-xs font-bold" style="color:var(--sys-primary)">Net</p>
            <p class="text-sm font-bold font-mono-code" style="color:var(--sys-primary)">₹{{ number_format($totalNet, 0) }}</p>
        </div>

    </div>
</div>
