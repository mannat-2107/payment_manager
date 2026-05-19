<div class="p-5 h-full flex flex-col">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-sm font-bold font-outfit" style="color:var(--sys-text)">Payroll Analytics</h3>
        <div class="flex items-center gap-1 p-1 rounded-lg" style="background:var(--sys-surface-2);border:1px solid var(--sys-border);">
            <button class="px-2.5 py-1 text-[10px] font-bold rounded-md" style="background:var(--sys-surface);color:var(--sys-text);box-shadow:0 1px 3px rgba(0,0,0,0.08);">Monthly</button>
            <button class="px-2.5 py-1 text-[10px] font-bold" style="color:var(--sys-text-3);">Yearly</button>
        </div>
    </div>
    <div class="flex-1 min-h-[220px]">
        <canvas id="payrollChart"></canvas>
    </div>
</div>
